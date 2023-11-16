<?php


namespace App\Providers;

use Carbon\Carbon;
use App\Models\Waitingrepair;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {

        View::composer('*', function ($view) {

            // share data with all views
            $notif = DB::table('sparepartrepair.dbo.waitingrepairs')
                ->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
                ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
                ->where('progress', '<>', 'finish')
                ->where('progress', '<>', 'Scrap')
                ->where('deleted', null)
                ->where('plan_finish_repair', '<=', Carbon::now()->subDays(0))
                ->get();

            $notifcount = DB::table('sparepartrepair.dbo.waitingrepairs')
                ->leftJoin('sparepartrepair.dbo.progressrepairs', 'progressrepairs.form_input_id', '=', 'waitingrepairs.id')
                ->select('waitingrepairs.*', 'progressrepairs.plan_start_repair', 'progressrepairs.plan_finish_repair')
                ->where('progress', '<>', 'finish')
                ->where('progress', '<>', 'Scrap')
                ->where('deleted', null)
                ->where('plan_finish_repair', '<=', Carbon::now()->subDays(0))
                ->count();

            $waiting_approve = DB::table('sparepartrepair.dbo.waitingrepairs')
                ->where('progress', 'Waiting')
                ->where('approval', null)
                ->where('deleted', null)
                ->count();

            $allprogress = DB::table('sparepartrepair.dbo.waitingrepairs')
                ->where('progress', '<>', 'Finish')
                ->whereNotNull('approval')
                ->where('deleted', null)
                ->count();

            if (Auth::guard()->check()) {
                $loginUser = Auth::user();
            } else {
                $loginUser = (object) [
                    'name' => '',
                    'jabatan' => '',
                ];
            }

            $view->with('notif', $notif);
            $view->with('notifcount', $notifcount);
            $view->with('waiting_approve', $waiting_approve);
            $view->with('allprogress', $allprogress);
            $view->with('loginUser', $loginUser);
        });
    }

    public function register()
    {
        //
    }
}
