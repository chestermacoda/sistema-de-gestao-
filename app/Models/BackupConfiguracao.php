<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupConfiguracao extends Model
{
    protected $table = 'backup_configuracaos';
    protected $fillable = [
        'frequencia',
        'horario',
        'retencao_dias',
        'ativo',
    ];
}
