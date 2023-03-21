<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Mail\KirimEmail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        // $data = array(
        //     'name' => "Teman",
        // );
    
        // Mail::send('emails.demo', $data, function ($message) {
        //     $message->to('rikofebriyan@gmail.com', 'PE-Digitalization')
        //             ->subject('Test Email');
        //     $message->from('febriyanomov@gmail.com', 'PE-Digitalization');
        // });
    
        // return "Email telah terkirim!";
    }
}
