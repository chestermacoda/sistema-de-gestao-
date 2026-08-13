<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relatorio extends Model
{
    protected $table = 'relatorios';

    protected $fillable = [
        'user_id',
        'cliente_id',
        'fatura_id',
        'pagamentos_id',
        'origem',
        'data_referencia',
        'ficheiro_caminho',
        'nome_arquivo',
        'status',
    ];
}