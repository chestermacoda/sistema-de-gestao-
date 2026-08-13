<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'email',
        'telefone',
        'endereco_completo',
        'logo',
    ];
}
