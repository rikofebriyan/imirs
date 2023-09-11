<?php

namespace App\Http\Controllers;

use App\Models\Subcont;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubcontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partr = DB::table('sparepartrepair.dbo.subconts')->orderByDesc('id')->get();

        return view('matrix.subcont', [
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
            'name' => 'required',
        ]);

        // create new task
        Subcont::create($request->all());
        return redirect()->route('subcont.index')->with('success', 'Your task added successfully!');
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

        DB::table('sparepartrepair.dbo.subconts')->where('id', $id)->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);

        return redirect()->route('subcont.index')->with('success', 'Subcont updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sparepartrepair.dbo.subconts')->where('id', $id)->delete();

        return redirect()->route('subcont.index')->with('success', 'Task removed successfully');
    }
}
