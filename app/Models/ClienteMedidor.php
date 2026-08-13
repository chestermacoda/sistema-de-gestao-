<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ClienteMedidor extends Model
{
    protected $table = 'cliente_medidors';

    protected $fillable = [

        'cliente_id',
        'medidor_id',

        'leitura_inicial',
        'data_instalacao',

        'local_instalacao',
        'condicao_hidrometro',

        'numero_lacre',

        'vistoria_realizada',

        'status',

        'data_remocao',

        'observacoes',
    ];

    protected $casts = [
        'data_instalacao' => 'date',
        'data_remocao' => 'date',
        'vistoria_realizada' => 'boolean',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Medidor do histórico
     * PERFEITO
     */
    public function medidor(): BelongsTo
    {
        return $this->belongsTo(Medidores::class);
    }
}
