<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pagamentos extends Model
{
    protected $table = 'pagamentos';
    protected $fillable = [

        'fatura_id',
        'cliente_id',
        'user_id',

        'codigo_transacao',

        'valor_pago',
        'saldo_restante',

        'data_pagamento',
        'hora_pagamento',

        'metodo_pagamento',

        'numero_comprovante',

        'status',

        'observacoes',

    ];



    protected $casts = [
        'valor_pago' => 'decimal:2',
        'data_pagamento' => 'date',
    ];

    public function fatura(): BelongsTo
    {
        return $this->belongsTo(Faturas::class, 'fatura_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parcela(): BelongsTo
    {
        return $this->belongsTo(negociar_fatura_itens::class, 'parcela_id');
    }
}
