<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Customer;
use Illuminate\Support\Str;

class PurchasesSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        $customers = Customer::pluck('customer_id')->all();

        foreach (range(1, 50) as $i) {
            Purchase::create([
                'purchase_id' => Str::uuid(),
                'customer_id' =>$faker->randomElement($customers),
                'amount' => $faker->randomFloat (2, 20, 500),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
            ]);
        }
    }
}
