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
        Schema::create('cashback__transactions', function (Blueprint $table) {

            //Chave primária UUID
            $table->uuid('cashback_id')->primary();
            

            //Cliente que recebeu o cashback (chave estrangeira)
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');


            //Compra relacionada ao cashback (chave estrangeira)
            $table->uuid('purchase_id');
            $table->foreign('purchase_id')->references('purchase_id')->on('purchases')->onDelete('cascade');


            //Valor do cashback concedido
            $table->decimal('value', 10, 2);


            //Status do cashback: disponível, usado ou expirad 
            $table->enum('status', ['AVAILABLE', 'USED', 'EXPIRED'])-> default('AVAILABLE');

            // Datas importantes do ciclo do cashback
            $table->timestamp('earned_at');
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();

            //Timestamps padrão so Laravel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashback__transactions');
    }
};
