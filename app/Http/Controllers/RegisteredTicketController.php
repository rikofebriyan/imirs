<?php

namespace App\Http\Controllers;

use App\Http\Requests;



use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Http\Controllers\Controller;

class RegisteredTicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $partr = Waitingrepair::all()->sortByDesc('id');
        $partr = Waitingrepair::leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
            ->where('deleted', null)
            ->get();
        // dd($partr);
        return view('partrepair.registeredticket', [
            'reqtzy' => $partr,
        ]);
    }
}
