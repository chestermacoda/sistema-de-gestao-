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
        Schema::create('negociar_faturas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fatura_id')
                ->constrained('faturas');

            $table->foreignId('cliente_id')
                ->constrained('clientes');

            $table->foreignId('user_id')
                ->constrained('users');

            $table->string('tipo_negociacao');

            $table->decimal('valor_original', 10, 2);

            $table->decimal('desconto', 10, 2)->default(0);

            $table->decimal('juros', 10, 2)->default(0);

            $table->decimal('valor_final', 10, 2);

            $table->integer('quantidade_parcelas');

            $table->enum('status', [
                'Ativa',
                'Paga',
                'Cancelada',
                'Inadimplente'
            ])->default('Ativa');

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negociar_faturas');
    }
};
