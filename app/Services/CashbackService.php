<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Cashback_Transactions;
use Illuminate\Support\Str;
use Carbon\Carbon;


class CashbackService
{
    //Calcula o valor de cashback com base no percentual do nível
    public function calculateCashback(float $amount, float $percent): float
    {
        return round(($amount * $percent) / 100, 2);
    }

    //Registra uma nova transação de cashback para uma compra 
    public function registerCashback(Customer $customer, Purchase $purchase): Cashback_Transactions
    {
        //Recupera o percentual de cashbak do niel atual do cliente 
        $percent = $customer->loyaltyLevel->cashback_percent;

        //Calcula o valor do cashback
        $value = $this->calculateCashback($purchase->amount, $percent);

        //Cria e retorna a transação de cashback
        return Cashback_Transactions::create([
            'cashback_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'purchase_id' => $purchase->purchase_id,
            'value' => $value,
            'status' => 'AVAILABLE',
            'earned_at' => now(),
            'expires_at' => Carbon::now()->addMonth(),
            'used_at' => null,
        ]);
    }
}

?>