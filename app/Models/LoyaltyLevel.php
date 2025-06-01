<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltyLevel extends Model
{
    protected $primarykey = 'level_id';
    public $incrementing = true;          // SERIAL auto-incrementa
    protected $keyType = 'int';

    protected $fillable = ['name', 'cashback', 'min_spend'. 'pririty'];

    // Um nivel pode ter vários clientes
    public function customer()
    {
        return $this->hasMany(Customer::class, 'current_level_id', 'level_id');
    }

    // Um nível tem mutos históricos
    public function levelhistory()
    {
        return $this->hasMany(LevelHistory::class, 'level_id', 'level_id');
    }

}
