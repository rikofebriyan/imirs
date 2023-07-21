<?php

namespace App\Providers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('AdminSupervisor', function (User $user) {
            if ($user->jabatan == 'ADMIN' || $user->jabatan == 'Supervisor') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('Supervisor', function (User $user) {
            if ($user->jabatan == 'Supervisor') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('Maintenance', function (User $user) {
            if ($user->jabatan == 'Maintenance') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('RepairMan', function (User $user) {
            if ($user->jabatan == 'RepairMan') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('Facility', function (User $user) {
            if ($user->jabatan == 'Facility') {
                return true;
            } else {
                return false;
            }
        });
    }
}
