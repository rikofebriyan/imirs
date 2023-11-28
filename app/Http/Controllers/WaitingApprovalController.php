<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            ->select('waitingrepairs.*', 'users.jabatan', 'users.id as user_id')
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
        ];

        Mail::send('emails.notifApprove', $dataSend, function ($message) use ($email) {
            $message->to($email->email, 'PE-Digitalization')
                ->subject('I-MIRS Ticket Approved - ' . $email->subject);
            $message->from('pe-digitalization2@outlook.com', 'PE-Digitalization');
        });

        return redirect()->back()->with('success', 'Ticket Approved successfully');
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
            'reason' => $request->reason
        ];

        Mail::send('emails.notifReject', $dataSend, function ($message) use ($email) {
            $message->to($email->email, 'PE-Digitalization')
                ->subject('I-MIRS Ticket Rejected - ' . $email->subject);
            $message->from('pe-digitalization2@outlook.com', 'PE-Digitalization');
        });

        return redirect()->back()->with('success', 'Task removed successfully');
    }
}
