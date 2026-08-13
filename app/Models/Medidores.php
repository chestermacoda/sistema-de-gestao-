<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Medidores extends Model
{
    use HasFactory;
    protected $table = 'medidores';

    protected $fillable = [

        'cliente_id',
        'numero_hidrometro',
        'numero_serie',

        'marca',
        'modelo',

        'diametro',
        'tipo_hidrometro',
        'classe_metrologica',

        'qn',
        'qmax',
        'qmin',

        'ano_fabricacao',
        'data_aquisicao',

        'fornecedor',
        'nota_fiscal',

        'status_inicial', // 'Estoque', 'instalado', 'Manutencao', 'Descartado', 'Cortada'

        'observacoes',

        'certificado_calibracao',
        'laudo_inmetro',

        'numero_certificado_inmetro',
        'validade_certificado',
        'laboratorio_calibracao',
        'quantidade',
    ];

    protected $casts = [
        'data_aquisicao' => 'date',
        'validade_certificado' => 'date',
    ];


    // public function instalacoes()
    // {
    //     return $this->hasMany(ClienteMedidor::class);
    // }


    /**
     * Todas as instalações deste medidor
     */
    public function cliente(): BelongsTo
    {
        // return $this->hasMany(ClienteMedidor::class, 'medidor_id');
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Instalação ativa atual
     */
    public function instalacaoAtiva(): HasOne
    {
        return $this->hasOne(ClienteMedidor::class, 'medidor_id')
            ->where('status', 'instalado')      // ou 'Ativo' - confirme seu status
            ->latest('data_instalacao');
    }

    public function instalacoes(): HasMany
    {
        return $this->hasMany(ClienteMedidor::class, 'medidor_id');
    }

    /**
     * Última instalação (independente do status)
     */
    public function ultimaInstalacao(): HasOne
    {
        return $this->hasOne(ClienteMedidor::class, 'medidor_id')
            ->latest('data_instalacao');
    }


    public function leituras()
    {
        return $this->hasMany(Leituras::class, 'medidores_id');
    }


    public function ultimaLeitura()
    {
        return $this->hasOne(Leituras::class, 'medidores_id')->latestOfMany('data_leitura');
    }

    public function estaInstalado(): bool
    {
        return $this->status_inicial === 'instalado' && $this->cliente_id !== null;
    }

    /**
     * Verifica se está em manutenção
     * NOVO
     */
    public function estaEmManutencao(): bool
    {
        return $this->status_inicial === 'Manutencao';
    }

    public function estaCortado(): bool
    {
        return $this->status_inicial === 'Cortada' || $this->status_inicial === 'Ligação Cortada';
    }
    /**
     * Quantidade disponível em estoque
     */
    // public function getQuantidadeDisponivelAttribute(): int
    // {
    //     $instalados = $this->instalacoes()
    //         ->whereIn('status', ['Ativo', 'Manutencao'])
    //         ->count();

    //     return max(0, $this->quantidade - $instalados);
    // }

    /**
     * Quantidade instalada atualmente
     */
    // public function getQuantidadeInstaladaAttribute(): int
    // {
    //     return $this->instalacoes()
    //         ->where('status', 'Ativo')
    //         ->count();
    // }

    /**
     * Quantidade em manutenção
     */
    // public function getQuantidadeManutencaoAttribute(): int
    // {
    //     return $this->instalacoes()
    //         ->where('status', 'Manutencao')
    //         ->count();
    // }
}