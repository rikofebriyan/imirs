<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

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

        $no = 1;
        if ($noUrutAkhir) {
            $ticket = $AWAL . $tahun . $bulan . $tanggal . sprintf("%03s", abs($noUrutAkhir + 1));
        } else {
            $ticket = $AWAL . $tahun . $bulan . $tanggal . sprintf("%03s", $no);
        }

        $maker = Maker::all();
        $user = User::all();
        $section = Section::all();

        $json1 = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs/public/json/stockonhandlistMTC.json'), true);
        $json2 = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs/public/json/stockonhandlistTLC.json'), true);
        $json3 = json_decode(file_get_contents('file:///C:/laragon/www/i-mirs/public/json/stockonhandlistTLR.json'), true);
        // $json1 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=MTC'), true);
        // $json2 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLR'), true);
        // $json3 = json_decode(file_get_contents('http://172.31.42.5/ims/json/stockonhandlist.php?whCode=TLC'), true);
        // $json1['data'] = [];
        // $json2['data'] = [];
        // $json3['data'] = [];

        $mergedJson = array_merge($json3['data'], $json2['data'], $json1['data']);
        $mergedJsonFiltered = array_filter($mergedJson, function ($var) {
            return $var['StatusBarang'] == 'NE';
        });
        $partr = collect($mergedJsonFiltered)->all();

        return view('partrepair.request', [
            'reqtzy' => $partr,
            'section' => $section,
            'ticket' => $ticket,
            'user' => $user,
            'maker' => $maker,
        ]);
    }
}
