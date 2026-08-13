<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoteiroLeiturista extends Model
{
    protected $table = 'roteiro_leituristas';
    protected $fillable = [
        'user_id',
        'fatura_id',
        'cliente_id',
        'data_referente',
        'leitura_anterior',
        'leitura_atual',
        'data_inicio',
        'data_fim',

        'Zona',
        'status',
        'observacoes',
        'ordem',
        'foto',
        'lido_em',
        'created_by',
    ];

    protected $casts = [
        'data_referente' => 'date',
        'lido_em' => 'datetime',
        'leitura_anterior' => 'decimal:2',
        'leitura_atual' => 'decimal:2',
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leitura()
    {
        return $this->belongsTo(Leituras::class);
    }
    public function cliente()
    {
        return $this->belongsTo(cliente::class);
    }
    public function medidores()
    {
        return $this->belongsTo(medidores::class);
    }

    public function criador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function fatura(): BelongsTo
    {
        return $this->belongsTo(RoteiroLeiturista::class, 'fatura_id');
    }
}
