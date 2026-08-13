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
        Schema::create('roteiro_leituristas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('fatura_id')
                ->nullable()
                ->constrained('faturas')
                ->nullOnDelete();

            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();

            $table->date('data_referente');

            $table->decimal('leitura_anterior', 10, 2)->default(0);
            $table->decimal('leitura_atual', 10, 2)->nullable();

            $table->dateTime('data_inicio')->nullable();
            $table->dateTime('data_fim')->nullable();

            $table->string('Zona')->nullable();

            $table->enum('status', [
                'Pendente',
                'Em andamento',
                'Concluido',
                'Não lido',
                'Problema',
            ])->default('Pendente');

            $table->text('observacoes')->nullable();

            $table->integer('ordem')->nullable();
            $table->string('foto')->nullable();

            $table->timestamp('lido_em')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roteiro_leituristas');
    }
};
