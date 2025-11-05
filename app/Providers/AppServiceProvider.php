<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Blade::if('roleCan', function ($permission) {
        $activeRole = session('active_role');
        if (!$activeRole) {
            return false;
        }

        $role = Role::where('name', $activeRole)->first();
        if (!$role) {
            return false;
        }

        return $role->hasPermissionTo($permission);
    });

    Blade::if('roleCanAny', function ($permissions) {
        $user = auth()->user();
        $activeRole = session('active_role') ?? $user?->getRoleNames()->first();

        if (!$activeRole) {
            return false;
        }

        $role = Role::findByName($activeRole, 'web');
        if (!$role) {
            return false;
        }

        foreach ($permissions as $permission) {
            if ($role->hasPermissionTo($permission, 'web')) {
                return true;
            }
        }

        return false;
    });
}

}
