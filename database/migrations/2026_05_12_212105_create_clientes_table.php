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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();


            $table->enum('tipo_pessoa', ['fisica', 'juridica'])
                ->default('fisica');

            $table->string('nome_completo');

            $table->string('bi')->unique();

            $table->string('nuit')->nullable();

            $table->string('email')->unique();

            $table->string('telefone');

            $table->date('data_nascimento')->nullable();

            $table->string('responsavel_legal')->nullable();

            /**
             * Endereço
             */
            $table->string('cidade');

            $table->string('endereco');

            $table->string('numero_casa');

            $table->string('bairro');

            $table->string('zona_distribuicao');

            $table->string('ponto_referencia')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            /**
             * Dados da Ligação
             */
            $table->string('numero_matricula')->unique();

            $table->enum('categoria_consumo', [
                'Residencial',
                'Comercial',
                'Industrial',
                'Público'
            ]);

            $table->enum('tipo_ligacao', [
                'Ligação Nova',
                'Transferência',
                'Desmembramento',
                'Regularização'
            ]);

            $table->string('diametro_ramal');

            $table->date('data_solicitacao');

            $table->date('data_prevista_ligacao')->nullable();

            $table->string('tipo_imovel');

            $table->integer('numero_economias')->default(1);

            $table->text('observacoes')->nullable();

            /**
             * Relação com Medidor
             */


            /**
             * Estado do cadastro
             */
            $table->enum('status', [
                'rascunho',
                'ativo',
                'inativo',
                'suspenso'
            ])->default('ativo');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
