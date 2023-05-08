<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Maker;
use App\Models\Machine;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Carbon;
use App\Models\MasterSparePart;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

// use Carbon\Carbon;
// use App\Maker;
// use App\User;
// use App\Machine;
// use App\Line;
// use App\Section;
// use App\Waitingrepair;
// use App\MasterSparePart;
// use App\Maker;

// use App\Section;
// use Carbon\Carbon;
// use App\Http\Requests;
// use App\Waitingrepair;
// use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\User;
// use App\MasterSparePart;

class PartrepairController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        return view('partrepair.index');
    }

    public function request(Request $request)
    {
        $AWAL = 'RE';
        $tahun     = date('Y');
        $bulan = date('m');
        $tanggal    = date('d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $noUrutAkhir = Waitingrepair::where('created_at', '>=', $currentDate)
            ->count('reg_sp');
        // dd($noUrutAkhir);
        $no = 1;
        if ($noUrutAkhir) {
            $ticket = $AWAL . $tahun . $bulan . $tanggal . sprintf("%03s", abs($noUrutAkhir + 1));
        } else {
            $ticket = $AWAL . $tahun . $bulan . $tanggal . sprintf("%03s", $no);
        }





        $maker = Maker::all();
        $user = User::all();
        $section = Section::all();


        // $partr = MasterSparePart::all()->sortByDesc('id');
        // $json = json_decode(file_get_contents('file:///C:/xampp/htdocs/imirs/public/
        $json1 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=MTC'), true);
        $json2 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLR'), true);
        $json3 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLC'), true);

        // $mergedJson = array_merge($json1, $json2, $json3);
        $mergedJson = array_merge($json3['data'], $json2['data'], $json1['data']);
        $partr = collect($mergedJson)->all();
        // dd($partr);

        return view('partrepair.request', [
            'reqtzy' => $partr,
            'section' => $section,
            // 'line' => $line,
            // 'machine' => $machine,
            'ticket' => $ticket,
            'user' => $user,
            'maker' => $maker,
        ]);
    }
}
