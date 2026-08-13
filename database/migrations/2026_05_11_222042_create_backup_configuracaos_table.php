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
        Schema::create('backup_configuracaos', function (Blueprint $table) {
            $table->id();

            $table->string('frequencia')->default('semanal'); // diario, semanal, mensal
            $table->time('horario')->default('02:00');

            $table->integer('retencao_dias')->default(30);

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_configuracaos');
    }
};
