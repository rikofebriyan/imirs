<?php

namespace App\Http\Controllers;

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
