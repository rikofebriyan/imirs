<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Models\Finishrepair;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use DB;


class ExportController extends Controller
{
    public function export(Request $request)
    {
        // dd($request);
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // $users = Waitingrepair::whereBetween('created_at', [$start_date, $end_date])
        //     ->where('deleted', null)
        //     ->select(
        //         'date as tanggal',
        //         'part_from',
        //         'code_part_repair',
        //         'number_of_repair',
        //         'reg_sp',
        //         'section',
        //         'line',
        //         'machine',
        //         'item_id',
        //         'item_code',
        //         'item_name',
        //         'item_type',
        //         'maker',
        //         'serial_number',
        //         'problem',
        //         'nama_pic',
        //         'price',
        //         'status_repair',
        //         'progress'
        //     )
        //     ->get();

        // revisi 23 mei 2023
        $users = DB::table('waitingrepairs')
            ->leftJoin('progressrepairs', 'waitingrepairs.id', '=', 'progressrepairs.form_input_id')
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
        // $sheet->fromArray($users->toArray(), null, 'A2');
        $sheet->fromArray(json_decode(json_encode($users), true), null, 'A2');

        $start_date_formatted = date("d-m-y", strtotime($start_date));
        $end_date_formatted = date("d-m-y", strtotime($end_date));
        $fileName = "I-Mirs Export " . $start_date_formatted . " sampai " . $end_date_formatted . ".xlsx";

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
        // dd($request);
        $reg_sp = $request->reg_sp;

        $users = Waitingrepair::where('reg_sp', $reg_sp)
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
            ->get();

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
        $sheet->fromArray($users->toArray(), null, 'A2');

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
        // dd($request);
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = Finishrepair::whereBetween('delivery_date', [$start_date, $end_date])
            ->select(
                'f_reg_sp',
                'f_date',
                'f_item_name',
                'f_item_type',
                'f_maker',
                'f_price',
                'f_nama_pic',
                'f_place_of_repair',
                'f_analisa',
                'f_action',
                'f_subcont_cost',
                'f_labour_cost',
                'f_seal_kit_cost',
                'f_total_cost_repair',
                'f_total_cost_saving',
                'code_part_repair',
                'delivery_date',
                'pic_delivery',
            )
            ->get();

        $header = array(
            'f_reg_sp',
            'f_date',
            'f_item_name',
            'f_item_type',
            'f_maker',
            'f_price',
            'f_nama_pic',
            'f_place_of_repair',
            'f_analisa',
            'f_action',
            'f_subcont_cost',
            'f_labour_cost',
            'f_seal_kit_cost',
            'f_total_cost_repair',
            'f_total_cost_saving',
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
        $sheet->fromArray($users->toArray(), null, 'A2');

        $start_date_formatted = date("d-m-y", strtotime($start_date));
        $end_date_formatted = date("d-m-y", strtotime($end_date));
        $fileName = "I-Mirs Export Finish " . $start_date_formatted . " sampai " . $end_date_formatted . ".xlsx";

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ]);
    }
}
