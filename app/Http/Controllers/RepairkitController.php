<?php

namespace App\Http\Controllers;

use App\Models\Maker;

use App\Http\Requests;
use App\Models\RepairKit;
use Illuminate\Http\Request;
use App\Models\MasterSparePart;
use App\Http\Controllers\Controller;

class RepairkitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $join = RepairKit::join('makers', 'repair_kits.maker', '=', 'makers.id')
            ->join('master_spare_parts', 'repair_kits.master_spare_part_id', '=', 'master_spare_parts.id')
            ->select('repair_kits.*', 'makers.name as maker_name', 'master_spare_parts.item_name as sparepart_name')
            ->get();
        // dd($join);
        $tabel2 = MasterSparePart::all();
        $tabel3 = Maker::all();
        $partr = RepairKit::all()->sortByDesc('id');
        return view('matrix.repairkit', [
            'reqtzy' => $partr,
            'tab2' => $tabel2,
            'tab3' => $tabel3,
            'join' => $join,
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
            'item_name' => 'required',
        ]);

        // create new task
        RepairKit::create($request->all());
        return redirect()->route('repair_kit.index')->with('success', 'Your task added successfully!');
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
            'item_name' => 'required',
        ]);
        RepairKit::find($id)->update($request->all());
        return redirect()->route('repair_kit.index')->with('success', 'RepairKit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RepairKit::find($id)->delete();
        return redirect()->route('repair_kit.index')->with('success', 'Task removed successfully');
    }
}
