<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Subcont;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Models\Progressrepair;
use Illuminate\Support\Carbon;
use App\Models\MasterSparePart;
use App\Models\Progresspemakaian;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class ProgressrepairController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $partr = Progressrepair::all()->sortByDesc('id');
        return view('partrepair.progresstable', [
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
        $data = $request->all();
        $submit['form_input_id'] = $data['form_input_id'];
        $submit['place_of_repair'] = $data['place_of_repair'];
        $submit['analisa'] = $data['analisa'];
        $submit['action'] = $data['action'];
        $submit['judgement'] = $data['judgement'];
        $submit['pic_repair'] = $data['pic_repair'];
        $submit['plan_start_repair'] = $data['plan_start_repair'];
        $submit['plan_finish_repair'] = $data['plan_finish_repair'];
        $submit['actual_start_repair'] = $data['actual_start_repair'];
        $submit['actual_finish_repair'] = $data['actual_finish_repair'];
        $submit['total_time_repair'] = $data['total_time_repair'];
        $submit['labour_cost'] =  intval(preg_replace('/[^\d.]/', '', $data['labour_cost']));
        $submit['subcont_name'] = $data['subcont_name'];
        $submit['subcont_cost'] = $data['subcont_cost'];
        $submit['lead_time'] = $data['lead_time'];
        $submit['time_period'] = $data['time_period'];

        if ($request->place_of_repair == "In House") {
            if ($request->plan_start_repair != '') {
                $submit['plan_start_repair'] = Carbon::parse($request->plan_start_repair)->format('Y-m-d H:i');
            } else {
                $submit['plan_start_repair'] = null;
            }

            if ($request->plan_finish_repair != '') {
                $submit['plan_finish_repair'] = Carbon::parse($request->plan_finish_repair)->format('Y-m-d H:i');
            } else {
                $submit['plan_finish_repair'] = null;
            }

            if ($request->actual_start_repair != '') {
                $submit['actual_start_repair'] = Carbon::parse($request->actual_start_repair)->format('Y-m-d H:i');
            } else {
                $submit['actual_start_repair'] = null;
            }

            if ($request->actual_finish_repair != '') {
                $submit['actual_finish_repair'] = Carbon::parse($request->actual_finish_repair)->format('Y-m-d H:i');
            } else {
                $submit['actual_finish_repair'] = null;
            }
        } else {
            if ($request->plan_start_repair_subcont != '') {
                $submit['plan_start_repair'] = Carbon::parse($request->plan_start_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['plan_start_repair'] = null;
            }

            if ($request->plan_finish_repair_subcont != '') {
                $submit['plan_finish_repair'] = Carbon::parse($request->plan_finish_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['plan_finish_repair'] = null;
            }

            if ($request->actual_start_repair_subcont != '') {
                $submit['actual_start_repair'] = Carbon::parse($request->actual_start_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['actual_start_repair'] = null;
            }

            if ($request->actual_finish_repair_subcont != '') {
                $submit['actual_finish_repair'] = Carbon::parse($request->actual_finish_repair_subcont)->format('Y-m-d H:i');
            } else {
                $submit['actual_finish_repair'] = null;
            }
        }

        $query = Progressrepair::where('form_input_id', $request->form_input_id)->first();
        if ($query != null) {
            Progressrepair::where('form_input_id', $request->form_input_id)->update($submit);
        } else {
            Progressrepair::create($submit);
        }
        $request2 = Waitingrepair::find($request->form_input_id);

        if ($request->judgement == 'Scrap') {
            $request2->progress = 'Scrap';
        } else {
            $request2->progress = 'On Progress';
        }
        $request2->save();

        if ($request->judgement == 'Scrap') {
            return redirect()->route('partrepair.waitingtable.index')->with('success', 'Your task added successfully!');
        } else {
            return redirect()->back()->with('success', 'Your task added successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ready = Progresspemakaian::where('status_part', '=', 'Ready')
            ->where('form_input_id', $id)
            ->count();
        $countid = Progresspemakaian::where('form_input_id', $id)->count();
        $mastersparepart = MasterSparePart::all();
        $maker = Maker::all();
        $subcont = Subcont::all();
        $user = User::all();
        $progresspemakaian = Progresspemakaian::where('form_input_id', $id)->get();
        $waitingrepair = Waitingrepair::find($id);
        $progressrepair = Progressrepair::where('form_input_id', $id)->first();
        return view('partrepair.progresspemakaian', [
            'waitingrepair'    => $waitingrepair,
            'progressrepair'    => $progressrepair,
            'user'    => $user,
            'subcont'    => $subcont,
            'maker'    => $maker,
            'mastersparepart'    => $mastersparepart,
            'progresspemakaian'    => $progresspemakaian,
            'ready'    => $ready,
            'countid'    => $countid,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'reason_revision' => 'required',
        ]);
        Progressrepair::find($id)->update($request->all());
        return redirect()->back()->with('success', 'Section updated successfully');
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
        $data = $request->all();
        $data['judgement'] = $request->judgement;
        dd($data);
        Waitingrepair::find($id)->update($data);


        return redirect()->route('partrepair.waitingtable.index')->with('success', 'Task removed successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Progressrepair::find($id)->delete();
        return redirect()->route('partrepair.progresstable.index')->with('success', 'Task removed successfully');
    }
    public function revision(Request $request, $id)
    {
        $this->validate($request, [
            'plan_finish_revision' => 'required',
        ]);
        $data['reason_revision'] = $request->reason_revision;
        $data['plan_start_revision'] = Carbon::parse($request->plan_start_revision)->format('Y-m-d H:i:s');
        $data['plan_finish_revision'] = Carbon::parse($request->plan_finish_revision)->format('Y-m-d H:i:s');

        progressrepair::where('form_input_id', $id)->first()->update($data);



        return redirect()->back()->with('success', 'Task updated successfully');
    }

    public function delay(Request $request, $id)
    {
        $this->validate($request, [
            'reason_delay' => 'required',
        ]);
        $data['reason_delay'] = $request->reason_delay;

        progressrepair::where('form_input_id', $id)->first()->update($data);



        return redirect()->back()->with('success', 'Task updated successfully');
    }
}
