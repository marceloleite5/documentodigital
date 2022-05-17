<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('emails', function(User $user, $tipo){
            $form_id = 1; // Tabela de emails
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('setores', function(User $user, $tipo){
            $form_id = 2; // Tabela de setores
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('filiais', function(User $user, $tipo){
            $form_id = 3; // Tabela de Filiais
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('tipodocumentos', function(User $user, $tipo){
            $form_id = 4; // Tabela de tipos de documentos
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('documentos', function(User $user, $tipo){
            $form_id = 5; // Tabela de documentos
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('grupos', function(User $user, $tipo){
            $form_id = 6; // Tabela de Grupos
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('permissoes', function(User $user, $tipo){
            $form_id = 7; // Tabela de formulários do Grupo
            return $user->temPermissao($form_id, $tipo);
        });

        Gate::define('usuarios', function(User $user, $tipo){
            $form_id = 8; // Tabela de Usuários
            return $user->temPermissao($form_id, $tipo);
        });
    }
}
