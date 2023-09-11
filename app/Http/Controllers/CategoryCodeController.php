<?php

namespace App\Http\Controllers;

use App\Models\CategoryCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partr = DB::table('sparepartrepair.dbo.category_codes')->orderByDesc('id')->get();
        return view('matrix.category_code', [
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
        CategoryCode::create($request->all());
        return redirect()->back()->with('success', 'Your task added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryCode  $categoryCode
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryCode $categoryCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryCode  $categoryCode
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryCode $categoryCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryCodeRequest  $request
     * @param  \App\Models\CategoryCode  $categoryCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('sparepartrepair.dbo.category_codes')->where('id', $id)->update([
            'category' => $request->category,
            'category_code' => $request->category_code,
        ]);

        return redirect()->route('category_code.index')->with('success', 'CategoryCode updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryCode  $categoryCode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('sparepartrepair.dbo.category_codes')->where('id', $id)->delete();

        return redirect()->route('category_code.index')->with('success', 'Task removed successfully');
    }
}
