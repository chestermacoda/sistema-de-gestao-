<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Faturas extends Model
{
    use LogsActivity;
    protected $table = 'faturas';
    protected $fillable = [

        'cliente_id',
        'leitura_id',

        'codigo_fatura',
        'mes_referencia',

        'periodo_inicio',
        'periodo_fim',

        'consumo_m3',

        'valor_consumo', //aqui fica o valor ainda bruto do consumo original
        'valor_esgoto',
        'taxa_disponibilidade',

        'multa',
        'juros',
        'desconto',



        'valor_total', //aqui ficam o valor com todas as multas, juros e descontos

        // controle de pagamento (NOVO)
        'valor_pago', //total já pago (soma dos pagamentos)
        'saldo_atual', //valor_total - valor_pago

        // negociação (NOVO)
        'negociada',  //indica se a fatura entrou em acordo
        'parcelas_qtd', //quantas parcelas foram definidas
        'juros_isento', //se juros foram removidos na negociação

        'data_emissao',
        'data_vencimento',

        'status',
        'observacoes',
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fim' => 'date',
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'consumo_m3' => 'float',
        'valor_consumo' => 'float',
        'valor_esgoto' => 'float',
        'taxa_disponibilidade' => 'float',
        'multa' => 'float',
        'juros' => 'float',
        'desconto' => 'float',
        'valor_total' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function roteiroLeiturista()
    {
        return $this->belongsTo(RoteiroLeiturista::class);
    }

    public function leitura(): BelongsTo
    {
        return $this->belongsTo(Leituras::class, 'leitura_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(pagamentos::class, 'fatura_id');
    }



    public function scopeVencidas($query)
    {
        return $query->where('status', 'Pendente')
            ->where('data_vencimento', '<', now());
    }

    /*
    |--------------------------------------------------------------------------
    | ACESSORES
    |--------------------------------------------------------------------------
    */

    /**
     * Retorna se a fatura está vencida
     */
    public function getEstaVencidaAttribute(): bool
    {
        return $this->status === 'Pendente' && $this->data_vencimento->isPast();
    }

    /**
     * Retorna dias até o vencimento (ou dias de atraso)
     */
    public function getDiasVencimentoAttribute(): int
    {
        return now()->diffInDays($this->data_vencimento, false);
    }

    /**
     * Valor com multa e juros calculados (se vencida)
     */
    public function getValorAtualizadoAttribute(): float
    {
        if (!$this->esta_vencida) {
            return (float) $this->valor_total;
        }

        $config = ConfiguracaoFinanceira::latest()->first();
        $diasAtraso = abs($this->dias_vencimento);

        $multa = (float) $this->valor_total * ($config?->percentual_multa ?? 10) / 100;
        $juros = (float) $this->valor_total * ($config?->percentual_juros_dia ?? 0.5) / 100 * $diasAtraso;

        return (float) $this->valor_total + $multa + $juros - (float) $this->desconto;
    }





    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePendentes($query)
    {
        return $query->whereIn('status', ['Pendente', 'Vencida']);
    }

    public function scopePagas($query)
    {
        return $query->whereIn('status', ['Pago', 'Parcial']);
    }

    public function scopeDoMes($query, string $mesReferencia)
    {
        return $query->where('mes_referencia', $mesReferencia);
    }

    /*
    |--------------------------------------------------------------------------
    | ACESSORES
    |--------------------------------------------------------------------------
    */

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Pago' => 'success',
            'Pendente' => 'warning',
            'Parcial' => 'info',
            'Vencida' => 'danger',
            'Negociada' => 'secondary',
            'Cancelada' => 'muted',
            'Estornada' => 'dark',
            default => 'secondary',
        };
    }











    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'cliente_id',
                'leitura_id',
                'codigo_fatura',
                'mes_referencia',
                'consumo_m3',
                'valor_consumo',
                'valor_esgoto',
                'taxa_disponibilidade',
                'multa',
                'juros',
                'desconto',
                'valor_total',
                'data_vencimento',
                'status',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('Fatura')
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'Fatura emitida',
                'updated' => 'Fatura alterada',
                'deleted' => 'Fatura cancelada',
                default => "Fatura {$eventName}",
            });
    }
}