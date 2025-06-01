<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\LoyaltyLevel;
use Illuminate\Support\Str;


class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        $levels = LoyaltyLevel::pluck('level_id')->all();

        foreach (range(1, 20) as $i)    {
            Customer::create([
                'customer_id' => Str::uuid(),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'current_level_id' => $faker->randomElement($levels),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
