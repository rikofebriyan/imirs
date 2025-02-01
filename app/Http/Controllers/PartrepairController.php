<?php

namespace App\Http\Controllers;

use App\Models\Maker;
use App\Models\Section;
use App\Models\ItemStandard;
use Illuminate\Http\Request;
use App\Models\Waitingrepair;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        //
    }

    public function request(Request $request)
    {
        $AWAL = 'RE';
        $tahun     = date('Y');
        $bulan = date('m');
        $tanggal    = date('d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $noUrutAkhir = DB::table('sparepartrepair.dbo.waitingrepairs')
            ->where('created_at', '>=', $currentDate)
            ->count('reg_sp');

        $itemstandard = DB::table('sparepartrepair.dbo.item_standards')->get();

        $no = 1;
        if ($noUrutAkhir) {
            $ticket = $AWAL . $tahun . $bulan . $tanggal . sprintf("%03s", abs($noUrutAkhir + 1));
        } else {
            $ticket = $AWAL . $tahun . $bulan . $tanggal . sprintf("%03s", $no);
        }

        $maker = DB::table('sparepartrepair.dbo.makers')->orderBy('name')->get();
        $user = DB::table('sparepartrepair.dbo.users')->orderBy('name')->get(['id', 'name', 'NPK', 'jabatan']);
        $section = DB::table('sparepartrepair.dbo.sections')->orderBy('name')->get();
        $finishRepair = DB::table('sparepartrepair.dbo.finishrepairs')->orderBy('code_part_repair')->get(['id', 'code_part_repair', 'f_item_name', 'f_item_type', 'f_maker']);
        $userLogin = Auth::user(['id', 'name', 'NPK', 'jabatan']);

        return view('partrepair.request', [
            'section' => $section,
            'ticket' => $ticket,
            'user' => $user,
            'maker' => $maker,
            'itemstandard' => $itemstandard,
            'finishRepair' => $finishRepair,
            'userLogin' => $userLogin,
        ]);
    }

    public function getStandardPengecekan(Request $request)
    {
        $itemCode = $request->itemCode;

        $dataRepair = DB::table('sparepartrepair.dbo.waitingrepairs')->where('item_code', $itemCode)->orderByDesc('id')->first();
        $itemStandard = DB::table('sparepartrepair.dbo.item_standards')->get();

        if ($dataRepair == null) {
            return response()->json([
                'status' => 'empty',
                'waiting_repair_id' => '',
                'data' => $itemStandard,
            ]);
        }
        $progressTrial = DB::table('sparepartrepair.dbo.progresstrials')->where('form_input_id', $dataRepair->id)->get();

        if ($progressTrial->count() > 0) {
            foreach ($itemStandard as $std) {
                $standard[$std->id]['item_standard'] = $std->item_standard;
                $standard[$std->id]['unit_measurement'] = $std->unit_measurement;

                foreach ($progressTrial as $trial) {
                    if ($std->id == $trial->item_check_id) {
                        $standard[$std->id]['operation'] = $trial->operation;
                        $standard[$std->id]['standard_pengecekan_min'] = $trial->standard_pengecekan_min;
                        break;
                    } else {
                        $standard[$std->id]['operation'] = null;
                        $standard[$std->id]['standard_pengecekan_min'] = null;
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'waiting_repair_id' => $dataRepair->id,
                'data' => $standard,
            ]);
        } else {
            return response()->json([
                'status' => 'empty',
                'waiting_repair_id' => $dataRepair->id,
                'data' => $itemStandard,
            ]);
        }
    }
}
