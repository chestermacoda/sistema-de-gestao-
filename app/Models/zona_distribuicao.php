<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class zona_distribuicao extends Model
{
     protected $table = 'zona_distribuicao';

    protected $fillable = [
        'nome',
        'descricao',
        'status',
    ];
}
