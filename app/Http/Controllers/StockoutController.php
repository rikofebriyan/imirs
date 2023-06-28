<?php

namespace App\Http\Controllers;

use App\Models\Stockout;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StockoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partr = Waitingrepair::leftjoin('sparepartrepair.dbo.stockouts', 'waitingrepairs.id', '=', 'stockouts.form_input_id')
            ->select('waitingrepairs.id as waitingrepairid', 'waitingrepairs.*', 'stockouts.*')
            ->where('deleted', null)
            ->where('progress', 'finish')
            ->where('form_input_id', null)
            ->get();

        // $partr = DB::table('sparepartrepair.dbo.waitingrepairs')->leftjoin('sparepartrepair.dbo.stockouts', 'waitingrepairs.id', '=', 'stockouts.form_input_id')
        //     ->select('waitingrepairs.id as waitingrepairid', 'waitingrepairs.*', 'stockouts.*')
        //     ->where('deleted', null)
        //     ->where('progress', 'finish')
        //     ->where('form_input_id', null)
        //     ->get();

        return view('partrepair.stockout', [
            'reqtzy' => $partr,
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
        // create new task
        Stockout::create($request->all());

        return redirect()->back()->with('success', 'Your task added successfully!');
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
}
