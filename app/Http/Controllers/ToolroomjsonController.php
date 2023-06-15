<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\toolroomjson;

class ToolroomjsonController extends Controller
{
    public function index()
    {
        $json = file_get_contents('/public/json.json');
        $data = json_decode($json, true);

        foreach ($data['data'] as $itemData) {
            $item = new toolroomjson();
            $item->fill($itemData);
            $item->save();
        }

        $items = DB::table('sparepartrepair.dbo.items')->get();

        return view('home', compact('items'));
    }
}
