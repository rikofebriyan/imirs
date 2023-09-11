<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Carbon;
use App\Models\Progresspemakaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProgresspemakaianController extends Controller
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
        // validated input request
        $this->validate($request, [
            'item_code' => 'required',
        ]);

        // create new task
        $data = $request->all();
        $data['price'] = str_replace(',', '', $data['price']);
        $data['total_price'] = str_replace(',', '', $data['total_price']);

        if ($request->estimasi_kedatangan != null) {
            $data['estimasi_kedatangan'] = Carbon::parse($request->estimasi_kedatangan)->format('Y-m-d H:i:s');
        } else {
            $data['estimasi_kedatangan'] = null;
        }
        Progresspemakaian::create($data);

        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $request->form_input_id)->update([
            'progress' => 'Seal Kit'
        ]);

        return redirect()->back()->with('success', 'Task added successfully');
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
        $this->validate($request, [
            'item_code' => 'required',
        ]);

        // create new task
        $data['status_part'] = $request->status_part;
        $data['price'] = intval(preg_replace('/[^\d.]/', '', $request->price));
        $data['total_price'] = intval(preg_replace('/[^\d.]/', '', $request->total_price));

        if ($request->estimasi_kedatangan != null) {
            $data['estimasi_kedatangan'] = Carbon::parse($request->estimasi_kedatangan)->format('Y-m-d H:i:s');
        } else {
            $data['estimasi_kedatangan'] = null;
        }

        if ($data['status_part'] == 'Ready') {
            $data['estimasi_kedatangan'] = null;
        }

        DB::table('sparepartrepair.dbo.progresspemakaians')->where('id', $id)->update([
            'form_input_id' => $request->form_input_id,
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'maker' => $request->maker,
            'qty' => $request->qty,
            'price' => $data['price'],
            'total_price' => $data['total_price'],
            'status_part' => $data['status_part'],
            'quotation' => null,
            'nomor_pp' => null,
            'nomor_po' => null,
            'estimasi_kedatangan' => $data['estimasi_kedatangan'],
        ]);

        return redirect()->back()->with('success', 'Task added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sparepartrepair.dbo.progresspemakaians')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Task removed successfully');
    }
}
