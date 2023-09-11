<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class WaitingApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->leftJoin('sparepartrepair.dbo.users', 'users.name', '=', 'waitingrepairs.nama_pic')
            ->select('waitingrepairs.*', 'users.jabatan')
            ->where('deleted', null)
            ->where('progress', '<>', 'finish')
            ->where('progress', '<>', 'Scrap')
            ->where('approval', null)
            ->orderBy('reg_sp', 'DESC')
            ->get();
        $currentUser = Auth::user()->name;

        $user = DB::table('users')->get(['email', 'name']);

        return view('partrepair.waitingapprove', [
            'reqtzy' => $partr,
            'user' => $user,
            'currentUser' => $currentUser,
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
        //
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
        $data['approval'] = $request->approval;
        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Ticket Approved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data['deleted'] = 1;
        $data['reason'] = "Rejected: " . $request->reason;
        $data['deleted_by'] = $request->deleted_by;
        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Task removed successfully');
    }
}
