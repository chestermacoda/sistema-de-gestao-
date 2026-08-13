<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table = 'tarifas';

    protected $fillable = [
        'categoria',
        'valor_m3',
        'taxa_minima',
        'limite_m3',
    ];
}
