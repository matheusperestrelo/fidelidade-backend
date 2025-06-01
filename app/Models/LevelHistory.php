<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LevelHistory extends Model
{
    use HasUuids;

    protected $primaryKey = 'history_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['customer_id', 'level_id', 'achieved_at'];

    // Historico pertenc a um cliente
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    //Historico pertence a um nivel
    public function loyaltylevels()
    {
        return $this->belongsTo(LoyaltyLevel::class, 'level_id', 'level_id');
    }
}
