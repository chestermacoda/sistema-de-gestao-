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
        Schema::create('documento_historicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('fatura_id')->nullable()->constrained('faturas');
            $table->foreignId('pagamento_id')->nullable()->constrained('pagamentos');
            $table->string('tipo'); // 'fatura', 'comprovativo', 'relatorio'
            $table->string('codigo'); // FT-00042, COMP-123456
            $table->string('arquivo_nome'); // nome do PDF gerado
            $table->string('arquivo_path'); // caminho no storage
            $table->timestamp('baixado_em')->nullable(); // quando foi baixado
            $table->string('ip')->nullable(); // IP do download
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_historicos');
    }
};