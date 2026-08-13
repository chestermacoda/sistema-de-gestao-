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
        Schema::create('medidores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                ->nullable() // Permite que o campo fique vazio
                ->constrained('clientes')
                ->onDelete('set null');
            // Identificação
            $table->string('numero_hidrometro')->unique();
            $table->string('numero_serie')->nullable();

            // Fabricante
            $table->string('marca');
            $table->string('modelo')->nullable();

            // Especificações
            $table->enum('diametro', [
                '15mm',
                '20mm',
                '25mm',
                '32mm',
                '40mm',
                '50mm',
                '75mm',
                '100mm',
            ]);

            $table->enum('tipo_hidrometro', [
                'Unijato / Velocidade',
                'Multijato',
                'Woltman',
                'Ultrassônico',
                'Eletromagnético',
                'Smart / Inteligente',
            ]);

            $table->enum('classe_metrologica', [
                'Classe A',
                'Classe B',
                'Classe C',
            ])->nullable();

            // Vazões
            $table->string('qn')->nullable();
            $table->string('qmax')->nullable();
            $table->string('qmin')->nullable();

            // Fabricação
            $table->year('ano_fabricacao')->nullable();

            // Compra
            $table->date('data_aquisicao');

            $table->string('fornecedor')->nullable();
            $table->string('nota_fiscal')->nullable();

            // Status
            $table->enum('status_inicial', [
                'estoque',
                'instalar'
            ])->default('estoque');

            // Observações
            $table->text('observacoes')->nullable();

            // Documentos
            $table->string('certificado_calibracao')->nullable();
            $table->string('laudo_inmetro')->nullable();

            // Certificação
            $table->string('numero_certificado_inmetro')->nullable();

            $table->date('validade_certificado')->nullable();

            $table->string('laboratorio_calibracao')->nullable();

            $table->integer('quantidade')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medidores');
    }
};
