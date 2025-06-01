<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LevelHistory;
use App\Models\Customer;
use App\models\LoyaltyLevel;
use Illuminate\Support\Str;

class LevelHistorySeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::Create();

        $levels =LoyaltyLevel::pluck('level_id')->all();
        $customers = Customer::all();

        foreach ($customers as $customer) {
            $historyCount = $faker->numberBetween(1, 3);
            $usedLevels = [];

            foreach (range(1, $historyCount) as $i) {
                $level = $faker->randomElement(array_diff($levels, $usedLevels));

                LevelHistory::create([
                    'history_id' => Str::uuid(),
                    'customer_id' => $customer->customer_id,
                    'level_id' => $level,
                    'achieved_at' => $faker->dateTimeBetween('- year', 'now'),
                ]);
            }
        }
    }
}
