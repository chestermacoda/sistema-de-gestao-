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
        Schema::create('relatorio_agendamentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['financeiro', 'consumo', 'inadimplencia', 'operacional', 'resumo_diario', 'geral'])->default('geral');
            $table->enum('frequencia', ['diario', 'semanal', 'mensal', 'trimestral'])->default('mensal');
            $table->time('horario')->default('08:00:00');
            $table->unsignedTinyInteger('dia_semana')->nullable(); // 1=Segunda ... 7=Domingo (para semanal)
            $table->unsignedTinyInteger('dia_mes')->nullable(); // 1-28 (para mensal)
            $table->text('destinatarios'); // emails separados por vírgula
            $table->string('zona')->nullable();
            $table->string('categoria')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // quem criou
            $table->boolean('ativo')->default(true);
            $table->timestamp('ultimo_envio')->nullable();
            $table->timestamp('proximo_envio')->nullable();
            $table->timestamps();

            $table->index(['ativo', 'proximo_envio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorio_agendamentos');
    }
};
