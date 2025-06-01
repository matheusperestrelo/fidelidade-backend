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
        Schema::create('customers', function (Blueprint $table) {
            //Chave primária UUID
            $table->uuid('customer_id')->primary();


            //Camops do cliente
            $table->string('name');
            $table->string('email')->unique();


            //Relacionamento com LoyaltyLevels
            $table->unsignedBigInteger('current_level_id')->nullable();
            $table->foreign('current_level_id')->references('level_id')->on('loyalty_levels');


            // Timestamps Laravel (Created_at e Updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
