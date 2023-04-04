<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $users = Waitingrepair::whereBetween('created_at', [$start_date, $end_date])
            ->where('deleted', null)
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
                'progress'
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
            'Progress'
        );

        $spreadsheet = IOFactory::load(public_path('I-Mirs Export.xlsx'));
        $sheet = $spreadsheet->getSheetByName('Sheet Export');
        if ($sheet == null) {
            $sheet = new Worksheet($spreadsheet, 'Sheet Export');
            $spreadsheet->addSheet($sheet);
        }

        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray($users->toArray(), null, 'A2');

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
}


 // $row = $sheet->getHighestRow() + 1;
        // $sheet->setCellValue('A1', 'Tanggal');
        // $sheet->setCellValue('B1', 'Part From');
        // $sheet->setCellValue('D1', 'Code Part Repair');
        // $sheet->setCellValue('E1', 'Number of Repair');
        // $sheet->setCellValue('F1', 'Reg SP');
        // $sheet->setCellValue('G1', 'Section');
        // $sheet->setCellValue('H1', 'Line');
        // $sheet->setCellValue('I1', 'Machine');
        // $sheet->setCellValue('J1', 'Item ID');
        // $sheet->setCellValue('K1', 'Item Code');
        // $sheet->setCellValue('L1', 'Item Name');
        // $sheet->setCellValue('M1', 'Item Type');
        // $sheet->setCellValue('N1', 'Maker');
        // $sheet->setCellValue('P1', 'Serial Number');
        // $sheet->setCellValue('Q1', 'Problem');
        // $sheet->setCellValue('R1', 'Nama PIC');
        // $sheet->setCellValue('S1', 'Price');
        // $sheet->setCellValue('T1', 'Status Repair');
        // $sheet->setCellValue('U1', 'Progress');
        // foreach ($users as $user) {
        //     $sheet->setCellValue('A' . $row, $user->name);
        //     $sheet->setCellValue('B' . $row, $user->email);
        //     $sheet->setCellValue('C' . $row, $user->created_at);
        //     $row++;
        // }