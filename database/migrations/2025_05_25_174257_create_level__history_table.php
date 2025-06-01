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
        Schema::create('level_histories', function (Blueprint $table) {
            //Chave primária UUID
            $table->uuid('history_id')->primary();


            //Cliente que teve a muança de nível
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');


            //Novo nível adquirido
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign('level_id')->references('level_id')->on('loyalty_levels')->onDelete('cascade');

            
            //Quando a mudança aconteceu
            $table->timestamp('achieved_at');


            //Timestamps padrão laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_histories');
    }
};
