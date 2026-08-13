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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();


            $table->foreignId('fatura_id')
                ->constrained('faturas');

            $table->foreignId('cliente_id')
                ->constrained('clientes');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users');

            $table->string('codigo_transacao')->nullable();

            $table->decimal('valor_pago', 10, 2);

            $table->date('data_pagamento');

            $table->time('hora_pagamento')->nullable();

            $table->enum('metodo_pagamento', [
                'Mpesa',
                'Emola',
                'Dinheiro',
                'Transferencia',
                'Cartao',
                'Debito_Conta'
            ]);

            $table->string('banco')->nullable();

            $table->string('numero_comprovante')->nullable();

            $table->enum('status', [
                'Pendente',
                'Confirmado',
                'Estornado',
                'Cancelado'
            ])->default('Confirmado');

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
