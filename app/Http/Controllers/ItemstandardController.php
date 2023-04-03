<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\ItemStandard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemstandardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tabel2 = Line::all();
        $partr = ItemStandard::all()->sortByDesc('id');
        return view('matrix.item_standard', [
            'reqtzy' => $partr,
            // 'tab2' => $tabel2,
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
        ItemStandard::find($id)->update($request->all());
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
        ItemStandard::find($id)->delete();
        return redirect()->route('item_standard.index')->with('success', 'Task removed successfully');
    }
}
