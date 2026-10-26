<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class relatorio_agendamentos extends Model
{
    use HasFactory;

    protected $table = 'relatorio_agendamentos';

    protected $fillable = [
        'titulo',
        'tipo',
        'frequencia',
        'horario',
        'dia_semana',
        'dia_mes',
        'destinatarios',
        'zona',
        'categoria',
        'user_id',
        'ativo',
        'ultimo_envio',
        'proximo_envio',
    ];

    protected $casts = [
        'ativo'         => 'boolean',
        'horario'       => 'string',
        'ultimo_envio'  => 'datetime',
        'proximo_envio' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFrequenciaLabelAttribute(): string
    {
        return match ($this->frequencia) {
            'diario'     => 'Diário',
            'semanal'    => 'Semanal',
            'mensal'     => 'Mensal',
            'trimestral' => 'Trimestral',
            default      => ucfirst($this->frequencia),
        };
    }

    public function getFrequenciaCssAttribute(): string
    {
        return match ($this->frequencia) {
            'diario'     => 'rel-diario',
            'semanal'    => 'rel-semanal',
            'mensal'     => 'rel-mensal',
            'trimestral' => 'rel-mensal',
            default      => '',
        };
    }
}
