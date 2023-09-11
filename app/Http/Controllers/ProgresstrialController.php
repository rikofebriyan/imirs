<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Subcont;
use App\Models\ItemStandard;
use Illuminate\Http\Request;
use App\Models\Progresstrial;
use App\Models\Waitingrepair;
use App\Models\MasterSparePart;
use App\Models\Progresspemakaian;
use App\Models\StandardPengecekan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class ProgresstrialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $join = DB::table('sparepartrepair.dbo.progresstrials')->where('form_input_id', $request->form_input_id)
            ->join('item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        foreach ($join as $joi) {
            $data['form_input_id'] = $request->data[$joi->id]['form_input_id'];
            $data['item_check_id'] = $request->data[$joi->id]['item_check_id'];
            $data['operation'] = $request->data[$joi->id]['operation'];
            $data['standard_pengecekan_min'] = $request->data[$joi->id]['standard_pengecekan_min'] ? $request->data[$joi->id]['standard_pengecekan_min'] : 0;
            $data['standard_pengecekan_max'] = 0;
            $data['unit_measurement'] = $request->data[$joi->id]['unit_measurement'];
            $data['actual_pengecekan'] = $request->data[$joi->id]['actual_pengecekan'];
            $data['judgement'] = $request->data[$joi->id]['judgement'];
            $data['standard_pengecekan_id'] = $request->data[$joi->id]['standard_pengecekan_id'];

            DB::table('sparepartrepair.dbo.progresstrials')->where('id', $request->data[$joi->id]['id'])->update($data);
        }

        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $request->form_input_id)->update([
            'progress' => 'Trial',
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

    public function deleteTrial($id)
    {
        DB::table('sparepartrepair.dbo.progresstrials')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Task removed successfully');
    }

    public function updateTrial($id, Request $request)
    {
        DB::table('sparepartrepair.dbo.progresstrials')->where('id', $id)->update([
            'item_check_id' => $request->item_check_id,
            'standard_pengecekan_id' => null,
            'operation' => $request->operation,
            'standard_pengecekan_min' => $request->standard_pengecekan_min,
            'unit_measurement' => $request->unit_measurement,
        ]);

        return redirect()->back()->with('success', 'Task removed successfully');
    }
}
