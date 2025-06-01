<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LoyaltyLevel;

class LoyaltyLevelsSeeder extends Seeder
{
  
    public function run()
    {
        LoyaltyLevel::insert([
            ['name' => 'Uno', 'cashback_percent' => 5.00, 'min_spend' => 0, 'priority' => 1],
            ['name' => 'Due', 'cashback_percent' => 10.00, 'min_spend' => 500, 'priority' => 2],
            ['name' => 'Tre', 'cashback_percent' => 15.00, 'min_spend' => 1000, 'priority' => 3],
        ]);
    }
}
