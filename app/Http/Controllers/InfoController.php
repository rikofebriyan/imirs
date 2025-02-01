<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Maker;
use App\Models\Machine;
use App\Models\Subcont;
use App\Models\Finishrepair;
use App\Models\ItemStandard;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use App\Models\CodePartRepair;
use App\Models\Progressrepair;
use App\Models\MasterSparePart;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{

    public function index(Request $request)
    {
        // $json1 = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs/public/json/stockonhandlistMTC.json'), true);
        // $json2 = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs/public/json/stockonhandlistTLC.json'), true);
        // $json3 = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs/public/json/stockonhandlistTLR.json'), true);
        $json1 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=MTC'), true);
        $json2 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLR'), true);
        $json3 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLC'), true);
        $json4 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=MTD'), true);

        $mergedJson = array_merge($json4['data'], $json3['data'], $json2['data'], $json1['data']);
        $mergedJsonFiltered = array_filter($mergedJson, function ($var) {
            return $var['StatusBarang'] == 'NE';
        });
        $data = collect($mergedJsonFiltered)->where('ItemCode', $request->item_name)->first();
        return response()->json($data);
    }



    public function getInfo($nim)
    {
        //
    }

    public function getline(Request $request)
    {
        $sectionId = $request->get('sectionId');

        $line = DB::table('sparepartrepair.dbo.lines')
            ->select('id', 'name')
            ->where('section_id', '=', $sectionId)
            ->orderBy('name')
            ->get();
        return response()->json($line);
    }

    public function getstorage(Request $request)
    {
        $storageId = $request->input('storageId');
        $itemName = $request->input('itemName'); // Mendapatkan nilai pencarian item name dari permintaan POST

        // error bila storage belum dipilih
        $filteredItems = [];
        if ($storageId == null) {
            $filteredItems['status']['status'] = 'error';
            $filteredItems['status']['message'] = 'Pilih Storage Terlebih Dahulu !!!';

            $filteredItems['data'] = [];

            return response()->json($filteredItems);
        }

        $itemJson = [];
        if ($storageId == '1') {
            // $itemJson = json_decode(file_get_contents(public_path('json/stockonhandlistMTC.json')), true);
            $itemJson = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=MTC'), true);
        } elseif ($storageId == '2') {
            // $itemJson = json_decode(file_get_contents(public_path('json/stockonhandlistTLC.json')), true);
            $itemJson = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLC'), true);
        } elseif ($storageId == '3') {
            // $itemJson = json_decode(file_get_contents(public_path('json/stockonhandlistTLR.json')), true);
            $itemJson = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLR'), true);
        } elseif ($storageId == '4') {
            $itemJson = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=MTD'), true);
        }

        $item = array_filter($itemJson['data'], function ($var) {
            return $var['StatusBarang'] == 'NE';
        });

        // error bila data json berisi nol
        if (count($item) == 0) {
            $filteredItems['status']['status'] = 'error';
            $filteredItems['status']['message'] = 'Pilih Storage Terlebih Dahulu !!!';

            $filteredItems['data'] = [];

            return response()->json($filteredItems);
        } else {
            $filteredItems['status']['status'] = 'success';
            $filteredItems['status']['message'] = '';
        }

        foreach ($item as $data) {
            if (
                strpos(strtolower($data['itemName']), strtolower($itemName)) !== false ||
                strpos(strtolower($data['ItemCode']), strtolower($itemName)) !== false ||
                strpos(strtolower($data['description']), strtolower($itemName)) !== false
            ) {
                $filteredItems['data'][] = $data;
            }
        }

        return response()->json($filteredItems);
    }

    public function getmachine(Request $request)
    {
        $lineId = $request->get('lineId');
        $machine = DB::table('sparepartrepair.dbo.machines')->where('line_id', $lineId)->orderBy('name')->pluck('name', 'id');
        return response()->json($machine);
    }


    public function getlabour(Request $request)
    {
        $data_labour_cost = 87500;

        return response()->json($data_labour_cost);
    }


    public function getNumberOfRepair(Request $request)
    {
        $finishRepair = DB::table('sparepartrepair.dbo.finishrepairs')->where('code_part_repair', $request->codePartRepair)->get();

        if ($finishRepair->count() > 0) {
            $ticket = DB::table('sparepartrepair.dbo.waitingrepairs')->where('id', $finishRepair->last()->form_input_id)->first();
            $maker = DB::table('sparepartrepair.dbo.makers')->get();
            $typeOfPart = [
                1 => 'Mechanic',
                2 => 'Electric',
                3 => 'Hydraulic',
                4 => 'Pneumatic',
            ];
        } else {
            $ticket = [];
            $maker = [];
            $typeOfPart = [];
        }

        return response()->json([
            'finishRepair' => $finishRepair->count(),
            'dataRepair' => $ticket,
            'maker' => $maker,
            'typeOfPart' => $typeOfPart,
        ]);
    }

    public function getMaker()
    {
        $maker = DB::table('sparepartrepair.dbo.makers')->get();
        return response()->json($maker);
    }

    public function getTypeOfPart()
    {
        $typeOfPart = [
            1 => 'Mechanic',
            2 => 'Electric',
            3 => 'Hydraulic',
            4 => 'Pneumatic',
        ];
        return response()->json($typeOfPart);
    }

    public function getSubcont()
    {
        $subcont = DB::table('sparepartrepair.dbo.subconts')->get();
        return response()->json($subcont);
    }

    public function getcategory(Request $request)
    {
        $data = DB::table('sparepartrepair.dbo.code_part_repairs')->where('category', $request->category)->orderByDesc('id')->first();
        return response()->json($data);
    }

    public function masterdelete($id)
    {
        DB::table('sparepartrepair.dbo.master_spare_parts')->where('id', $id)->delete();
        return response()->json([
            'success' => 'Record has been deleted successfully!'
        ]);
    }

    public function getmaster(Request $request)
    {
        $model = MasterSparePart::query();
        return Datatables::of($model)
            ->addColumn('action', function ($model) {
                return '<form action="' . route('master_spare_part.destroy', $model->id) . '" method="DELETE" style="display:inline">
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(`Yakin?`)"><i class="bi bi-trash"></i></button>
            </form><button type="button" class="btn icon btn-primary btn-sm me-1" data-bs-toggle="modal"
            data-bs-target="#modalasu" data-id="' . $model->id . '">
            <i class="bi bi-pencil"></i>
        </button>';
                return $model;
            })
            ->make(true);
    }
    public function mymodel(Request $request)
    {
        $master = MasterSparePart::where('id', $request->id)->first();
        return response()->json($master);
    }

    public function mymodelrevision(Request $request)
    {
        $master = Progressrepair::where('id', $request->id)->first();
        return response()->json($master);
    }

    public function updatemodel(Request $request, $id)
    {
        return response()->json([
            'message' => 'Item updated successfully'
        ]);
    }

    public function getUnitMeasurement(Request $request)
    {
        $unitMeasurement = DB::table('sparepartrepair.dbo.item_standards')->where('id', $request->id)->first();
        return response()->json($unitMeasurement);
    }
}
