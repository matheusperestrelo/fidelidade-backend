<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Cashback_Transactions extends Model
{
    use HasUuids;

    protected $primaryKey = 'cashback_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['customer_id', 'purchase_id', 'value', 'status', 'earned_at', 'expires_at', 'used_at'];

    // Transação pertence a um cliente
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    //Transação pertence a uma compra
    public function purchases()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'purchase_id');
    }
    
}
