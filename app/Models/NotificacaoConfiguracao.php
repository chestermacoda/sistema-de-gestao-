<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacaoConfiguracao extends Model
{
    protected $table = 'notificacao_configuracaos';

    protected $fillable = [
        'email_vencimento',
        'dias_antes_vencimento',

        'sms_atraso',
        'dias_atraso_sms',

        'consumo_anomalo',
        'percentual_consumo_anomalo',

        'novo_cadastro',

        'relatorio_semanal',
    ];

    protected $casts = [
        'email_vencimento' => 'boolean',
        'sms_atraso' => 'boolean',
        'consumo_anomalo' => 'boolean',
        'novo_cadastro' => 'boolean',
        'relatorio_semanal' => 'boolean',
    ];
}
