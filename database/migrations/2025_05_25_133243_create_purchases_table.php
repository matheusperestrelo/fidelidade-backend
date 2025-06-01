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
        Schema::create('purchases', function (Blueprint $table) {
            //Cahve primária uuid
            $table->uuid('purchase_id')->primary();


            //Chave estrangeira para o cliente
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers');


            //Valor de compra
            $table->decimal('amount');


            //Timestamps da compra Laravel
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
