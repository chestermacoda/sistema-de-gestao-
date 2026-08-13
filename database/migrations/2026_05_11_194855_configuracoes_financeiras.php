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
        Schema::create('configuracoesfinanceiras', function (Blueprint $table) {
            $table->id();

            $table->decimal('multa_atraso', 5, 2)->default(0);
            $table->decimal('juros_mes', 5, 2)->default(0);
            $table->integer('dias_tolerancia')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
