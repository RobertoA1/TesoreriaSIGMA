<?php

namespace App\Providers;

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFour();

        $this->defineResourcePermissions();

        Gate::define('access-resource', function (User $user, $resource){
            return $this->hasResourcePermissions($user, $resource);
        });

        Gate::define('manage-resource', function (User $user, $resource, $action = 'view'){
            return $this->hasResourcePermissions($user, $resource, $action);
        });
    }

    private function defineResourcePermissions(){
        config(['permissions' => [
            'academica' => [
                'view' => ['Director'],
                'create' => ['Director'],
                'edit' => ['Director'],
                'delete' => ['Director'],
            ],
            'alumnos' => [
                'view' => ['Director', 'Secretaria'],
                'create' => ['Director', 'Secretaria'],
                'edit' => ['Director', 'Secretaria'],
                'delete' => ['Director', 'Secretaria'],
            ],
            'personal' => [
                'view' => ['Director', 'Secretaria'],
                'create' => ['Director'],
                'edit' => ['Director'],
                'delete' => ['Director'],
            ],
            'administrativa' => [
                'view' => ['Director'],
                'create' => ['Director'],
                'edit' => ['Director'],
                'delete' => ['Director'],
            ],
            'financiera' => [
                'view' => ['Director', 'Secretaria'],
                'create' => ['Director', 'Secretaria'],
                'edit' => ['Director'],
                'delete' => ['Director'],
            ],
            'reportes' => [
                'view' => ['Director'],
                'create' => ['Director'],
                'edit' => ['Director'],
                'delete' => ['Director'],
            ]
        ]]);
    }

    private function hasResourcePermissions(User $user, string $resource, string $action = 'view'){
        $permissions = config('permissions');

        if ($user->tipo !== 'Administrativo'){
            return false;
        }

        $query = Administrativo::where('id_usuario', '=', $user->id_usuario)->get();
        
        if ($query->count() == 0) return false;
        
        $adminAccount = $query[0];

        return in_array($adminAccount->cargo, $permissions[$resource][$action]);
    }
}
