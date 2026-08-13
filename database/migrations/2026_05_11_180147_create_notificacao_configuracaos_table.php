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
        Schema::create('notificacao_configuracaos', function (Blueprint $table) {
            $table->id();


            // E-mail de vencimento
            $table->boolean('email_vencimento')->default(true);
            $table->integer('dias_antes_vencimento')->default(3);

            // SMS de atraso
            $table->boolean('sms_atraso')->default(true);
            $table->integer('dias_atraso_sms')->default(5);

            // Consumo anômalo
            $table->boolean('consumo_anomalo')->default(true);
            $table->integer('percentual_consumo_anomalo')->default(150);

            // Novo cadastro
            $table->boolean('novo_cadastro')->default(false);

            // Relatório semanal
            $table->boolean('relatorio_semanal')->default(false);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacao_configuracaos');
    }
};
