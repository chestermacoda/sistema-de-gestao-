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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('razao_social');
            $table->string('nome_fantasia');
            $table->string('cnpj')->unique();
            $table->string('inscricao_estadual')->nullable();

            $table->string('email');
            $table->string('telefone');

            $table->string('endereco_completo');

            $table->string('logo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
