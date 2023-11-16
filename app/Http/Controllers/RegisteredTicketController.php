<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RegisteredTicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
            ->where('deleted', null)
            ->get();

        return view('partrepair.registeredticket', [
            'reqtzy' => $partr,
        ]);
    }
}
