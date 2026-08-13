<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leituras', function (Blueprint $table) {
            $table->id();
            /*
            |--------------------------------------------------------------------------
            | RELACIONAMENTOS
            |--------------------------------------------------------------------------
            */

            $table->foreignId('cliente_medidor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('medidores_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id') // leiturista
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | REFERÊNCIA DA LEITURA
            |--------------------------------------------------------------------------
            */

            $table->string('mes_referencia', 7); // 2026-05

            $table->date('data_leitura');

            $table->time('hora_leitura');

            /*
            |--------------------------------------------------------------------------
            | DADOS DA LEITURA
            |--------------------------------------------------------------------------
            */

            $table->decimal('leitura_anterior', 12, 3);

            $table->decimal('leitura_atual', 12, 3);

            $table->decimal('consumo', 12, 3);

            $table->decimal('consumo_medio', 12, 3)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pendente',
                'validada',
                'anomalia',
                'revisao',
                'faturada',
                'cancelada'
            ])->default('pendente');

            /*
            |--------------------------------------------------------------------------
            | ANOMALIAS
            |--------------------------------------------------------------------------
            */

            $table->boolean('tem_anomalia')
                ->default(false);

            $table->string('tipo_anomalia')
                ->nullable();

            $table->text('descricao_anomalia')
                ->nullable();

            $table->string('acao_corretiva')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | EDIÇÃO / AUDITORIA
            |--------------------------------------------------------------------------
            */

            $table->boolean('editada')
                ->default(false);

            $table->foreignId('editado_por')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('motivo_edicao')
                ->nullable();

            $table->timestamp('editado_em')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | OBSERVAÇÕES
            |--------------------------------------------------------------------------
            */

            $table->text('observacoes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GEOLOCALIZAÇÃO (opcional mobile)
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 7)
                ->nullable();

            $table->decimal('longitude', 10, 7)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | CONFIRMAÇÃO LOCAL
            |--------------------------------------------------------------------------
            */

            $table->boolean('confirmada_local')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | IMPORTAÇÃO / APP
            |--------------------------------------------------------------------------
            */

            $table->enum('origem', [
                'manual',
                'importacao',
                'mobile',
            ])->default('manual');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | UNIQUE
            |--------------------------------------------------------------------------
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leituras');
    }
};
