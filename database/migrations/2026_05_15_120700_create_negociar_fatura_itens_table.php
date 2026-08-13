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
        Schema::create('negociar_fatura_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negociar_fatura_id')
                ->constrained('negociar_faturas');

            $table->foreignId('fatura_id')
                ->constrained('faturas');

            $table->decimal('valor_original', 10, 2);

            $table->decimal('valor_negociado', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negociar_fatura_itens');
    }
};
