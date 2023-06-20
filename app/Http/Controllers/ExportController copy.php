<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            'tanggal',
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
        );
        $file = public_path('tester.xlsx');

        $objPHPExcel = IOFactory::load($file);
        $sheet = $objPHPExcel->getSheetByName('I-Mirs');
        if ($sheet == null) {
            $sheet = $objPHPExcel->createSheet();
            $sheet->setTitle('I-Mirs');
        }
        $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($sheet));

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray($users->toArray(), null, 'A2');
        $sheet->setAutoFilter('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow());

        $file2 = public_path('I-Mirs Data.xlsx');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($file2);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="I-Mirs Data Table.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $temp_file = tempnam(sys_get_temp_dir(), 'excel');
        $objWriter->save($temp_file);
        $objWriter->save('php://output');
    }


    public function export2(Request $request)
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

        $header = array();
        foreach ($users[0] as $key => $value) {
            $header[] = $key;
        }

        $filename = 'I-Mirs';
        $file = public_path('tester.xlsx');

        $objPHPExcel = IOFactory::load($file);
        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex($objPHPExcel->getSheetCount() - 1);
        $objPHPExcel->getActiveSheet()->setTitle('New sheet');
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->fromArray([$header], null, 'A1');
        $sheet->fromArray($users->toArray(), null, 'A2');
        $file2 = public_path('tester2.xlsx');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($file2);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="tester2.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $temp_file = tempnam(sys_get_temp_dir(), 'excel');
        $objWriter->save($temp_file);
        $objWriter->save('php://output');
    }
}
