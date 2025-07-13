<?php 

namespace Test\Unit;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\LoyaltyLevel;
use App\Models\LevelHistory;
use App\Services\LevelService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class LevelServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_promotes_customer_when_total_spent_reaches_min_spend()
    {
        // Arrange: Cria dois níveis
        $uno = LoyaltyLevel::create ([
            'name' => 'Uno',
            'cashback_percent' => 5.00,
            'min_spend' => 0,
            'priority' => 1,
        ]);

        $due = LoyaltyLevel::create([
            'name' => 'Due',
            'cashback_percent' => 10.00,
            'min_spend' => 300,
            'priority' => 2,
        ]);

        // Cria cliente no nível Uno
        $customer = Customer::create ([
            'customer_id' => Str::uuid(),
            'name' => 'Cliente Teste',
            'email' => 'teste@pediupaybufo.com.br',
            'current_level_id' => $uno->level_id,
            'created_at' => now(),
        ]);

        // Cria compras que somam mais de 300
        Purchase::create([
            'purchase_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'amount' => 200,
            'created_at' => now(),
        ]);

        Purchase::create ([
            'purchase_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'amount' => 150,
            'created_at' => now(),
        ]);

        // Act: chama o serviço
        $service = new LevelService();
        $service->evaluateLevel($customer);

        // Refresh e valida
        $customer->refresh();

        $this->assertEquals('Due', $customer->loyaltyLevel->name);
        $this->assertDatabaseHas('level_history', [
            'customer_id' => $customer->customer_id,
            'level_id' => $due->level_id,
        ]);
    }

    /** @test */
    public function it_does_not_promote_customer_when_total_sent_is_below_min_spend()
    {
        // Arrange: cria dois níveis
        $uno = LoyaltyLevel::create ([
            'name' => 'Uno',
            'cashback_percent' => 5.00,
            'min_spend' => 0,
            'priority' => 1,
        ]);

        $due = LoyaltyLevel::create([
            'name' => 'Due',
            'cashback_percent' => 10.00,
            'min_spend' => 300,
            'priority' => 2,
        ]);

        // Cria cliente no nível Uno
        $customer = Customer::create([
            'customer_id' => Str::uuid(),
            'name' => 'Cliente Teste',
            'email' => 'teste2@pediupaybufo.com',
            'current_level_id' => $uno->level_id,
            'created_at' => now(),
        ]);

        // Cria compras que somam menos que 300
        Purchase::create([
            'purchase_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'amount' => 100,
            'created_at' => now(),
        ]);

        Purchase::create([
            'purchase_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'amount' => 50,
            'created_at' => now(),
        ]);

        // Act: chama o serviço
        $service = new LevelService();
        $service->evaluateLevel($customer);

        // Refresh e valida
        $customer->refresh();

        // Deve permanecer no nível Uno
        $this->assertEquals('Uno', $customer->loyaltyLevel->name);

        // Não deve haver registro no histórico para o nível Due
        $this->assertDatabaseMissing('level_history', [
            'customer_id' => $customer->customer_id,
            'level_id' => $due->level_id,
    ]);

    }
}

?>
