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
        Schema::create('cliente_medidors', function (Blueprint $table) {
            $table->id();


            $table->foreignId('cliente_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('medidor_id')
                ->constrained('medidores')
                ->cascadeOnDelete();

            /**
             * Dados da instalação
             */

            $table->integer('leitura_inicial')
                ->default(0);

            $table->date('data_instalacao');

            $table->string('local_instalacao')
                ->nullable();

            $table->string('condicao_hidrometro')
                ->nullable();

            $table->string('numero_lacre')
                ->nullable();

            $table->boolean('vistoria_realizada')
                ->default(true);

            /**
             * Controle operacional
             */

            $table->enum('status', [
                'instalado',
                'removido',
                'manutencao',
            ])->default('instalado');

            $table->date('data_remocao')->nullable();

            $table->text('observacoes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_medidors');
    }
};
