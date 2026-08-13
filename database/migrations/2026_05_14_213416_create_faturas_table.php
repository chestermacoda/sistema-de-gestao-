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
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->constrained('clientes');

            $table->foreignId('leitura_id')
                ->nullable()
                ->constrained('leituras');

            $table->string('codigo_fatura')->unique();

            $table->string('mes_referencia');

            $table->date('periodo_inicio');
            $table->date('periodo_fim');

            $table->decimal('consumo_m3', 10, 2)->default(0);

            $table->decimal('valor_consumo', 10, 2)->default(0);
            $table->decimal('valor_esgoto', 10, 2)->default(0);
            $table->decimal('taxa_disponibilidade', 10, 2)->default(0);

            $table->decimal('multa', 10, 2)->default(0);
            $table->decimal('juros', 10, 2)->default(0);
            $table->decimal('desconto', 10, 2)->default(0);

            $table->decimal('valor_total', 10, 2);

            $table->date('data_emissao');
            $table->date('data_vencimento');

            $table->enum('status', [
                'Pendente',
                'Pago',
                'Parcial',
                'Vencida',
                'Negociada',
                'Cancelada',
                'Estornada'
            ])->default('Pendente');

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas');
    }
};
