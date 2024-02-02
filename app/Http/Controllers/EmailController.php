<?php

namespace App\Http\Controllers;

use App\Mail\emailrequest;
use App\Models\Email;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $email = (object) [
            'email' => $request->email,
            'subject' => $request->reg_sp,
        ];
        $data = [
            'reg_sp' => $request->reg_sp,
            'name' => $request->name,
            'section' => $request->section,
            'nama_requester' => $request->nama_requester,
            'spare_part' => $request->spare_part,
            'problem' => $request->problem,
            'subject' => $request->reg_sp,
        ];

        $notifikasiEmail = 0;

        if ($notifikasiEmail == 1) {
            $dataEmail = DB::table('sparepartrepair.dbo.emails')->get()->last();
            $diffTime = Carbon::now()->diffInMinutes($dataEmail->send_time);

            if ($diffTime > 1 && Carbon::parse(now())->gt($dataEmail->send_time)) {
                Mail::to($email)
                    ->later(now(), new emailrequest($data));

                Email::create([
                    'email' => $email,
                    'status' => 'Email Notifikasi Approval sudah dikirim - ' . $request->reg_sp,
                    'is_send' => 0,
                    'send_time' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                $note = 'Email Notifikasi Approval telah dikirim';
            } else {
                sleep(15);
                Mail::to($email)
                    ->later(Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'), new emailrequest($data));

                Email::create([
                    'email' => $email,
                    'status' => 'Email Notifikasi Approval sudah dikirim - ' . $request->reg_sp,
                    'is_send' => 0,
                    'send_time' => Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s'),
                ]);

                $note = 'Email Notifikasi Approval akan dikirim pada pukul ' . Carbon::parse($dataEmail->send_time)->addMinutes(1)->format('Y-m-d H:i:s');
            }
        } else {
            $note = 'Notifikasi email disabled, silahkan hubungi SPV secara langsung';
        }

        return redirect()->back()->with('success', $note);
    }
}
