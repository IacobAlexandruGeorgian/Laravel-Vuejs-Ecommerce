<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
        // Passport::routes();

        Passport::tokensCan([
            'admin' => 'Admin access',
            'influencer' => 'Influencer access'
        ]);

        Gate::define('view', function (User $user, $model) {
            $userRole = UserRole::where('user_id', $user->id)->first();
            $role = Role::find($userRole->role_id);
            $permissions = $role->permissions->pluck('name');
            return $permissions->contains("view_{$model}") || $permissions->contains("edit_{$model}");
        });

        Gate::define('edit', function (User $user, $model) {
            $userRole = UserRole::where('user_id', $user->id)->first();
            $role = Role::find($userRole->role_id);
            $permissions = $role->permissions->pluck('name');
            return $permissions->contains("edit_{$model}");
        });
    }
}
