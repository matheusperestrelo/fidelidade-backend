<?php 

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\LoyaltyLevel;
use App\Services\CashbackService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class CashbackServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_calculates_cashback_correctly_based_on_level()
    {
        $levelData = [
            'name' => 'Uno',
            'cashback_percent' => 10,
            'min_spend' => 0,
            'priority' => 1,
        ];

        $level = LoyaltyLevel::create($levelData);

        $customer = Customer::create([
            'customer_id' => Str::uuid(),
            'name' => 'Teste',
            'email' => 'teste@pediupaybufo.com.br',
            'current_level_id' => $level->level_id,
        ]);

        $customer->load('loyaltyLevel');

        $purchase = Purchase::create([
            'purchase_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'amount' => 200.00,
            'created_at' => now(),
        ]);

        $service = new CashbackService();
        $cashback = $service->registerCashback($customer, $purchase);

        $this->assertEquals(20.00, $cashback->value);
        $this->assertEquals('AVAILABLE', $cashback->status);
        $this->assertEquals($purchase->purchase_id, $cashback->purchase_id);
        $this->assertEquals($customer->customer_id, $cashback->customer_id);
        $this->assertNotNull($cashback->earned_at);
        $this->assertNotNull($cashback->expires_at);
    }
}

?>
