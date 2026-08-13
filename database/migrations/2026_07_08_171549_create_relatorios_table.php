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
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->integer('fatura_id');
            $table->string('origem');
            $table->string('user_id');
            $table->string('data_referencia');
            $table->string('ficheiro_caminho');
            $table->string('nome_arquivo');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relatorios');
    }
};