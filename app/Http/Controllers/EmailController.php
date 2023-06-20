<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $email = $request->email;
        $data = [
            'reg_sp' => $request->reg_sp,
            'name' => $request->name,
            'section' => $request->section,
            'nama_requester' => $request->nama_requester,
            'spare_part' => $request->spare_part,
            'problem' => $request->problem,
        ];

        Mail::send('emails.emailrequest', $data, function ($message) use ($email) {
            $message->to($email, 'PE-Digitalization')
                ->subject('I-Mirs Approval Notification');
            $message->from('pe-digitalization@outlook.com', 'PE-Digitalization');
        });


        return redirect()->back()->with('success', 'Email Notifikasi Approval sudah dikirim');
    }
}
