<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'grupo_id',
        'status',
    ];

    public function temPermissao($form_id, $tipo)
    {
        $user_id = auth()->user()->id;
        $grupo_id = auth()->user()->grupo_id;
        $sql = "select * from formgrupo
                inner join form on formgrupo.form_id = form.id";
        $sql = $sql . " where form_id = '$form_id' ";
        $sql = $sql . " and grupo_id = '$grupo_id' ";
        if ($tipo == 'inclui'){
            $sql = $sql . " and formgrupo.inclui = 1 ";
        }
        if ($tipo == 'altera'){
            $sql = $sql . " and formgrupo.altera = 1 ";
        }
        if ($tipo == 'exclui'){
            $sql = $sql . " and formgrupo.exclui = 1 ";
        }
        $verifica = DB::select($sql);
        if ($verifica == [])
            return false;
        else
            return true;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
