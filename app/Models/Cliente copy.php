<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Cliente extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'clientes';

    protected $fillable = [
        'tipo_pessoa',
        'nome_completo',
        'bi',
        'nuit',
        'email',
        'telefone',
        'data_nascimento',
        'responsavel_legal',

        'cidade',
        'endereco',
        'numero_casa',
        'bairro',
        'zona_distribuicao',
        'ponto_referencia',
        'latitude',
        'longitude',

        'numero_matricula',
        'categoria_consumo',
        'tipo_ligacao',
        'diametro_ramal',
        'data_solicitacao',
        'data_prevista_ligacao',
        'tipo_imovel',
        'numero_economias',
        'observacoes',
        'status', // 'Ativo', 'Cortada', 'Inadimplente', 'Desativado'
        'senha'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_solicitacao' => 'date',
        'data_prevista_ligacao' => 'date',
    ];

    /**
     * Medidor atual do cliente (direto via medidores.cliente_id)
     * CORRIGIDO: agora é HasOne porque cliente_id está em medidores
     */
    public function medidor(): HasOne
    {
        return $this->hasOne(Medidores::class, 'cliente_id')
            ->where('status_inicial', 'instalado');
    }

    /**
     * Histórico de instalações (tabela cliente_medidors)
     * PERFEITO - mantido como histórico
     */
    public function instalacoes(): HasMany
    {
        return $this->hasMany(ClienteMedidor::class, 'cliente_id');
    }

    /**
     * Todos os medidores que já pertenceram a este cliente
     * NOVO: para histórico completo
     */
    public function medidoresHistorico(): HasMany
    {
        return $this->hasMany(Medidores::class, 'cliente_id');
    }


    public function roteiroLeiturista(): hasMany
    {
        return $this->hasMany(roteiroLeiturista::class, 'cliente_id');
    }


    // ============================================
    // LEITURAS - VIA MEDIDOR
    // ============================================

    /**
     * Todas as leituras do cliente (através do medidor atual)
     * CORRIGIDO: agora usa HasManyThrough via medidores (não cliente_medidors)
     */
    public function leituras(): HasManyThrough
    {
        return $this->hasManyThrough(
            Leituras::class,        // Model final
            Medidores::class,       // Model intermediário
            'cliente_id',           // FK em medidores apontando para clientes
            'medidores_id',         // FK em leituras apontando para medidores
            'id',                   // PK em clientes
            'id'                    // PK em medidores
        );
    }

    /**
     * Última leitura do cliente
     * CORRIGIDO: via hasOneThrough através do medidor
     */
    public function ultimaLeitura(): HasOneThrough
    {
        return $this->hasOneThrough(
            Leituras::class,        // Model final
            Medidores::class,       // Model intermediário
            'cliente_id',           // FK em medidores apontando para clientes
            'medidores_id',         // FK em leituras apontando para medidores
            'id',                   // PK em clientes
            'id'                    // PK em medidores
        )->latest('leituras.data_leitura');
    }
    /**
     * Todos os hidrômetros do cliente
     */
    public function medidores(): HasMany
    {
        return $this->hasMany(ClienteMedidor::class);
    }
    public function faturas(): HasMany
    {
        // Certifique-se de preencher com o nome correto da chave estrangeira
        // caso ela não siga o padrão 'cliente_id' (ex: 'id_cliente', 'cliente_codigo')
        return $this->hasMany(Faturas::class, 'cliente_id');
    }

    /**
     * Última leitura alternativa (via subquery - mais eficiente em alguns casos)
     */
    // public function ultimaLeituraViaSubquery()
    // {
    //     return $this->hasOne(Leituras::class, 'cliente_id')
    //         ->whereIn('cliente_id', function ($query) {
    //             $query->select('id')
    //                 ->from('clientes')
    //                 ->where('cliente_id', $this->id);
    //         })
    //         ->latest('data_leitura');
    // }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',
                'telefone',
                'status',
                'observacoes',
                // 'tipo_entidade', // 'UO','OD'
                // 'unidade_id',
                // 'orgao_id',
                // 'status',
            ])
            ->logOnlyDirty() // Só registra se algo mudar
            ->dontSubmitEmptyLogs() // Evita logs vazios em updates sem alteração
            ->useLogName(class_basename($this)) // Nomeia o log como 'Cliente'
            ->setDescriptionForEvent(fn(string $eventName) => "O cliente foi {$eventName}");
    }
}