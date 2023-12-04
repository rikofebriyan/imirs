<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        ];

        // Mail::send('emails.emailrequest', $data, function ($message) use ($email) {
        //     $message->to($email->email, 'PE-Digitalization')
        //         ->subject('I-Mirs Approval Notification - ' . $email->subject);
        //     $message->from('pe-digitalization2@outlook.com', 'PE-Digitalization');
        // });

        return redirect()->back()->with('success', 'Email Notifikasi Approval sudah dikirim');
    }
}
