<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Leituras extends Model
{
    use LogsActivity;
    protected $table = 'leituras';
    protected $fillable = [

        'cliente_id',
        'medidores_id',
        'user_id',

        'mes_referencia',

        'data_leitura',
        'hora_leitura',

        'leitura_anterior',
        'leitura_atual',

        'consumo',
        'consumo_medio',

        'status', // 'Normal', 'Anomalia', 'Revisar', 'Editada'

        'tem_anomalia',
        'tipo_anomalia',
        'descricao_anomalia',
        'acao_corretiva',

        'editada',
        'editado_por',
        'motivo_edicao',
        'editado_em',

        'observacoes',

        'latitude',
        'longitude',

        'confirmada_local',

        'origem',
    ];

    protected $casts = [

        'data_leitura' => 'date',

        'tem_anomalia' => 'boolean',

        'editada' => 'boolean',

        'confirmada_local' => 'boolean',

        'editado_em' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    /**
     * Medidor (principal)
     * PERFEITO
     */
    public function medidor(): BelongsTo
    {
        return $this->belongsTo(Medidores::class, 'medidores_id');
    }

    /**
     * Cliente (via medidor)
     * NOVO: acesso direto ao cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Histórico de instalação (opcional)
     * PERFEITO - mantido para compatibilidade
     */
    public function clienteMedidor(): BelongsTo
    {
        return $this->belongsTo(ClienteMedidor::class);
    }

    /**
     * Leiturista
     * PERFEITO
     */
    public function leiturista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roteiros(): HasMany
    {
        // Vincula usando a Model correta e a chave estrangeira presente nela
        return $this->hasMany(RoteiroLeiturista::class, 'leitura_id');
    }
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editado_por');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                // Identificação
                'cliente_id',
                'medidores_id',
                'user_id',
                'mes_referencia',

                // Leituras (dados brutos)
                'leitura_anterior',
                'leitura_atual',
                'consumo',           // ← TROCADO: era consumo_medio (calculado), agora consumo (real)

                // Status e anomalias
                'status',            // 'Normal', 'Anomalia', 'Revisar', 'Editada'
                'tem_anomalia',
                'tipo_anomalia',

                // Edição / Auditoria
                'editada',
                'editado_por',
                'motivo_edicao',

                // Observações
                'observacoes',
            ])
            ->logOnlyDirty()                    // Só registra campos que realmente mudaram
            ->dontSubmitEmptyLogs()             // Evita logs vazios
            ->useLogName('Leitura')             // Nome legível no banco (singular, mais claro)
            ->setDescriptionForEvent(function (string $eventName) {
                $descricoes = [
                    'created' => 'Leitura registrada',
                    'updated' => 'Leitura alterada',
                    'deleted' => 'Leitura removida',
                ];

                $base = $descricoes[$eventName] ?? "Leitura {$eventName}";

                // Adiciona contexto se houver anomalia
                if ($this->tem_anomalia) {
                    $base .= " [ANOMALIA: {$this->tipo_anomalia}]";
                }

                // Adiciona contexto se foi editada
                if ($this->editada && $eventName === 'updated') {
                    $base .= " [EDITADA por ID: {$this->editado_por}]";
                }

                return $base;
            });
    }
}