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
use App\Models\KeteranganMtbf;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

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
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
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

        $line = DB::table('sparepartrepair.dbo.lines')->where('id', $request->get('line'))->first();
        $section = DB::table('sparepartrepair.dbo.sections')->where('id', $request->get('section'))->first();

        $data = (array) [
            'date' => $request->date,
            'part_from' => $request->part_from,
            'code_part_repair' => $request->code_part_repair,
            'number_of_repair' => $request->number_of_repair,
            'reg_sp' => $request->reg_sp,
            'section' => $section->name,
            'line' => $line->name,
            'machine' => $request->machine,
            'item_id' => $request->item_id,
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'item_type' => $request->item_type,
            'maker' => $request->maker,
            'serial_number' => $request->serial_number,
            'problem' => $request->problem,
            'nama_pic' => $request->nama_pic,
            'type_of_part' => $request->type_of_part,
            'price' => intval(preg_replace('/[^\d.]/', '', $request->price)),
            'stock_spare_part' => $request->stock_spare_part,
            'status_repair' => $request->status_repair,
            'progress' => $request->progress,
            'deleted' => null,
            'deleted_by' => null,
            'reason' => null,
            'approval' => null,
        ];

        if ($request->get('id') != null) {
            DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $request->get('id'))->update($data);

            return redirect()->back()->with('success', 'Your task added successfully!');
        } else {
            $formInput = Waitingrepair::create($data);

            foreach ($request->get('standard') as $standard) {
                // if ($standard['operation'] != null || $standard['standard_pengecekan_min'] != null) {
                if ($standard['checkbox'] == 1) {
                    $submit['item_check_id'] = $standard['item_check_id'];
                    $submit['form_input_id'] = $formInput->id;
                    $submit['standard_pengecekan_id'] = null;
                    $submit['operation'] = $standard['operation'];
                    $submit['standard_pengecekan_min'] = $standard['standard_pengecekan_min'];
                    $submit['standard_pengecekan_max'] = null;
                    $submit['unit_measurement'] = $standard['unit_measurement'];
                    $submit['actual_pengecekan'] = null;
                    $submit['judgement'] = null;

                    Progresstrial::create($submit);
                }
            }

            if ($request->jenisPenggantian == 'MTBF' && $request->mauRekondisi == 'Non Rekondisi') {
                // input history MTBF ke tabel
                $fileName = $request->file('ReconditionSheet')->getClientOriginalName();
                $keteranganMtbf = (array) [
                    'form_input_id' => $formInput->id,
                    'jenis_penggantian' => $request->jenisPenggantian,
                    'mau_rekondisi' => $request->mauRekondisi,
                    'recondition_sheet' => 'ReconditionSheet/' . $formInput->reg_sp . '/' . $fileName,
                ];

                // upload file recondition sheet ke tabel
                $request->file('ReconditionSheet')->storeAs('ReconditionSheet/' . $formInput->reg_sp, $fileName);

                KeteranganMtbf::create($keteranganMtbf);
            } else {
                $keteranganMtbf = (array) [
                    'form_input_id' => $formInput->id,
                    'jenis_penggantian' => $request->jenisPenggantian,
                    'mau_rekondisi' => $request->mauRekondisi,
                    'recondition_sheet' => '',
                ];

                KeteranganMtbf::create($keteranganMtbf);
            }
        }

        return redirect()->back()->with('success', 'Your task added successfully!');
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

        // $data = $request->all();
        $data['deleted'] = 1;
        $data['reason'] = "Deleted: " . $request->reason;
        $data['deleted_by'] = $request->deleted_by;
        DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->update($data);

        return redirect()->route('partrepair.waitingtable.index')->with('success', 'Task removed successfully');
    }

    public function waitingRepairForm1($id)
    {
        $waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->join('sparepartrepair.dbo.makers', 'waitingrepairs.maker', '=', 'makers.id')
            ->select('waitingrepairs.*', 'makers.name as maker_name')
            ->where('waitingrepairs.id', $id)->first();

        $keteranganMtbf = DB::table('sparepartrepair.dbo.keterangan_mtbfs')->where('form_input_id', $waitingrepair->id)->first();

        if ($keteranganMtbf == null) {
            $keteranganMtbf = (object) [
                'id' => '',
                'form_input_id' => '',
                'jenis_penggantian' => '',
                'mau_rekondisi' => '',
                'recondition_sheet' => '',
            ];
        }

        // form 1
        $sectionAll = DB::table('sparepartrepair.dbo.sections')->get();
        $section = $sectionAll->where('name', $waitingrepair->section)->first();

        $lineAll = DB::table('sparepartrepair.dbo.lines')->where('section_id', $section->id)->get();
        $line = $lineAll->where('name', $waitingrepair->line)->first();
        $machineAll = DB::table('sparepartrepair.dbo.machines')->where('line_id', $line->id)->get();

        $maker = DB::table('sparepartrepair.dbo.makers')->orderBy('name')->get();
        $user = DB::table('sparepartrepair.dbo.users')->orderBy('name')->get(['id', 'name', 'NPK', 'jabatan']);

        return view('partrepair.new.progress-form1', [
            'waitingrepair'    => $waitingrepair,
            'section' => $sectionAll,
            'line' => $lineAll,
            'machine' => $machineAll,
            'maker' => $maker,
            'user' => $user,
            'keteranganMtbf' => $keteranganMtbf,
        ]);
    }

    public function waitingRepairForm2($id)
    {
        // form 2
        $subcont = DB::table('sparepartrepair.dbo.subconts')->get();
        $user = DB::table('sparepartrepair.dbo.users')->get('name');
        $waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->first();
        $tradeinddisc = 0.3;
        $price = $waitingrepair->price;
        $tradeincost = $tradeinddisc * $price;
        $progressrepair2 = DB::table('sparepartrepair.dbo.progressrepairs')->where('form_input_id', $waitingrepair->id)->first();

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
        $waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->first();
        $progresspemakaian = DB::table('sparepartrepair.dbo.progresspemakaians')->where('form_input_id', $waitingrepair->id)->get();

        $maker = DB::table('sparepartrepair.dbo.makers')->get();
        $ready = DB::table('sparepartrepair.dbo.progresspemakaians')
            ->where('status_part', '=', 'Ready')
            ->where('form_input_id', $waitingrepair->id)
            ->count();
        $countid = DB::table('sparepartrepair.dbo.progresspemakaians')
            ->where('form_input_id', $waitingrepair->id)
            ->count();

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
        $waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->first();

        $join = DB::table('progresstrials')->where('form_input_id', $waitingrepair->id)
            ->join('sparepartrepair.dbo.item_standards', 'item_standards.id', '=', 'progresstrials.item_check_id')
            ->select('progresstrials.*', 'item_standards.item_standard')
            ->get();

        $itemstandard = DB::table('sparepartrepair.dbo.item_standards')->get();

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
        $waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->join('sparepartrepair.dbo.makers', 'waitingrepairs.maker', '=', 'makers.id')
            ->select('waitingrepairs.*', 'makers.name as maker_name')
            ->where('waitingrepairs.id', $id)->first();

        $progresspemakaian = DB::table('sparepartrepair.dbo.progresspemakaians')->where('form_input_id', $waitingrepair->id)->get();
        $formFinish_waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $id)->first();
        $formFinish_progressrepair = DB::table('sparepartrepair.dbo.progressrepairs')->where('form_input_id', $formFinish_waitingrepair->id)->first();
        $formFinish_progresspemakaian = DB::table('sparepartrepair.dbo.progresspemakaians')->where('form_input_id', $formFinish_waitingrepair->id)->get();
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

        $formFinish_totalFinish = DB::table('sparepartrepair.dbo.finishrepairs')->where('form_input_id', $formFinish_waitingrepair->id)->first();
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

        $progressrepair2 = DB::table('sparepartrepair.dbo.progressrepairs')->where('form_input_id', $waitingrepair->id)->first();

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

        $categoryAll = DB::table('sparepartrepair.dbo.category_codes')->get();
        $user = DB::table('sparepartrepair.dbo.users')->get('name');

        // TAMBAH INTERLOCK MISAL UDAH PERNAH REPAIR
        $nomor_code_repair = (preg_replace('/[^\d.0123456789]/', '', $waitingrepair->code_part_repair));
        $code_repair_huruf = Str::replace($nomor_code_repair, '', $waitingrepair->code_part_repair);

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
            'code_repair_huruf' => $code_repair_huruf,
            'nomor_code_repair' => $nomor_code_repair
        ]);
    }

    public function progressSubcontTable(Request $request)
    {
        $partr = DB::table('sparepartrepair.dbo.waitingrepairs')->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair', 'progressrepairs.place_of_repair', 'progressrepairs.subcont_name', 'progressrepairs.quotation')
            ->where('waitingrepairs.deleted', null)
            ->where('waitingrepairs.progress', '<>', 'finish')
            ->where('waitingrepairs.progress', '<>', 'Scrap')
            ->where('waitingrepairs.approval', '<>', null)
            ->where('progressrepairs.place_of_repair', '<>', 'In House')
            ->orderBy('id')
            ->get();

        return view('partrepair.waitingtablesubcont', [
            'reqtzy' => $partr,
            'progress' => $request->progress,
        ]);
    }
}
