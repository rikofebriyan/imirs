<?php


namespace App\Providers;

use Carbon\Carbon;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {

        View::composer('*', function ($view) {

            // share data with all views
            $notif = Waitingrepair::leftJoin('progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
                ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
                ->where('progress', '<>', 'finish')
                ->where('progress', '<>', 'Scrap')
                ->where('deleted', null)
                ->where('plan_finish_repair', '<=', Carbon::now()->subDays(0))
                ->get();

            $notifcount = Waitingrepair::leftJoin('progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
                ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
                ->where('progress', '<>', 'finish')
                ->where('progress', '<>', 'Scrap')
                ->where('deleted', null)
                ->where('plan_finish_repair', '<=', Carbon::now()->subDays(0))
                ->count();

            $waiting_approve = Waitingrepair::all()
                ->where('progress', 'Waiting')
                ->where('approval', null)
                ->where('deleted', null)
                ->count();

            $allprogress = DB::table('waitingrepairs')
                ->where('progress', '<>', 'Finish')
                ->whereNotNull('approval')
                ->where('deleted', null)
                ->count();

            $view->with('notif', $notif);
            $view->with('notifcount', $notifcount);
            $view->with('waiting_approve', $waiting_approve);
            $view->with('allprogress', $allprogress);
        });
    }

    public function register()
    {
        //
    }
}