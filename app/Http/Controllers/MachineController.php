<?php

namespace App\Http\Controllers;

use App\Models\Line;

use App\Http\Requests;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MachineController extends Controller
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

        $join = Machine::join('lines', 'machines.line_id', '=', 'lines.id')
            ->select('machines.*', 'lines.name as line')
            ->get();
        $tabel2 = Line::all();
        $partr = Machine::all()->sortByDesc('id');
        return view('matrix.machine', [
            'reqtzy' => $partr,
            'tab2' => $tabel2,
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
            'name' => 'required',
        ]);

        // create new task
        Machine::create($request->all());
        return redirect()->route('matrix.machine.index')->with('success', 'Your task added successfully!');
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
            'name' => 'required',
        ]);
        Machine::find($id)->update($request->all());
        return redirect()->route('matrix.machine.index')->with('success', 'Machine updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Machine::find($id)->delete();
        return redirect()->route('matrix.machine.index')->with('success', 'Task removed successfully');
    }
}
