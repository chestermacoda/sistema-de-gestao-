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
        Schema::create('relatorios_analiticos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['financeiro', 'consumo', 'inadimplencia', 'operacional', 'geral'])->default('geral');
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->string('zona')->nullable(); // Todas, Norte, Sul, Leste, Oeste, Centro
            $table->string('categoria')->nullable(); // Residencial, Comercial, Industrial, Publico
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['processando', 'pronto', 'erro', 'agendado'])->default('processando');
            $table->string('ficheiro_caminho')->nullable(); // caminho do PDF/Excel gerado
            $table->string('nome_arquivo')->nullable();
            $table->json('parametros')->nullable(); // filtros extras
            $table->json('resumo')->nullable(); // métricas principais (faturamento, volume, etc.)
            $table->timestamp('gerado_em')->nullable();
            $table->timestamps();

            $table->index(['tipo', 'status']);
            $table->index('user_id');
            $table->index('gerado_em');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorios_analiticos');
    }
};
