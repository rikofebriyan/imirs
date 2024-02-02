<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Subcont;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Models\Progressrepair;
use Illuminate\Support\Carbon;
use App\Models\MasterSparePart;
use App\Models\Progresspemakaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\notifreject;
use App\Mail\notifscrap;
use Illuminate\Foundation\Auth\User;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;

class ProgressrepairController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
        $data = $request->all();
        $submit['form_input_id'] = $data['form_input_id'];
        $submit['place_of_repair'] = $data['place_of_repair'];
        $submit['analisa'] = $data['analisa'];
        $submit['action'] = $data['action'];
        $submit['judgement'] = $data['judgement'];
        $submit['pic_repair'] = $data['pic_repair'];
        $submit['plan_start_repair'] = $data['plan_start_repair'];
        $submit['plan_finish_repair'] = $data['plan_finish_repair'];
        $submit['actual_start_repair'] = $data['actual_start_repair'];
        $submit['actual_finish_repair'] = $data['actual_finish_repair'];
        $submit['total_time_repair'] = $data['total_time_repair'];
        $submit['labour_cost'] =  intval(preg_replace('/[^\d.]/', '', $data['labour_cost']));
        $submit['subcont_name'] = $data['subcont_name'];
        $submit['subcont_cost'] = intval(preg_replace('/[^\d.]/', '', $data['subcont_cost']));
        $submit['lead_time'] = $data['lead_time'];
        $submit['time_period'] = $data['time_period'];
        $submit['quotation'] = $data['no_quotation'];

        if ($request->place_of_repair == "In House") {
            if ($request->plan_start_repair != '') {
                $submit['plan_start_repair'] = Carbon::parse($request->plan_start_repair)->format('Y-m-d H:i');
            } else {
                $submit['plan_start_repair'] = null;
            }

            if ($request->plan_finish_repair != '') {
                $submit['plan_finish_repair'] = Carbon::parse($request->plan_finish_repair)->format('Y-m-d H:i');
            } else {
                $submit['plan_finish_repair'] = null;
            }

            if ($request->actual_start_repair != '') {
                $submit['actual_start_repair'] = Carbon::parse($request->actual_start_repair)->format('Y-m-d H:i');
            } else {
                $submit['actual_start_repair'] = null;
            }

            if ($request->actual_finish_repair != '') {
                $submit['actual_finish_repair'] = Carbon::parse($request->actual_finish_repair)->format('Y-m-d H:i');
            } else {
                $submit['actual_finish_repair'] = null;
            }
        } else {
            if ($request->plan_start_repair_subcont != '') {
                $submit['plan_start_repair'] = Carbon::parse($request->plan_start_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['plan_start_repair'] = null;
            }

            if ($request->plan_finish_repair_subcont != '') {
                $submit['plan_finish_repair'] = Carbon::parse($request->plan_finish_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['plan_finish_repair'] = null;
            }

            if ($request->actual_start_repair_subcont != '') {
                $submit['actual_start_repair'] = Carbon::parse($request->actual_start_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['actual_start_repair'] = null;
            }

            if ($request->actual_finish_repair_subcont != '') {
                $submit['actual_finish_repair'] = Carbon::parse($request->actual_finish_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['actual_finish_repair'] = null;
            }
        }

        $query = DB::table('sparepartrepair.dbo.progressrepairs')->where('form_input_id', $request->form_input_id)->first();
        if ($query != null) {
            DB::table('sparepartrepair.dbo.progressrepairs')->where('form_input_id', $request->form_input_id)->update($submit);
        } else {
            Progressrepair::create($submit);
        }
        $request2 = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $request->form_input_id)->first();

        if ($request->judgement == 'Scrap') {
            $request2->progress = 'Scrap';
        } else {
            $request2->progress = 'On Progress';
        }

        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $request->form_input_id)->update([
            'progress' => $request2->progress,
        ]);

        $user = DB::table('sparepartrepair.dbo.users')->where('name', $request->user_id)->first();
        $email = (object) [
            'email' => $user->email,
            'subject' => $request2->reg_sp
        ];

        $dataSend = [
            'reg_sp' => $request2->reg_sp,
            'item_name' => $request2->item_name,
            'item_type' => $request2->item_type,
            'problem' => $request2->problem,
            'section' => $request2->section,
            'status' => 'Scrap',
            'link' => route('partrepair.waitingtable.show', $request2->id),
            'subject' => $request2->reg_sp,
        ];

        if ($request->judgement == 'Scrap') {
            // notifikasi email bila ticket discrap

            $notifikasiEmail = 0;

            if ($notifikasiEmail == 1) {
                $dataEmail = DB::table('sparepartrepair.dbo.emails')->get()->last();
                $diffTime = Carbon::now()->diffInMinutes($dataEmail->send_time);

                if ($diffTime > 1 && Carbon::parse(now())->gt($dataEmail->send_time)) {
                    Mail::to($email->email)
                        ->later(now(), new notifscrap($dataSend));

                    Email::create([
                        'email' => $email->email,
                        'status' => 'Email Ticket Approved sudah dikirim - ' . $request2->reg_sp,
                        'is_send' => 0,
                        'send_time' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);

                    $note = 'Email Ticket Scrap telah dikirim';
                } else {
                    sleep(15);
                    Mail::to($email->email)
                        ->later(Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'), new notifscrap($dataSend));

                    Email::create([
                        'email' => $email->email,
                        'status' => 'Email Ticket Scrap sudah dikirim - ' . $request2->reg_sp,
                        'is_send' => 0,
                        'send_time' => Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'),
                    ]);

                    $note = 'Email Ticket Scrap akan dikirim pada pukul ' . Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s');
                }
            } else {
                $note = 'Ticket telah discrap. (Notifitkasi email disabled)';
            }

            return redirect()->route('partrepair.waitingtable.index')->with('success', $note);
        } else {
            return redirect()->back()->with('success', 'Your task added successfully!');
        }
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
     * @param  \Illuminate\Http\Request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function revision(Request $request, $id)
    {
        $this->validate($request, [
            'plan_finish_revision' => 'required',
        ]);
        $data['reason_revision'] = $request->reason_revision;
        $data['plan_start_revision'] = Carbon::parse($request->plan_start_revision)->format('Y-m-d H:i:s');
        $data['plan_finish_revision'] = Carbon::parse($request->plan_finish_revision)->format('Y-m-d H:i:s');

        progressrepair::where('form_input_id', $id)->first()->update($data);

        return redirect()->back()->with('success', 'Task updated successfully');
    }

    public function delay(Request $request, $id)
    {
        $this->validate($request, [
            'reason_delay' => 'required',
        ]);
        $data['reason_delay'] = $request->reason_delay;

        progressrepair::where('form_input_id', $id)->first()->update($data);

        return redirect()->back()->with('success', 'Task updated successfully');
    }
}
