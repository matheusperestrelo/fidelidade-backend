<?php 

namespace App\Services;

use App\Models\Customer;
use App\Models\LoyaltyLevel;
use App\Models\LevelHistory;
use Illuminate\Support\Str;

class LevelService 
{

    /**
     * Avalia se o cliente deve subir de nível com base nas compras acumuladas
     * Se subir atualizar o current_level_id e registra no LevelHistory
     */
    public function evaluateLevel(customer $customer): ?LoyaltyLevel
    {
        //Recupera os níveis disponíveis ordenando por prioridade (menor para maior)
        $levels = LoyaltyLevel::orderby('priority')->get();

        //Soma o vlaor total de compras do cliente
        $totalSpent = $customer->purchases()->sum('amount');

        //Nível atual do cliente
        $currentLevel = $customer->loyaltyLevel;

        //Encontra o maior nível possível com base no total gasto
        $newLevel = $levels->filter(function($level) use ($totalSpent) {
            return $totalSpent >= $level->min_spend;
        })->sortByDesc('priority')->first();

        //Se o novo nível for diferente e superior ao atual, promover
        if ($newLevel && $newLevel->priority > $currentLevel->priority) {
            //Atualiza o nível atual do cliente
            $customer->update([
                'currente_level_id' => $newLevel->level_id,
            ]);

            //Registra a mudança no histórico
            LevelHistory::create([
                'history_id' => Str::uuid(),
                'customer_id' => $customer->customer_id,
                'level_id' => $newLevel->level_id,
                'achieved_at' => now(),
            ]);

            return $newLevel;
        }

        return null;
    }

}



?>