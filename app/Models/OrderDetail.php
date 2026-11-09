<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'transaction_id',
        'customer_id',
        'order_date',
        'channel_type',
        'sku_id',
        'quantity',
        'price',
        'before_discount',
        'discount_item',
        'after_discount',
        'is_gross',
        'is_valid',
        'is_net',
    ];

    protected $casts = [
        'order_date' => 'date',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'before_discount' => 'decimal:2',
        'discount_item' => 'decimal:2',
        'after_discount' => 'decimal:2',
        'is_gross' => 'boolean',
        'is_valid' => 'boolean',
        'is_net' => 'boolean',
    ];

    // Relationships
    public function transaction()
    {
        return $this->belongsTo(TransactionDetail::class, 'transaction_id', 'transaction_id');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerDetail::class, 'customer_id', 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductDetail::class, 'sku_id', 'sku_id');
    }
}
