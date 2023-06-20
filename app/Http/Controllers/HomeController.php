<?php

namespace App\Http\Controllers;

use App\Models\Finishrepair;
use App\Models\Progresspemakaian;
use App\Models\Progressrepair;
use App\Models\Progresstrial;
use App\Models\Waitingrepair;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waitingRepairData = Waitingrepair::all();
        $progressRepairData = Progressrepair::all();
        $progressPemakaianData = Progresspemakaian::all();
        $progressTrialData = Progresstrial::all();
        $finishRepairData = Finishrepair::all();

        $stepProgress = ['Waiting', 'On Progress', 'Seal Kit', 'Trial', 'Finish'];
        // counting data

        $data['total_registered'] = $waitingRepairData
            ->where('deleted', null)
            ->count();

        foreach ($stepProgress as $step) {
            $data['total_' . $step] = $waitingRepairData
                ->where('progress', $step)
                ->where('deleted', null)
                ->count();
        }

        $data['total_Waiting_Approve'] = $waitingRepairData
            ->where('progress', 'Waiting')
            ->where('approval', null)
            ->where('deleted', null)
            ->count();

        $data['total_Waiting_Progress'] = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->where('progress', 'Waiting')
            ->whereNotNull('approval')
            ->where('deleted', null)
            ->count();


        $data['total_Scrap'] = $waitingRepairData->where('progress', 'Scrap')->count();
        $data['total_cost_saving'] = $finishRepairData->sum('f_total_cost_saving');
        $data['total_pneumatic'] = $waitingRepairData->where('type_of_part', 'Pneumatic')->count();
        $data['total_hydraulic'] = $waitingRepairData->where('type_of_part', 'Hydraulic')->count();
        $data['total_mechanic'] = $waitingRepairData->where('type_of_part', 'Mechanic')->count();
        $data['total_electric'] = $waitingRepairData->where('type_of_part', 'Electric')->count();
        $data['total_repair_in_house'] = $progressRepairData->where('place_of_repair', 'In House')->count();
        $data['total_repair_in_subcont'] = $progressRepairData->where('place_of_repair', 'Subcont')->count();
        $data['total_repair_trade_in'] = $progressRepairData->where('place_of_repair', 'Trade In')->count();
        $data['total_repair_kit_ready'] = $progressPemakaianData->where('status_part', 'Ready')->count();
        $data['total_repair_kit_not_ready'] = $progressPemakaianData->where('status_part', 'Not Ready')->count();
        $data['total_judgement_ok'] = $progressTrialData->where('judgement', 'OK')->count();
        $data['total_judgement_ng'] = $progressTrialData->where('judgement', 'NG')->count();

        return view('home', [
            'data' => $data,
        ]);
    }
    public function reportHome(Request $request)
    {
        if ($request->bulan == null) {
            $dateNow = Carbon::now();
            $dateNowMonth = $dateNow->format('m');
            $dateNowYear = $dateNow->format('Y');
        } else {
            $dateNowMonth = $request->bulan;
            $dateNowYear = $request->tahun;
        }

        $stepProgress = ['Waiting', 'On Progress', 'Seal Kit', 'Trial', 'Finish', 'Scrap'];
        $week = [
            1 => 7,
            8 => 14,
            15 => 21,
            22 => 28,
            29 => 31
        ];
        $month = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];

        $year = [];
        for ($i = (int) Carbon::now()->format('Y'); $i > (int) Carbon::now()->format('Y') - 10; $i--) {
            $year[] = $i;
        }

        $placeOfRepair = [
            'subcont' => 'Subcont',
            'in_house' => 'In House',
            'trade_in' => 'Trade In'
        ];

        if ($request->groupBy == 'Week' || $request->groupBy == null) {
            foreach ($stepProgress as $step) {
                $counting[$step] = 0;
                $w = 1;
                foreach ($week as $start => $finish) {
                    $qty[$step]['W' . $w] = DB::table('sparepartrepair.dbo.waitingrepairs')
                        ->whereMonth('date', '=', $dateNowMonth)
                        ->whereYear('date', '=', $dateNowYear)
                        ->where('progress', $step)
                        ->whereBetween('date', [Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $start)->format('Y-m-d'), Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $finish)->format('Y-m-d')])
                        ->count();

                    $qty['total']['W' . $w] = DB::table('sparepartrepair.dbo.waitingrepairs')
                        ->whereMonth('date', '=', $dateNowMonth)
                        ->whereYear('date', '=', $dateNowYear)
                        ->whereBetween('date', [Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $start)->format('Y-m-d'), Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $finish)->format('Y-m-d')])
                        ->count();

                    $counting[$step] = $counting[$step] + $qty[$step]['W' . $w];

                    $costSaving['actual']['W' . $w] = DB::table('sparepartrepair.dbo.finishrepairs')
                        ->whereMonth('f_date', '=', $dateNowMonth)
                        ->whereYear('f_date', '=', $dateNowYear)
                        ->whereBetween('f_date', [Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $start)->format('Y-m-d'), Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $finish)->format('Y-m-d')])
                        ->sum('f_total_cost_saving') / 1000000; // dibagi 1jt untuk scale

                    $costSaving['target']['W' . $w] = (float) 1300000000 / 5 / 1000000; // dibagi 1jt untuk scale

                    foreach ($placeOfRepair as $indexPlace => $place) {
                        $costSaving[$place]['W' . $w] = DB::table('sparepartrepair.dbo.finishrepairs')
                            ->whereMonth('f_date', '=', $dateNowMonth)
                            ->whereYear('f_date', '=', $dateNowYear)
                            ->where('f_place_of_repair', $place)
                            ->whereBetween('f_date', [Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $start)->format('Y-m-d'), Carbon::parse($dateNowYear . '-' . $dateNowMonth . '-' . $finish)->format('Y-m-d')])
                            ->sum('f_total_cost_saving') / 1000000; // dibagi 1jt untuk scale
                    }

                    $w++;
                }
            }

            $qty['xAxis'] = ['W1', 'W2', 'W3', 'W4', 'W5',];
            $costSaving['xAxis'] = ['W1', 'W2', 'W3', 'W4', 'W5',];
            $groupBy = 'Week';
        } else if ($request->groupBy == 'Month') {
            foreach ($stepProgress as $step) {
                foreach ($month as $index => $mo) {
                    $qty[$step][$mo] = DB::table('sparepartrepair.dbo.waitingrepairs')
                        ->whereMonth('date', '=', $index)
                        ->whereYear('date', '=', $dateNowYear)
                        ->where('progress', $step)
                        ->count();

                    $qty['total'][$mo] = DB::table('sparepartrepair.dbo.waitingrepairs')
                        ->whereMonth('date', '=', $index)
                        ->whereYear('date', '=', $dateNowYear)
                        ->count();

                    $costSaving['actual'][$mo] = DB::table('sparepartrepair.dbo.finishrepairs')
                        ->whereMonth('f_date', '=', $index)
                        ->whereYear('f_date', '=', $dateNowYear)
                        ->sum('f_total_cost_saving') / 1000000; // dibagi 1jt untuk scale

                    $costSaving['target'][$mo] = (float) 1300000000 / 1000000; // dibagi 1jt untuk scale

                    foreach ($placeOfRepair as $indexPlace => $place) {
                        $costSaving[$place][$mo] = DB::table('sparepartrepair.dbo.finishrepairs')
                            ->whereMonth('f_date', '=', $index)
                            ->whereYear('f_date', '=', $dateNowYear)
                            ->where('f_place_of_repair', $place)
                            ->sum('f_total_cost_saving') / 1000000; // dibagi 1jt untuk scale
                    }
                }
            }

            $qty['xAxis'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $costSaving['xAxis'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $groupBy = 'Month';
        } else {
            $qty = [];
            $costSaving = [];
            $groupBy = [];
        }

        return view('report.index', [
            'qty' => $qty,
            'costSaving' => $costSaving,
            'groupBy' => $groupBy,
            'month' => $month,
            'year' => $year,
            'dateNowMonth' => $dateNowMonth,
            'dateNowYear' => $dateNowYear,
            'placeOfRepair' => $placeOfRepair
        ]);
    }
}
