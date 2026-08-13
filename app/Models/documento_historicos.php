<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class documento_historicos extends Model
{
    protected $table = 'documento_historicos';

    protected $fillable = [
        'cliente_id',
        'fatura_id',
        'pagamento_id',
        'tipo',
        'codigo',
        'arquivo_nome',
        'arquivo_path',
        'baixado_em',
        'ip',
    ];

    protected $casts = [
        'baixado_em' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function fatura(): BelongsTo
    {
        return $this->belongsTo(Faturas::class);
    }

    public function pagamento(): BelongsTo
    {
        return $this->belongsTo(pagamentos::class);
    }
}