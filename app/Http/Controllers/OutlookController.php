<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class OutlookController extends Controller
{
    public function writeEmail()
    {
        // get path to the outlook application and store in the variable 
    $outlookPath = 'C:\Program Files\Microsoft Office\Office16\OUTLOOK.EXE';

    // create command to open outlook application
    $command = 'start "" "'.  $outlookPath .'"';

    // execute the command
    exec($command);

    return redirect('/home');
    }
}
