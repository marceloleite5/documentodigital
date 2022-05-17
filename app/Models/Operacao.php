<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operacao extends Model
{
    use HasFactory;

    protected $table = 'operacao';

    protected $fillable = [
        'nome'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
