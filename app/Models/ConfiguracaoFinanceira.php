<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoFinanceira extends Model
{
    protected $table = 'configuracao_financeiras';

    protected $fillable = [
        'multa_atraso',
        'juros_mes',
        'dias_tolerancia',
        'dias_geracao',
    ];
}