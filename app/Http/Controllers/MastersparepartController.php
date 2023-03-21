<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSparePart;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Form;

class MastersparepartController extends Controller
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
        $partr = MasterSparePart::all()->sortByDesc('id');
        return view('matrix.master_spare_part', [
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
            'item_name' => 'required',
        ]);

        // create new task
        $data = $request->all();
        $data['code_item_description'] = $request->item_code . ' | ' . $request->item_name . ' | ' . $request->description;
        MasterSparePart::create($data);
        return redirect()->route('matrix.master_spare_part.index')->with('success', 'Your task added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        MasterSparePart::find($id)->delete();
        return redirect()->route('matrix.master_spare_part.index')->with('success', 'Task removed successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('ok');
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
        $data = $request->all();
        $data['code_item_description'] = $request->item_code . ' | ' . $request->item_name . ' | ' . $request->description;
        MasterSparePart::find($id)->update($data);
        return redirect()->route('matrix.master_spare_part.index')->with('success', 'MasterSparePart updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MasterSparePart::find($id)->delete();
        return redirect()->route('matrix.master_spare_part.index')->with('success', 'Task removed successfully');
    }
}
