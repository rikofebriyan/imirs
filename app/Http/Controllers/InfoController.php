<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Maker;
use App\Models\Machine;
use App\Models\Subcont;
use App\Models\Finishrepair;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Http\Response;
use App\Models\CodePartRepair;
use App\Models\Progressrepair;
use App\Models\MasterSparePart;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\User;
use Yajra\DataTables\DataTables;

// use App\Finishrepair;
// use App\User;
// use App\Machine;
// use App\Line;
// use App\Progressrepair;
// use App\Waitingrepair;
// use App\MasterSparePart;
// use Illuminate\Http\Request;

// use App\Http\Requests;
// use App\Maker;
// use App\Subcont;
// use App\CategoryCode;
// use App\CodePartRepair;
// use Datatables;
// use Illuminate\Database\Eloquent\Builder;

class InfoController extends Controller
{

    public function index(Request $request)
    {
        // $item_name = $_GET['item_name'];
        // $data = MasterSparePart::where('code_item_description', $item_name)->get();
        // $withoutbrackets = trim($data, '[]');
        // echo $withoutbrackets;

        // $data = MasterSparePart::where('code_item_description', $request->item_name)->first();




        // $data = MasterSparePart::where('item_code', $request->item_name)->first();
        // $json = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs-trial/public/json.json'), true);
        $json = json_decode(file_get_contents('http://172.31.42.5/ims/json/stock_onhand.php?whCode=MTC'), true);
        $data = collect($json['data'])->where('item_code', $request->item_name)->first();
        return response()->json($data);
    }



    public function getInfo($nim)
    {
        $data = MasterSparePart::all()->where('id', $nim);
        // return Response::json(['success'=>true, 'data'=>$data]);
        return Response()->json(['success' => true, 'data' => $data]);
    }


    public function getline(Request $request)
    {
        $sectionId = $request->get('sectionId');
        $line = Line::all()->where('section_id', $sectionId)->pluck('name', 'id');
        return response()->json($line);
    }


    public function getmachine(Request $request)
    {
        $lineId = $request->get('lineId');
        $machine = Machine::all()->where('line_id', $lineId)->pluck('name', 'id');
        return response()->json($machine);
    }


    public function getlabour(Request $request)
    {
        $data_labour_cost = 87500;
        // $labour_id = $request->get('labour_id');
        // $data = User::where('name', $labour_id)->first();
        // $withoutbrackets = trim($data, '[]');
        // echo $withoutbrackets;
        return response()->json($data_labour_cost);
    }


    public function getNumberOfRepair(Request $request)
    {
        $finishRepair = Finishrepair::where('code_part_repair', $request->codePartRepair)->get();
        if ($finishRepair->count() > 0) {
            $ticket = Waitingrepair::where('id', $finishRepair->last()->form_input_id)->first();
            $masterSparePart = MasterSparePart::where('id', $ticket->item_id)->first();
            $maker = Maker::all();
            $typeOfPart = [
                1 => 'Mechanic',
                2 => 'Electric',
                3 => 'Hydraulic',
                4 => 'Pneumatic',
            ];
        } else {
            $ticket = [];
            $masterSparePart = [];
            $maker = [];
            $typeOfPart = [];
        }

        return response()->json([
            'finishRepair' => $finishRepair->count(),
            'dataRepair' => $ticket,
            'dataPart' => $masterSparePart,
            'maker' => $maker,
            'typeOfPart' => $typeOfPart,
        ]);
    }

    public function getMaker()
    {
        $maker = Maker::all();
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
        $subcont = Subcont::all();
        return response()->json($subcont);
    }

    public function getcategory(Request $request)
    {
        $data = CodePartRepair::all()->sortByDesc('id')->where('category', $request->category)->first();
        return response()->json($data);
    }

    public function masterdelete($id)
    {
        MasterSparePart::find($id)->delete();
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
        // $master = MasterSparePart::find($id);
        $master = MasterSparePart::where('id', $request->id)->first();
        return response()->json($master);
    }
    public function mymodelrevision(Request $request)
    {
        // $master = MasterSparePart::find($id);
        $master = Progressrepair::where('id', $request->id)->first();
        return response()->json($master);
    }
    public function updatemodel(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // other validation rules...
        ]);

        // Update the item in the database
        $item->name = $request->name;
        // etc...
        $item->save();

        // Return a response
        return response()->json([
            'message' => 'Item updated successfully'
        ]);
    }
}
