<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\notifapprove;
use App\Mail\notifreject;
use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Email;

class WaitingApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->leftJoin('sparepartrepair.dbo.users', 'users.name', '=', 'waitingrepairs.nama_pic')
            ->leftJoin('sparepartrepair.dbo.keterangan_mtbfs', 'waitingrepairs.id', '=', 'keterangan_mtbfs.form_input_id')
            ->select('waitingrepairs.*', 'users.jabatan', 'users.id as user_id', 'keterangan_mtbfs.jenis_penggantian', 'keterangan_mtbfs.mau_rekondisi', 'keterangan_mtbfs.recondition_sheet')
            ->where('deleted', null)
            ->where('progress', '<>', 'finish')
            ->where('progress', '<>', 'Scrap')
            ->where('approval', null)
            ->orderBy('reg_sp', 'DESC')
            ->get();

        $user = DB::table('sparepartrepair.dbo.users')->get(['email', 'name']);

        return view('partrepair.waitingapprove', [
            'reqtzy' => $partr,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['approval'] = $request->approval;
        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->update($data);

        $ticket = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->first();
        $user = DB::table('sparepartrepair.dbo.users')->where('id', $request->user_id)->first();
        $email = (object) [
            'email' => $user->email,
            'subject' => $ticket->reg_sp
        ];

        $dataSend = [
            'reg_sp' => $ticket->reg_sp,
            'item_name' => $ticket->item_name,
            'item_type' => $ticket->item_type,
            'problem' => $ticket->problem,
            'section' => $ticket->section,
            'status' => 'Approved',
            'link' => route('partrepair.waitingtable.show', $ticket->id),
            'subject' => $ticket->reg_sp,
        ];

        $notifikasiEmail = 0;

        if ($notifikasiEmail == 1) {
            $dataEmail = DB::table('sparepartrepair.dbo.emails')->get()->last();
            $diffTime = Carbon::now()->diffInMinutes($dataEmail->send_time);

            if ($diffTime > 1 && Carbon::parse(now())->gt($dataEmail->send_time)) {
                Mail::to($email->email)
                    ->later(now(), new notifapprove($dataSend));

                Email::create([
                    'email' => $email->email,
                    'status' => 'Email Ticket Approved sudah dikirim - ' . $ticket->reg_sp,
                    'is_send' => 0,
                    'send_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $note = 'Email Ticket Approved telah dikirim';
            } else {
                sleep(15);
                Mail::to($email->email)
                    ->later(Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'), new notifapprove($dataSend));

                Email::create([
                    'email' => $email->email,
                    'status' => 'Email Ticket Approved sudah dikirim - ' . $ticket->reg_sp,
                    'is_send' => 0,
                    'send_time' => Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'),
                ]);

                $note = 'Email Ticket Approved akan dikirim pada pukul ' . Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s');
            }
        } else {
            $note = 'Ticket Approved. (Notifikasi email disabled)';
        }

        return redirect()->back()->with('success', $note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data['deleted'] = 1;
        $data['reason'] = "Rejected: " . $request->reason;
        $data['deleted_by'] = $request->deleted_by;
        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->update($data);

        $ticket = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->first();
        $user = DB::table('sparepartrepair.dbo.users')->where('id', $request->user_id)->first();
        $email = (object) [
            'email' => $user->email,
            'subject' => $ticket->reg_sp
        ];

        $dataSend = [
            'reg_sp' => $ticket->reg_sp,
            'item_name' => $ticket->item_name,
            'item_type' => $ticket->item_type,
            'problem' => $ticket->problem,
            'section' => $ticket->section,
            'status' => 'Rejected',
            'reason' => $request->reason,
            'subject' => $ticket->reg_sp,
        ];

        $notifikasiEmail = 0;

        if ($notifikasiEmail == 1) {
            $dataEmail = DB::table('sparepartrepair.dbo.emails')->get()->last();
            $diffTime = Carbon::now()->diffInMinutes($dataEmail->send_time);

            if ($diffTime > 1 && Carbon::parse(now())->gt($dataEmail->send_time)) {
                Mail::to($email->email)
                    ->later(now(), new notifreject($dataSend));

                Email::create([
                    'email' => $email->email,
                    'status' => 'Email ticket rejected sudah dikirim - ' . $ticket->reg_sp,
                    'is_send' => 0,
                    'send_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $note = 'Email ticket rejected telah dikirim';
            } else {
                sleep(15);
                Mail::to($email->email)
                    ->later(Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'), new notifreject($dataSend));

                Email::create([
                    'email' => $email->email,
                    'status' => 'Email ticket rejected sudah dikirim - ' . $ticket->reg_sp,
                    'is_send' => 0,
                    'send_time' => Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'),
                ]);

                $note = 'Email ticket rejected akan dikirim pada pukul ' . Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s');
            }
        } else {
            $note = 'Ticket rejected. (Notifikasi email disabled)';
        }

        return redirect()->back()->with('success', $note);
    }
}
