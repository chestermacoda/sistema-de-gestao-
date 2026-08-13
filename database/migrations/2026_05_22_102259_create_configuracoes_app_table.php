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
        Schema::create('configuracoes_app', function (Blueprint $table) {
            $table->id();

            // Relacionamento com utilizador/leiturista
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // Notificações
            $table->boolean('notif_novas_leituras')->default(true);
            $table->boolean('notif_anomalias')->default(true);
            $table->boolean('notif_sincronizacao')->default(false);

            // Aparência
            $table->string('tema');

            // Dados
            $table->boolean('modo_offline')->default(true);

            $table->boolean('fotos_alta_resolucao')
                ->default(false);

            // Cache em MB
            $table->integer('cache_utilizado')
                ->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes_app');
    }
};
