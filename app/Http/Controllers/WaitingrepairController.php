<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Maker;
use App\Models\Machine;
use App\Models\Section;
use App\Models\Subcont;
use Illuminate\Support\Str;
use App\Models\CategoryCode;
use App\Models\Finishrepair;
use App\Models\ItemStandard;
use Illuminate\Http\Request;
use App\Models\Progresstrial;
use App\Models\Waitingrepair;
use App\Models\Progressrepair;
use App\Models\MasterSparePart;
use App\Models\Progresspemakaian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class WaitingrepairController extends Controller
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
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair', 'progressrepairs.place_of_repair')
            ->where('deleted', null)
            ->where('progress', '<>', 'finish')
            ->where('progress', '<>', 'Scrap')
            ->where('approval', '<>', null)
            ->orderBy('id')
            ->get();

        return view('partrepair.waitingtable', [
            'reqtzy' => $partr,
            'progress' => $request->progress,
        ]);
    }

    public function deleted(Request $request)
    {
        $partr = Waitingrepair::leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
            ->where('deleted', 1)
            ->get();

        return view('partrepair.waitingtabledelete', [
            'reqtzy' => $partr,
        ]);
    }

    public function finish(Request $request)
    {
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
            ->where('deleted', null)
            ->where('progress', 'finish')
            ->orWhere('progress', 'Scrap')
            ->get();

        return view('partrepair.waitingtablefinish', [
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
        return view('partrepair.waitingtable.request');
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
            'problem' => 'required',
        ]);

        $line = Line::where('id', $request->get('line'))->first();
        $section = Section::where('id', $request->get('section'))->first();
        $data = $request->all();
        $data['section'] = $section->name;
        $data['line'] = $line->name;
        $data['price'] = intval(preg_replace('/[^\d.]/', '', $request->price));

        if ($request->get('id') != null) {
            Waitingrepair::find($request->get('id'))->update($data);
        } else {
            Waitingrepair::create($data);
        }


        return redirect()->route('partrepair.waitingapprove.index')->with('success', 'Your task added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // form 2
        $subcont = Subcont::all();
        $user = User::all();
        $waitingrepair = Waitingrepair::find($id);
        $tradeinddisc = 0.3;
        $price = $waitingrepair->price;
        $price = $waitingrepair->price;
        $tradeincost = $tradeinddisc * $price;
        $progressrepair2 = Progressrepair::where('form_input_id', $waitingrepair->id)->first();

        if ($progressrepair2 == null) {
            $progressrepair2 = (object) ([
                'place_of_repair' => '',
                'analisa' => '',
                'action' => '',
                'pic_repair' => '',
                'judgement' => '',
                'plan_start_repair' => '',
                'plan_finish_repair' => '',
                'actual_start_repair' => '',
                'actual_finish_repair' => '',
                'total_time_repair' => '',
                'labour_cost' => '',
                'subcont_name' => '',
                'judgement' => '',
                'quotation' => '',
                'subcont_cost' => '',
                'lead_time' => '',
                'time_period' => '',
                'nomor_pp' => '',
                'nomor_po' => '',
                'plan_start_repair_subcont' => '',
                'plan_finish_repair_subcont' => '',
                'actual_start_repair_subcont' => '',
                'actual_finish_repair_subcont' => '',
            ]);
        }

        // form 3
        $progresspemakaian = Progresspemakaian::where('form_input_id', $waitingrepair->id)->get();
        $countid = Progresspemakaian::where('form_input_id', $waitingrepair->id)->count();
        $mastersparepart = MasterSparePart::all();
        $maker = Maker::all();
        $ready = Progresspemakaian::where('status_part', '=', 'Ready')
            ->where('form_input_id', $waitingrepair->id)
            ->count();
        $countid = Progresspemakaian::where('form_input_id', $waitingrepair->id)->count();

        // form 4
        $join = Progresstrial::where('form_input_id', $waitingrepair->id)
            ->join('item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        $itemstandard = ItemStandard::all();

        // form 5
        $progressrepair = $progresspemakaian->first();
        $formFinish_waitingrepair = Waitingrepair::where('id', $id)->first();
        $formFinish_progressrepair = Progressrepair::where('form_input_id', $formFinish_waitingrepair->id)->first();
        $formFinish_progresspemakaian = Progresspemakaian::where('form_input_id', $formFinish_waitingrepair->id)->get();
        $formFinish_progresstrial = Progresstrial::join('dbo.item_standards', 'progresstrials.item_check_id', '=', 'item_standards.id')
            ->where('form_input_id', $formFinish_waitingrepair->id)
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        if ($formFinish_progressrepair == null) {
            $formFinish_progressrepair = (object) [
                'id' => '',
                'place_of_repair' => '',
                'subcont_cost' => 0,
                'labour_cost' => 0,
                'analisa' => '',
                'action' => '',
            ];
        }

        $formFinish_totalFinish = Finishrepair::where('form_input_id', $formFinish_waitingrepair->id)->first();
        if ($formFinish_totalFinish == null) {
            $formFinish_totalFinish = (object) [
                'code_part_repair' => '',
                'delivery_date' => '',
                'pic_delivery' => '',
            ];
        }

        // form 1
        $sectionAll = Section::all();
        $section = $sectionAll->where('name', $waitingrepair->section)->first();
        $lineAll = Line::where('section_id', $section->id)->get();
        $line = Line::where('name', $waitingrepair->line)->first();
        $machineAll = Machine::where('line_id', $line->id)->get();
        $categoryAll = CategoryCode::all();
        $test = 123;

        return view('partrepair.progress', [
            'waitingrepair'    => $waitingrepair,
            'user'    => $user,
            'subcont'    => $subcont,
            'tradeincost'    => $tradeincost,

            'progresspemakaian'    => $progresspemakaian,
            'countid'    => $countid,
            'mastersparepart'    => $mastersparepart,
            'maker'    => $maker,
            'ready'    => $ready,
            'countid'    => $countid,

            'asu'    => $waitingrepair,
            'join'    => $join,
            'itemstandard'    => $itemstandard,

            'progressrepair'    => $progressrepair,
            'progressrepair2' => $progressrepair2,
            'formFinish_waitingrepair' => $formFinish_waitingrepair,
            'formFinish_progressrepair' => $formFinish_progressrepair,
            'formFinish_progresspemakaian' => $formFinish_progresspemakaian,
            'formFinish_progresstrial' => $formFinish_progresstrial,
            'formFinish_totalFinish' => $formFinish_totalFinish,

            'section' => $sectionAll,
            'line' => $lineAll,
            'machine' => $machineAll,
            'category' => $categoryAll,
            'test' => $test,

        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $data = $request->all();
        $data['deleted'] = 1;
        $data['reason'] = "Deleted: " . $request->reason;
        $data['deleted_by'] = $request->deleted_by;
        Waitingrepair::find($id)->update($data);

        return redirect()->route('partrepair.waitingtable.index')->with('success', 'Task removed successfully');
    }

    public function waitingRepairForm1($id)
    {
        $waitingrepair = Waitingrepair::find($id);

        // form 1
        $sectionAll = Section::all();
        $section = $sectionAll->where('name', $waitingrepair->section)->first();
        $lineAll = Line::where('section_id', $section->id)->get();
        $line = Line::where('name', $waitingrepair->line)->first();
        $machineAll = Machine::where('line_id', $line->id)->get();
        $categoryAll = CategoryCode::all();
        $test = 123;
        $maker = Maker::all();
        $user = User::all();

        return view('partrepair.new.progress-form1', [
            'waitingrepair'    => $waitingrepair,
            'section' => $sectionAll,
            'line' => $lineAll,
            'machine' => $machineAll,
            'category' => $categoryAll,
            'test' => $test,
            'maker' => $maker,
            'user' => $user,
        ]);
    }

    public function waitingRepairForm2($id)
    {
        // form 2
        $subcont = Subcont::all();
        $user = User::all();
        $waitingrepair = Waitingrepair::find($id);
        $tradeinddisc = 0.3;
        $price = $waitingrepair->price;
        $price = $waitingrepair->price;
        $tradeincost = $tradeinddisc * $price;
        $progressrepair2 = Progressrepair::where('form_input_id', $waitingrepair->id)->first();

        if ($progressrepair2 == null) {
            $progressrepair2 = (object) ([
                'place_of_repair' => '',
                'analisa' => '',
                'action' => '',
                'pic_repair' => '',
                'judgement' => '',
                'plan_start_repair' => '',
                'plan_finish_repair' => '',
                'actual_start_repair' => '',
                'actual_finish_repair' => '',
                'total_time_repair' => '',
                'labour_cost' => '',
                'subcont_name' => '',
                'judgement' => '',
                'quotation' => '',
                'subcont_cost' => '',
                'lead_time' => '',
                'time_period' => '',
                'nomor_pp' => '',
                'nomor_po' => '',
                'plan_start_repair_subcont' => '',
                'plan_finish_repair_subcont' => '',
                'actual_start_repair_subcont' => '',
                'actual_finish_repair_subcont' => '',
            ]);
        }

        return view('partrepair.new.progress-form2', [
            'waitingrepair'    => $waitingrepair,
            'user'    => $user,
            'subcont'    => $subcont,
            'tradeincost'    => $tradeincost,
            'progressrepair2' => $progressrepair2,
        ]);
    }

    public function waitingRepairForm3($id)
    {
        // form 3
        $waitingrepair = Waitingrepair::find($id);
        $progresspemakaian = Progresspemakaian::where('form_input_id', $waitingrepair->id)->get();

        $maker = Maker::all();
        $ready = Progresspemakaian::where('status_part', '=', 'Ready')
            ->where('form_input_id', $waitingrepair->id)
            ->count();
        $countid = Progresspemakaian::where('form_input_id', $waitingrepair->id)->count();

        return view('partrepair.new.progress-form3', [
            'waitingrepair'    => $waitingrepair,
            'progresspemakaian'    => $progresspemakaian,
            'maker'    => $maker,
            'ready'    => $ready,
            'countid'    => $countid,
        ]);
    }

    public function waitingRepairForm4($id)
    {
        // form 4
        $waitingrepair = Waitingrepair::find($id);
        // $join = Progresstrial::where('form_input_id', $waitingrepair->id)
        //     ->join('item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
        //     ->select('progresstrials.*', 'item_standards.item_standard')
        //     ->get();
        $join = DB::table('progresstrials')->where('form_input_id', $waitingrepair->id)
            ->join('item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        $itemstandard = ItemStandard::all();
        return view('partrepair.new.progress-form4', [
            'waitingrepair'    => $waitingrepair,
            'asu'    => $waitingrepair,
            'join'    => $join,
            'itemstandard'    => $itemstandard,
        ]);
    }

    public function waitingRepairForm5($id)
    {
        // form 5
        $waitingrepair = Waitingrepair::find($id);
        $progresspemakaian = Progresspemakaian::where('form_input_id', $waitingrepair->id)->get();
        $formFinish_waitingrepair = Waitingrepair::where('id', $id)->first();
        $formFinish_progressrepair = Progressrepair::where('form_input_id', $formFinish_waitingrepair->id)->first();
        $formFinish_progresspemakaian = Progresspemakaian::where('form_input_id', $formFinish_waitingrepair->id)->get();
        $formFinish_progresstrial = DB::table('progresstrials')->join('item_standards', 'progresstrials.item_check_id', '=', 'item_standards.id')
            ->where('form_input_id', $formFinish_waitingrepair->id)
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        if ($formFinish_progressrepair == null) {
            $formFinish_progressrepair = (object) [
                'id' => '',
                'place_of_repair' => '',
                'subcont_cost' => 0,
                'labour_cost' => 0,
                'analisa' => '',
                'action' => '',
            ];
        }

        $formFinish_totalFinish = Finishrepair::where('form_input_id', $formFinish_waitingrepair->id)->first();
        if ($formFinish_totalFinish == null) {
            $formFinish_totalFinish = (object) [
                'code_part_repair' => '',
                'delivery_date' => '',
                'pic_delivery' => '',
            ];

            $number_category_repair = '';
            $category_repair = '';
        } else {
            $number_category_repair = preg_replace('/[^\d.0123456789]/', '', $formFinish_totalFinish->code_part_repair);
            $category_repair = Str::replace($number_category_repair, '', $formFinish_totalFinish->code_part_repair);
        }

        $progressrepair2 = Progressrepair::where('form_input_id', $waitingrepair->id)->first();

        if ($progressrepair2 == null) {
            $progressrepair2 = (object) ([
                'place_of_repair' => '',
                'analisa' => '',
                'action' => '',
                'pic_repair' => '',
                'judgement' => '',
                'plan_start_repair' => '',
                'plan_finish_repair' => '',
                'actual_start_repair' => '',
                'actual_finish_repair' => '',
                'total_time_repair' => '',
                'labour_cost' => '',
                'subcont_name' => '',
                'judgement' => '',
                'quotation' => '',
                'subcont_cost' => '',
                'lead_time' => '',
                'time_period' => '',
                'nomor_pp' => '',
                'nomor_po' => '',
                'plan_start_repair_subcont' => '',
                'plan_finish_repair_subcont' => '',
                'actual_start_repair_subcont' => '',
                'actual_finish_repair_subcont' => '',
            ]);
        }
        $categoryAll = CategoryCode::all();
        $user = User::all();

        return view('partrepair.new.progress-form5', [
            'waitingrepair'    => $waitingrepair,
            'user'    => $user,
            'progresspemakaian'    => $progresspemakaian,
            'asu'    => $waitingrepair,
            'progressrepair2' => $progressrepair2,
            'formFinish_waitingrepair' => $formFinish_waitingrepair,
            'formFinish_progressrepair' => $formFinish_progressrepair,
            'formFinish_progresspemakaian' => $formFinish_progresspemakaian,
            'formFinish_progresstrial' => $formFinish_progresstrial,
            'formFinish_totalFinish' => $formFinish_totalFinish,
            'category' => $categoryAll,
            'category_repair' => $category_repair,
            'number_category_repair' => $number_category_repair,
        ]);
    }
}
