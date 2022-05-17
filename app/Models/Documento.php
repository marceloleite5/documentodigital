<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documento';

    public $timestamps = false;

    protected $fillable = [ 
        'nome',
        'tipodocumento_id',
        'setor_id',
        'filial_id',
        'armario',
        'gaveta',
        'pasta',
        'data_documento',
        'data_inclusao',
        'user_id'
    ];

    public function setor()
    {
        return $this->belongsTo('App\Models\Setor');
    }

    public function filial()
    {
        return $this->belongsTo('App\Models\Filial');
    }

}
