<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Purchase extends Model
{
    use HasUuids;
    
    protected $primaryKey = 'purchase_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['customer_id', 'amount'];

    // Uma compra pertence a um cliente
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Uma compra pode gerar muitas transações de cashback
    public function cashback_transactions()
    {
        return $this->hasMany(Cashback_Transactions::class, 'purchase_id', 'purchase_id');
    }
}
