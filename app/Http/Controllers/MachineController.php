<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $join = DB::table('sparepartrepair.dbo.machines')
            ->leftJoin('lines', 'machines.line_id', '=', 'lines.id')
            ->select('machines.*', 'lines.name as line')
            ->get();

        $tabel2 = DB::table('sparepartrepair.dbo.lines')->get();
        $partr = DB::table('sparepartrepair.dbo.machines')->orderByDesc('id')->get();

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
        return redirect()->route('machine.index')->with('success', 'Your task added successfully!');
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

        DB::table('sparepartrepair.dbo.machines')->where('id', $id)->update([
            'line_id' => $request->line_id,
            'name' => $request->name,
        ]);
        return redirect()->route('machine.index')->with('success', 'Machine updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sparepartrepair.dbo.lines')->where('id', $id)->delete();
        return redirect()->route('machine.index')->with('success', 'Task removed successfully');
    }
}
