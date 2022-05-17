<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'log'; 

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'operacao_id',
        'tipobj',
        'objeto',
        'data'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function operacao()
    {
        return $this->belongsTo('App\Models\Operacao');
    }
}
