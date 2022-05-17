<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected $table = 'imagem';

    public $timestamps = false; 

    protected $fillable = [ 
        'documento_id',
        'endereco',
        'tipo'
    ];

    public function documento()
    {
        return $this->belongsTo('App\Models\Documento');
    }

}
