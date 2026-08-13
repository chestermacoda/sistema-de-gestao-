<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup_historico extends Model
{
    protected $table = 'backup_historicos';
    protected $fillable = [
        'arquivo',
        'tipo',
        'tamanho_mb',
        'origem',
    ];
}
