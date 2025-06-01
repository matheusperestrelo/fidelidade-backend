<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Customer extends Model
{
    use HasUuids;

    protected $primaryKey = 'customer_id';      // Define a PK customizada
    public $incrementing = false;              //  Por ser UUID, nõ auto-incrementa
    protected $keyType = 'string';            //   UUID é string

    protected $fillable = ['customer_id', 'name', 'email', 'current_level_id', 'created_at'];

    // Um cliente pertence a um nível de fidelidade
    public function loyaltyLevel()
    {
        return $this->belongsTo(LoyaltyLevel::class, 'current_level_id', 'level_id');
    }

    // Um cliente tem muitas compras
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'customer_id', 'customer_id');
    }

    // Um cliente tem muitas transações de cashback
    public function cashbackTransactions()
    {
        return $this->hasMany(Cashback_Transactions::class, 'customer_id', 'customer_id');
    }

    // Um cliente tem um histórico de níveis
    public function levelHistory()
    {
        return $this->hasMany(LevelHistory::class, 'customer_id', 'customer_id');
    }
}
