<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Finishrepair;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Models\KeteranganMtbf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->leftJoin('sparepartrepair.dbo.progressrepairs', 'waitingrepairs.id', '=', 'progressrepairs.form_input_id')
            ->whereBetween('waitingrepairs.created_at', [$start_date, $end_date])
            ->where('waitingrepairs.deleted', null)
            ->select(
                'waitingrepairs.date as tanggal',
                'waitingrepairs.part_from',
                'progressrepairs.plan_finish_repair',
                'progressrepairs.actual_finish_repair',
                'waitingrepairs.code_part_repair',
                'waitingrepairs.number_of_repair',
                'waitingrepairs.reg_sp',
                'waitingrepairs.section',
                'waitingrepairs.line',
                'waitingrepairs.machine',
                'waitingrepairs.item_id',
                'waitingrepairs.item_code',
                'waitingrepairs.item_name',
                'waitingrepairs.item_type',
                'waitingrepairs.maker',
                'waitingrepairs.serial_number',
                'waitingrepairs.problem',
                'waitingrepairs.nama_pic',
                'waitingrepairs.price',
                'waitingrepairs.status_repair',
                'waitingrepairs.progress',
            )
            ->get()->toArray();

        $header = array(
            'Tanggal',
            'Part From',
            'Plan Finish Repair',
            'Actual Finish Repair',
            'Code Part Repair',
            'Number of Repair',
            'Reg SP',
            'Section',
            'Line',
            'Machine',
            'Item ID',
            'Item Code',
            'Item Name',
            'Item Type',
            'Maker',
            'Serial Number',
            'Problem',
            'Nama PIC',
            'Price',
            'Status Repair',
            'Progress',
        );

        $spreadsheet = IOFactory::load(public_path('I-Mirs Export.xlsx'));
        $sheet = $spreadsheet->getSheetByName('Sheet Export');
        if ($sheet == null) {
            $sheet = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet);
        }

        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray(json_decode(json_encode($users), true), null, 'A2');

        $start_date_formatted = date("d-m-y", strtotime($start_date));
        $end_date_formatted = date("d-m-y", strtotime($end_date));
        $fileName = "I-Mirs Export History Repair " . $start_date_formatted . " sampai " . $end_date_formatted . ".xlsx";

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    public function ticket(Request $request)
    {
        $reg_sp = $request->reg_sp;

        $users = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->where('reg_sp', $reg_sp)
            ->select(
                'date as tanggal',
                'part_from',
                'code_part_repair',
                'number_of_repair',
                'reg_sp',
                'section',
                'line',
                'machine',
                'item_id',
                'item_code',
                'item_name',
                'item_type',
                'maker',
                'serial_number',
                'problem',
                'nama_pic',
                'price',
                'status_repair',
                'progress',
                'approval'
            )
            ->get()->toArray();

        $header = array(
            'Tanggal',
            'Part From',
            'Code Part Repair',
            'Number of Repair',
            'Reg SP',
            'Section',
            'Line',
            'Machine',
            'Item ID',
            'Item Code',
            'Item Name',
            'Item Type',
            'Maker',
            'Serial Number',
            'Problem',
            'Nama PIC',
            'Price',
            'Status Repair',
            'Progress',
            'Approval'
        );

        $spreadsheet = IOFactory::load(public_path('Ticket Approval.xlsx'));
        $sheet = $spreadsheet->getSheetByName('Sheet Export');
        if ($sheet == null) {
            $sheet = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet);
        }

        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray(json_decode(json_encode($users), true), null, 'A2');

        $fileName = "Ticket Approval " . $reg_sp .  ".xlsx";

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    public function export_finish(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = DB::table('sparepartrepair.dbo.finishrepairs')
            ->leftJoin('sparepartrepair.dbo.progressrepairs', function ($join) {
                $join->on('finishrepairs.progressrepair_id', '=', 'progressrepairs.id');
            })
            ->whereBetween('delivery_date', [$start_date, $end_date])
            ->get([
                'finishrepairs.f_reg_sp',
                'finishrepairs.f_date',
                'finishrepairs.f_item_name',
                'finishrepairs.f_item_type',
                'finishrepairs.f_maker',
                'finishrepairs.f_price',
                'finishrepairs.f_nama_pic',
                'finishrepairs.f_place_of_repair',
                'progressrepairs.subcont_name',
                'progressrepairs.nomor_pp', // diisi dengan data nomor surat jalan
                'progressrepairs.quotation',
                'finishrepairs.f_analisa',
                'finishrepairs.f_action',
                'finishrepairs.f_subcont_cost',
                'progressrepairs.judgement',
                'finishrepairs.f_labour_cost',
                'finishrepairs.f_seal_kit_cost',
                'finishrepairs.f_total_cost_repair',
                'finishrepairs.f_total_cost_saving',
                'finishrepairs.code_part_repair',
                'finishrepairs.delivery_date',
                'finishrepairs.pic_delivery',
            ])->toArray();

        $header = array(
            'reg_sp',
            'date',
            'item_name',
            'item_type',
            'maker',
            'price',
            'nama_pic',
            'place_of_repair',
            'subcont_name',
            'no_surat_jalan',
            'no_quotation',
            'analisa',
            'action',
            'subcont_cost',
            'result',
            'labour_cost',
            'seal_kit_cost',
            'total_cost_repair',
            'total_cost_saving',
            'code_part_repair',
            'delivery_date',
            'pic_delivery',
        );

        $spreadsheet = IOFactory::load(public_path('I-Mirs Export_Finish.xlsx'));
        $sheet = $spreadsheet->getSheetByName('Sheet Export');
        if ($sheet == null) {
            $sheet = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet);
        }

        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray(json_decode(json_encode($users), true), null, 'A2');

        $start_date_formatted = date("d-m-y", strtotime($start_date));
        $end_date_formatted = date("d-m-y", strtotime($end_date));
        $fileName = "I-Mirs Export Finish Table " . $start_date_formatted . " sampai " . $end_date_formatted . ".xlsx";

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    public function export_waiting(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
            ->whereBetween('date', [$start_date, $end_date])
            ->where('progressrepairs.place_of_repair', '<>', 'In House')
            ->select(
                'waitingrepairs.date',
                'waitingrepairs.part_from',
                'waitingrepairs.code_part_repair',
                'waitingrepairs.number_of_repair',
                'waitingrepairs.reg_sp',
                'waitingrepairs.section',
                'waitingrepairs.line',
                'waitingrepairs.machine',
                'waitingrepairs.item_id',
                'waitingrepairs.item_code',
                'waitingrepairs.item_name',
                'waitingrepairs.item_type',
                'waitingrepairs.maker',
                'waitingrepairs.serial_number',
                'waitingrepairs.problem',
                'waitingrepairs.nama_pic',
                'waitingrepairs.type_of_part',
                'waitingrepairs.price',
                'waitingrepairs.stock_spare_part',
                'waitingrepairs.status_repair',
                'waitingrepairs.progress',
                'waitingrepairs.deleted',
                'waitingrepairs.deleted_by',
                'waitingrepairs.reason',
                'waitingrepairs.approval',
                'progressrepairs.place_of_repair',
                'progressrepairs.analisa',
                'progressrepairs.action',
                'progressrepairs.pic_repair',
                'progressrepairs.plan_start_repair',
                'progressrepairs.plan_finish_repair',
                'progressrepairs.subcont_name',
                'progressrepairs.nomor_pp', // diisi dengan data nomor surat jalan
                'progressrepairs.quotation',
                'progressrepairs.lead_time',
                'progressrepairs.time_period',
            )->get()->toArray();

        $header = (array) [
            "date",
            "part_from",
            "code_part_repair",
            "number_of_repair",
            "reg_sp",
            "section",
            "line",
            "machine",
            "item_id",
            "item_code",
            "item_name",
            "item_type",
            "maker",
            "serial_number",
            "problem",
            "nama_pic",
            "type_of_part",
            "price",
            "stock_spare_part",
            "status_repair",
            "progress",
            "deleted",
            "deleted_by",
            "reason",
            "approval",
            "place_of_repair",
            "analisa",
            "action",
            "pic_repair",
            "plan_start_repair",
            "plan_finish_repair",
            "subcont_name",
            "no_surat_jalan",
            "quotation",
            "lead_time",
            "time_period",
        ];

        $spreadsheet = IOFactory::load(public_path('I-Mirs Export_Finish.xlsx'));
        $sheet = $spreadsheet->getSheetByName('Sheet Export');
        if ($sheet == null) {
            $sheet = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet);
        }

        $sheet->fromArray($header, null, 'A1');
        $sheet->fromArray(json_decode(json_encode($users), true), null, 'A2');

        $start_date_formatted = date("d-m-y", strtotime($start_date));
        $end_date_formatted = date("d-m-y", strtotime($end_date));
        $fileName = "I-Mirs Export Waiting Table " . $start_date_formatted . " sampai " . $end_date_formatted . ".xlsx";

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    public function ticket_finish($id)
    {
        $waitingrepair = DB::table('sparepartrepair.dbo.waitingrepairs')
            // ->join('sparepartrepair.dbo.makers', 'waitingrepairs.maker', '=', 'makers.id')
            // ->select('waitingrepairs.*', 'makers.name as maker_name')
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
                'subcont_name' => '',
                'quotation' => '',
                'judgement' => '',
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

        if ($formFinish_totalFinish->code_part_repair) {
            $code_part_repair = $formFinish_totalFinish->code_part_repair;
        } else {
            $code_part_repair =  $waitingrepair->code_part_repair;
        }

        if ($category_repair) {
            $total_cost_saving = $formFinish_totalFinish->f_total_cost_saving;
        } else {
            $total_cost_saving = ($waitingrepair->price - ($formFinish_progressrepair->subcont_cost + $formFinish_progressrepair->labour_cost + $formFinish_progresspemakaian->sum('total_price'))) * 0.7;
        }

        // generate data untuk diwrite ke sheet export
        $data = [
            'reg_sp' => $waitingrepair->reg_sp,
            'date' => $waitingrepair->date,
            'item_name' => $waitingrepair->item_name,
            'item_type' => $waitingrepair->item_type,
            'maker' => $waitingrepair->maker,
            'price' => $waitingrepair->price,
            'nama_pic' => $waitingrepair->nama_pic,
            'place_of_repair' => $formFinish_progressrepair->place_of_repair,
            'subcont_name' => $formFinish_progressrepair->subcont_name,
            'no_surat_jalan' => $formFinish_progressrepair->nomor_pp, // kolom nomor_pp diisi dengan data surat jalan
            'no_quotation' => $formFinish_progressrepair->quotation,
            'analisa' => $formFinish_progressrepair->analisa,
            'action' => $formFinish_progressrepair->action,
            'subcont_cost' => $formFinish_progressrepair->subcont_cost,
            'result' => $formFinish_progressrepair->judgement,
            'labour_cost' => $formFinish_progressrepair->labour_cost,
            'seal_kit_cost' => $formFinish_progresspemakaian->sum('total_price'),
            'total_cost_repair' => $formFinish_progressrepair->subcont_cost + $formFinish_progressrepair->labour_cost + $formFinish_progresspemakaian->sum('total_price'),
            'total_cost_saving' => $total_cost_saving,
            'code_part_repair' => $code_part_repair,
            'delivery_date' => $formFinish_totalFinish->delivery_date,
            'pic_delivery' => $formFinish_totalFinish->pic_delivery,
        ];

        // generate header untuk nama kolom
        $header = array(
            'reg_sp',
            'date',
            'item_name',
            'item_type',
            'maker',
            'price',
            'nama_pic',
            'place_of_repair',
            'subcont_name',
            'no_surat_jalan',
            'no_quotation',
            'analisa',
            'action',
            'subcont_cost',
            'result',
            'labour_cost',
            'seal_kit_cost',
            'total_cost_repair',
            'total_cost_saving',
            'code_part_repair',
            'delivery_date',
            'pic_delivery',
        );

        $header_trial = [
            'item_standard',
            'operation',
            'standard_pengecekan_min',
            'unit_measurement',
            'actual_pengecekan',
            'judgement',
        ];

        if ($formFinish_progressrepair->judgement == 'Scrap') {
            $header_scrap = array(
                'reg_sp',
                'date',
                'item_name',
                'item_type',
                'maker',
                'price',
                'nama_pic',
                'place_of_repair',
                'analisa',
                'action',
                'judgement',
            );

            $data_scrap = [
                'reg_sp' => $waitingrepair->reg_sp,
                'date' => $waitingrepair->date,
                'item_name' => $waitingrepair->item_name,
                'item_type' => $waitingrepair->item_type,
                'maker' => $waitingrepair->maker,
                'price' => $waitingrepair->price,
                'nama_pic' => $waitingrepair->nama_pic,
                'place_of_repair' => $formFinish_progressrepair->place_of_repair,
                'analisa' => $formFinish_progressrepair->analisa,
                'action' => $formFinish_progressrepair->action,
                'judgement' => $formFinish_progressrepair->judgement,
            ];
            // dd($data_scrap);
            $spreadsheet = IOFactory::load(public_path('Ticket Scrap.xlsx'));
            $sheet = $spreadsheet->getSheetByName('Sheet Export');
            if ($sheet == null) {
                $sheet = new Worksheet($spreadsheet, 'Sheet Export');
                $spreadsheet->addSheet($sheet);
            }

            $sheet->fromArray([$header_scrap], null, 'A1');
            $sheet->fromArray($data_scrap, null, 'A2');

            // export to file
            $fileName = "Ticket Scrap " . $waitingrepair->reg_sp .  ".xlsx";
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

            return response()->stream(function () use ($writer) {
                $writer->save('php://output');
            }, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]);
        }

        // write data finish ke sheet export
        $spreadsheet = IOFactory::load(public_path('Ticket Finish.xlsx'));
        $sheet = $spreadsheet->getSheetByName('Sheet Export');
        if ($sheet == null) {
            $sheet = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet);
        }

        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray($data, null, 'A2');

        // write data trial ke sheet trial
        $sheet2 = $spreadsheet->getSheetByName('Sheet Trial');
        if ($sheet2 == null) {
            $sheet2 = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet2);
        }
        $sheet2->fromArray($header_trial, null, 'A1');

        $i = 2;
        foreach ($formFinish_progresstrial as $trial) {
            $data_trial = [
                'item_standard' => $trial->item_standard,
                'operation' => $trial->operation,
                'standard_pengecekan_min' => $trial->standard_pengecekan_min,
                'unit_measurement' => $trial->unit_measurement,
                'actual_pengecekan' => $trial->actual_pengecekan,
                'judgement' => $trial->judgement,
            ];

            $sheet2->fromArray($data_trial, null, 'A' . $i);
            $i++;
        }

        // export to file
        $fileName = "Ticket Finish " . $waitingrepair->reg_sp .  ".xlsx";
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }

    public function reconditionSheet(Request $request)
    {
        $keteranganMtbf = KeteranganMtbf::find($request->id);

        if ($keteranganMtbf == null) {
            return redirect()->back()->with('success', 'Recondition Sheet Tidak Ditemukan');
        } else {
            return Storage::download($keteranganMtbf->recondition_sheet);
        }
    }
}
