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
        // nouse sepertinya
        // $partr = Progresstrial::all()->sortByDesc('id');
        // return view('partrepair.progresstrialtable', [
        //     'reqtzy' => $partr,
        // ]);
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
        // $join = Progresstrial::where('form_input_id', $request->form_input_id)
        //     ->join('item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
        //     ->select('progresstrials.*', 'item_standards.item_standard')
        //     ->get();

        $join = DB::table('sparepartrepair.dbo.progresstrials')->where('form_input_id', $request->form_input_id)
            ->join('item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        foreach ($join as $joi) {
            $data['form_input_id'] = $request->data[$joi->id]['form_input_id'];
            $data['item_check_id'] = $request->data[$joi->id]['item_check_id'];
            $data['operation'] = $request->data[$joi->id]['operation'];
            $data['standard_pengecekan_min'] = $request->data[$joi->id]['standard_pengecekan_min'] ? $request->data[$joi->id]['standard_pengecekan_min'] : 0;
            // $data['standard_pengecekan_max'] = $request->data[$joi->id]['standard_pengecekan_max'] ? $request->data[$joi->id]['standard_pengecekan_max'] : 0;
            $data['standard_pengecekan_max'] = 0;
            $data['unit_measurement'] = $request->data[$joi->id]['unit_measurement'];
            $data['actual_pengecekan'] = $request->data[$joi->id]['actual_pengecekan'];
            $data['judgement'] = $request->data[$joi->id]['judgement'];
            $data['standard_pengecekan_id'] = $request->data[$joi->id]['standard_pengecekan_id'];

            // Progresstrial::find($request->data[$joi->id]['id'])->update($data);
            DB::table('sparepartrepair.dbo.progresstrials')->where('id', $request->data[$joi->id]['id'])->update($data);
        }

        // $request2 = Waitingrepair::find($request->form_input_id);
        // $request2->progress = 'Trial';
        // $request2->save();
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

        // $asu = Waitingrepair::where('id', $id)->first();
        // $join = StandardPengecekan::join('item_standards', 'standard_pengecekans.item_pengecekan_id', '=', 'item_standards.id')
        //     ->select('standard_pengecekans.*', 'item_standards.item_standard')
        //     ->where('standard_pengecekans.master_spare_part_id', $asu->item_id)
        //     ->get();

        // $itemstandard = ItemStandard::all();
        // $mastersparepart = MasterSparePart::all();
        // $maker = Maker::all();
        // $subcont = Subcont::all();
        // $user = User::all();
        // $progresspemakaian = Progresspemakaian::all();
        // $waitingrepair = Waitingrepair::find($id);
        // $progressrepair = Progresspemakaian::where('form_input_id', $id)->first();
        // return view('partrepair.progresstrial', [
        //     'waitingrepair'    => $waitingrepair,
        //     'progressrepair'    => $progressrepair,
        //     'user'    => $user,
        //     'subcont'    => $subcont,
        //     'maker'    => $maker,
        //     'mastersparepart'    => $mastersparepart,
        //     'progresspemakaian'    => $progresspemakaian,
        //     'itemstandard'    => $itemstandard,
        //     'asu'    => $asu,
        //     'join'    => $join,
        // ]);
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
        // $this->validate($request, [
        //     'standard_pengecekan' => 'required',
        // ]);
        // StandardPengecekan::find($id)->update($request->all());

        // return redirect()->back()->with('success', 'StandardPengecekan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Progresstrial::find($id)->delete();
        // return redirect()->route('partrepair.progresstrial.index')->with('success', 'Task removed successfully');
    }

    public function deleteTrial($id)
    {
        // Progresstrial::find($id)->delete();
        DB::table('sparepartrepair.dbo.progresstrials')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Task removed successfully');
    }

    public function updateTrial($id, Request $request)
    {
        // $this->validate($request, [
            // 'operation' => 'required',
            // 'standard_pengecekan_min' => 'required',
            // 'unit_measurement' => 'required',
        // ]);

        // Progresstrial::find($id)->update($request->all());
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
