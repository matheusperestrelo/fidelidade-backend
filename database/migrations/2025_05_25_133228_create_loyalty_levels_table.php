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
        Schema::create('loyalty_levels', function (Blueprint $table) {
            //Chave primária autoincrementada
            $table->id('level_id');


            //Nome do nível
            $table->string('name');


            //Percentual de cashback (ex: 10.00%)
            $table->decimal('cashback_percent', 5, 2);


            //Gasto mínimo acumulado necessário para atingir o nível
            $table->decimal('min_spend', 10, 2);


            //Ordem do nível (1 = básico, 2 = intermediário, etc)
            $table->integer('priority');


            //Timestamps adrão laravel
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_levels');
    }
};
