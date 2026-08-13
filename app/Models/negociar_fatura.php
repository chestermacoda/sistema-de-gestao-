<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class negociar_fatura extends Model
{
    protected $table = 'negociar_faturas';

    protected $fillable = [
        'fatura_id',
        'cliente_id',
        'user_id',
        'tipo_negociacao',
        'valor_original',
        'desconto',
        'juros',
        'valor_final',
        'quantidade_parcelas',
        'status',
        'observacoes',
    ];
    protected $casts = [
        'valor_original' => 'decimal:2',
        'desconto' => 'decimal:2',
        'juros' => 'decimal:2',
        'valor_final' => 'decimal:2',
    ];
    public function fatura(): BelongsTo
    {
        return $this->belongsTo(Faturas::class, 'fatura_id');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(negociar_fatura_itens::class, 'negociar_fatura_id');
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
