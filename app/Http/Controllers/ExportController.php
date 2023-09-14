<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Models\Finishrepair;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;


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
}
