<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
        LoyaltyLevelsSeeder::class,
        CustomerSeeder::class,
        PurchasesSeeder::class,
        CashbackTransactionsSeeder::class,
        LevelHistorySeeder::class,
        ]);
    }
}
