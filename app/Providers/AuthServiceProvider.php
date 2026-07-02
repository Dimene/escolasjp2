<?php

namespace App\Providers;

use app\Models\post;
use App\Models\User;
use App\Services\TenantService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\permission;
use App\Models\role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        // 'App\post' => 'App\Policies\postPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */public function boot()
{
    $this->registerPolicies();

    if (app()->runningInConsole()) {
        // Evite configurar Gates no ambiente CLI
        return;
    }

    // Resolva o TenantService e carregue o tenant
    $tenantService = app(TenantService::class);
    $tenant = $tenantService->getTenant();

    // Carregue permissões relacionadas ao tenant
    $permissions = Permission::with('roles')->get();
    foreach ($permissions as $permission) {
        Gate::define($permission->name, function (User $user) use ($permission) {
            return $user->hasPermission($permission);
        });
    }

    // Gate global para administradores
    Gate::before(function (User $user) {
        if ($user->hasAnyRoles('Admin')) {
            return true;
        }
    });
}





}
