<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        // $join = Line::join('sections', 'lines.id', '=', 'sections.id')
        //     ->select('lines.*', 'sections.name as section')
        //     ->get();
        $join = DB::table('sparepartrepair.dbo.lines')
            ->leftJoin('sections', 'lines.section_id', '=', 'sections.id')
            ->select('lines.*', 'sections.name as section')
            ->get();

        // $sectionr = Section::all();
        // $partr = Line::all()->sortByDesc('id');
        $sectionr = DB::table('sparepartrepair.dbo.sections')->get();
        $partr = DB::table('sparepartrepair.dbo.lines')->orderByDesc('id')->get();

        return view('matrix.line', [
            'reqtzy' => $partr,
            'sectzy' => $sectionr,
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
            'section_id' => 'required',
        ]);

        // create new task
        Line::create($request->all());
        return redirect()->route('line.index')->with('success', 'Your task added successfully!');
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
        // Line::find($id)->update($request->all());
        DB::table('sparepartrepair.dbo.lines')->where('id', $id)->update([
            'section_id' => $request->section_id,
            'bu' => $request->bu,
            'name' => $request->name,
        ]);

        return redirect()->route('line.index')->with('success', 'Line updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Line::find($id)->delete();
        DB::table('sparepartrepair.dbo.lines')->where('id', $id)->delete();
        return redirect()->route('line.index')->with('success', 'Task removed successfully');
    }
}
