<?php

namespace Database\Seeders;

use App\Models\Cashback_Transactions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CashbackTransaction;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Support\Str;

class CashbackTransactionsseeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        $customers = Customer::pluck('customer_id')->all();
        $purchases = Purchase::all();

        foreach ($purchases as $purchase) {
            Cashback_Transactions::create([
                'cashback_id' => Str::uuid(),
                'customer_id' => $purchase ->customer_id,
                'purchase_id' => $purchase->purchase_id,
                'value' => round($purchase->amount * 0.1, 2), //10% de cashback
                'status' => $faker->randomElement(['AVAILABLE', 'USED', 'EXPIRED']),
                'earned_at' => $purchase->created_at,
                'expires_at' => $faker->dateTimeBetween('now', '+3 months'),
                'used_at' => $faker->optional()->dateTimeBetween($purchase->created_at, 'now')
            ]);
        }

    }
}
