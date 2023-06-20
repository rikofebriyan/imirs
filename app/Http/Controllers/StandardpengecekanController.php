<?php

namespace App\Http\Controllers;

use App\Models\ItemStandard;
use Illuminate\Http\Request;
use App\Models\Progresstrial;
use App\Models\MasterSparePart;
use App\Models\StandardPengecekan;
use App\Http\Controllers\Controller;

class StandardpengecekanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $join = StandardPengecekan::join('item_standards', 'standard_pengecekans.item_pengecekan_id', '=', 'item_standards.id')
            ->join('master_spare_parts', 'standard_pengecekans.master_spare_part_id', '=', 'master_spare_parts.id')
            ->select('standard_pengecekans.*', 'item_standards.item_standard', 'master_spare_parts.item_name')
            ->get();

        $tabel2 = MasterSparePart::all();
        $tabel3 = ItemStandard::all();
        $partr = StandardPengecekan::all()->sortByDesc('id');
        return view('matrix.standard_pengecekan', [
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
        $data = [
            'master_spare_part_id' => $request->master_spare_part_id,
            'item_pengecekan_id' => $request->item_check_id,
            'operation' => $request->operation,
            'standard_pengecekan_min' => ($request->standard_pengecekan_min) ? $request->standard_pengecekan_min : 0,
            'standard_pengecekan_max' => ($request->standard_pengecekan_max) ? $request->standard_pengecekan_max : 0,
            'unit_measurement' => $request->unit_measurement,
        ];

        // create new task
        StandardPengecekan::create($data);
        Progresstrial::create([
            'form_input_id' => $request->form_input_id,
            'item_check_id' => $request->item_check_id,
            'operation' => $request->operation,
            'standard_pengecekan_min' => $request->standard_pengecekan_min,
            'standard_pengecekan_max' => $request->standard_pengecekan_max,
            'unit_measurement' => $request->unit_measurement,
        ]);
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
        $data = StandardPengecekan::find($id);
        $masterDataPart = MasterSparePart::find($data->master_spare_part_id);
        $itemPengecekan = ItemStandard::all();
        return view('matrix.form-edit.standard_pengecekan_edit', [
            'data' => $data,
            'masterSparePart' => $masterDataPart,
            'itemPengecekan' => $itemPengecekan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        StandardPengecekan::find($request->id)->update($request->all());
        return redirect()->route('matrix.standard_pengecekan.index')->with('standard_pengecekan_edit_success', 'Standard Pengecekan updated successfully');
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
            'operation' => 'required',
        ]);
        StandardPengecekan::find($id)->update($request->all());
        return redirect()->back()->with('success', 'StandardPengecekan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StandardPengecekan::find($id)->delete();
        return redirect()->route('matrix.standard_pengecekan.index')->with('success', 'Task removed successfully');
    }
}
