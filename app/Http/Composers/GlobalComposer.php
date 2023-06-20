<?php

namespace App\Http\Composers;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\Waitingrepair;
use App\Models\Progressrepair;
use Illuminate\Support\Facades\DB;

class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

    }
}
