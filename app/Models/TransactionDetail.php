<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_detail';
    protected $primaryKey = 'transaction_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'transaction_id',
        'transaction_date',
        'customer_id',
        'payment_method',
        'before_tax',
        'tax',
        'after_tax',
        'shipping_cost',
        'transaction_discount',
        'total_paid',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'before_tax' => 'decimal:2',
        'tax' => 'decimal:2',
        'after_tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'transaction_discount' => 'decimal:2',
        'total_paid' => 'decimal:2',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(CustomerDetail::class, 'customer_id', 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'transaction_id', 'transaction_id');
    }
}
