<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Progressrepair;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendDelayNotificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailriko';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $progressrepair = DB::table('waitingrepairs')
            ->join('progressrepairs', 'waitingrepairs.id', '=', 'progressrepairs.form_input_id')
            ->select(
                'waitingrepairs.*',
                'progressrepairs.place_of_repair',
                'progressrepairs.analisa',
                'progressrepairs.action',
                'progressrepairs.plan_start_repair',
                'progressrepairs.plan_finish_repair',
                'progressrepairs.pic_repair',
                'progressrepairs.actual_finish_repair',
                'progressrepairs.plan_start_revision',
                'progressrepairs.plan_finish_revision',
                'progressrepairs.reason_revision',
                'progressrepairs.id as progressid',
                'progressrepairs.notified_at'
            )
            ->where('progress', '<>', 'finish')
            ->where('progress', '<>', 'Scrap')
            ->where('plan_finish_repair', '<', Carbon::now())
            ->whereNull('notified_at')->get();



        foreach ($progressrepair as $repair) {
            $data = [
                'name' => $repair->pic_repair,
                'item_name' => $repair->item_name,
                'item_code' => $repair->item_code,
                'plan_finish_repair' => Carbon::parse($repair->plan_finish_repair)->format('d-M-Y'),
                'reason' => 'Repair is delayed',
            ];

            Mail::send('emails.demo', $data, function ($message) {
                $message->to('rikofebriyan@gmail.com', 'PE-Digitalization')
                    ->subject('I-Mirs Delay Notification for Your Repair');
                $message->from('pe-digitalization@outlook.com', 'PE-Digitalization');
            });

            $notified = Progressrepair::find($repair->progressid);
            $notified->notified_at = Carbon::now();
            $notified->save();
        }
    }
}
