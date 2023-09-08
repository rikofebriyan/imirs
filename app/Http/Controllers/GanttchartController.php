<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class GanttchartController extends Controller
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
    public function index(Request $request)
    {
        $join = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->join('sparepartrepair.dbo.progressrepairs', 'waitingrepairs.id', '=', 'progressrepairs.form_input_id')
            ->select('waitingrepairs.*', 'progressrepairs.place_of_repair', 'progressrepairs.analisa', 'progressrepairs.action', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair', 'progressrepairs.actual_start_repair', 'progressrepairs.actual_finish_repair', 'progressrepairs.plan_start_revision', 'progressrepairs.plan_finish_revision', 'progressrepairs.reason_revision', 'progressrepairs.id as progressid', 'progressrepairs.reason_delay')
            ->where('progress', '<>', 'finish')
            ->where('progress', '<>', 'Scrap')
            ->where('approval', '<>', null)
            ->orderBy('reg_sp', 'desc')
            ->get();
        $count = count(collect($join));

        if ($join != null) {
            foreach ($join as $index => $value) {

                $date1 = Carbon::now();
                $date2 = Carbon::parse($value->plan_finish_repair);
                $date3 = Carbon::parse($value->plan_finish_revision);
                if ($value->reason_revision != null) {
                    $fillcolor = '#aa9958';
                } else {
                    if ($date1->gt($date2)) {
                        $days = $date1->diffInDays($date2) * -1;
                        $fillcolor = '#dc3545';
                    } else {
                        $days = $date2->diffInDays($date1);
                        $fillcolor = '';
                    }
                }

                if ($date1->gt($date3)) {
                    $days = $date1->diffInDays($date3) * -1;
                    $fillcolorrev = '#dc3545';
                } else {
                    $days = $date3->diffInDays($date1);
                    $fillcolorrev = '';
                }

                $data[$index] = [
                    'id' => $value->id,
                    'created_at' => $value->created_at,
                    'updated_at' => $value->updated_at,
                    'date' => $value->date,
                    'part_from' => $value->part_from,
                    'reg_sp' => $value->reg_sp,
                    'section' => $value->section,
                    'line' => $value->line,
                    'machine' => $value->machine,
                    'item_code' => $value->item_code,
                    'item_name' => $value->item_name,
                    'item_type' => $value->item_type,
                    'maker' => $value->maker,
                    'problem' => $value->problem,
                    'nama_pic' => $value->nama_pic,
                    'price' => $value->price,
                    'status_repair' => $value->status_repair,
                    'progress' => $value->progress,
                    'place_of_repair' => $value->place_of_repair,
                    'analisa' => $value->analisa,
                    'action' => $value->action,
                    'actual_start_repair' => $value->actual_start_repair,
                    'actual_finish_repair' => $value->actual_finish_repair,
                    'plan_start_repair' => $value->plan_start_repair,
                    'plan_finish_repair' => $value->plan_finish_repair,
                    'plan_start_revision' => $value->plan_start_revision,
                    'plan_finish_revision' => $value->plan_finish_revision,
                    'reason_revision' => $value->reason_revision,
                    'reason_delay' => $value->reason_delay,
                    'progressid' => $value->progressid,
                    'fillcolor' => $fillcolor,
                    'fillcolorrev' => $fillcolorrev,

                ];
            }
        } else {
            return redirect()->back()->with('no_waiting_part', 'No Schedule Waiting Part Repair');
        }
        return view('partrepair.ganttchart', [
            'count' => $count,
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}
