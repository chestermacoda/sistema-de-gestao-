<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class relatorios_analiticos extends Model
{
    use HasFactory;

    protected $table = 'relatorios_analiticos';

    protected $fillable = [
        'titulo',
        'tipo',
        'data_inicio',
        'data_fim',
        'zona',
        'categoria',
        'user_id',
        'status',
        'ficheiro_caminho',
        'nome_arquivo',
        'parametros',
        'resumo',
        'gerado_em',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
        'parametros'  => 'array',
        'resumo'      => 'array',
        'gerado_em'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'financeiro'    => 'Financeiro',
            'consumo'       => 'Consumo',
            'inadimplencia' => 'Inadimplência',
            'operacional'   => 'Operacional',
            'geral'         => 'Visão Geral',
            default         => ucfirst($this->tipo),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pronto'      => 'pronto',
            'processando' => 'processando',
            'agendado'    => 'agendado',
            'erro'        => 'erro',
            default       => 'processando',
        };
    }
}
