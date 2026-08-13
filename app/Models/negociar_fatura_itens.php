<?php

namespace App\Models;

use App\Livewire\Admin\Faturas\NegociarFatura;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class negociar_fatura_itens extends Model
{
    protected $table = 'negociar_fatura_itens';
    protected $fillable = [
        'negociar_fatura_id',
        'fatura_id',
        'valor_original',
        'valor_parcela',
        'valor_restante',
        'status',
        'numero_parcela',
    ];




    protected $casts = [
        'valor_original' => 'decimal:2',
        'valor_negociado' => 'decimal:2',
        'data_vencimento' => 'date',
    ];

    public function negociacao(): BelongsTo
    {
        return $this->belongsTo(negociar_fatura::class, 'negociacao_id');
    }

    public function fatura(): BelongsTo
    {
        return $this->belongsTo(Faturas::class, 'fatura_id');
    }
}
