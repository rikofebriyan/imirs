<?php

namespace App\Http\Controllers;

use App\Models\ItemStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ItemstandardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partr = DB::table('sparepartrepair.dbo.item_standards')->orderByDesc('id')->get();

        return view('matrix.item_standard', [
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
        // validated input request
        $this->validate($request, [
            'item_standard' => 'required',
        ]);

        // create new task
        ItemStandard::create($request->all());
        return redirect()->route('item_standard.index')->with('success', 'Your task added successfully!');
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
        $this->validate($request, [
            'item_standard' => 'required',
        ]);

        DB::table('sparepartrepair.dbo.item_standards')->where('id', $id)->update([
            'item_standard' => $request->item_standard,
            'unit_measurement' => $request->unit_measurement,
        ]);

        return redirect()->route('item_standard.index')->with('success', 'ItemStandard updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sparepartrepair.dbo.item_standards')->where('id', $id)->delete();

        return redirect()->route('item_standard.index')->with('success', 'Task removed successfully');
    }
}
