<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Purchase;
use App\Services\CashbackService;

class SimulatePurchase extends Command
{
    //Nome do comando no terminal
    protected $signature = 'simulate:purchase {customer_id} {amount}';

    //Descrição do comando
    protected $description = 'Simula uma compra de um cliente com geração de cashback e verificação de promoção de nível';

    public function handle()
    {
        $customerId = $this->argument('customer_id');
        $amount = floatval($this->argument('amount'));

        //Buscar o cliente
        $customer = customer::where('customer_id', $customerId)->first();

        if (!$customer) {
            $this->error("Cliente não encontrado.");
            return 1;
        }

        //Criar a compra
        $purchase = Purchase::create([
            'purchase_id' => Str::uuid(),
            'customer_id' => $customer->customer_id,
            'amount' => $amount,
            'created_at' => now(),
        ]);

        //Aplicar Cashback
        $cashbackService = new CashbackService();
        $cashback = $cashbackService->registerCashback($customer, $purchase);

        //Exibir os resultados
        $customer->refresh();

        $this->info("Compra registrada com sucesso!");
        $this->line("Valor da compra: R$" . number_format($amount, 2));
        $this->line("Cashback gerado: R$" . number_format($cashback->value, 2));
        $this->line("Novo nível do cliente: R$" . $customer->loyaltyLevel->name);

        return 0;
    }
}

?>