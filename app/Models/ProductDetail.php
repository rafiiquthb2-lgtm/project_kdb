<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_detail';
    protected $primaryKey = 'sku_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'sku_id',
        'category',
        'brand',
        'product',
        'variant',
        'sku_name',
        'price',
        'cogs',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cogs' => 'decimal:2',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'sku_id', 'sku_id');
    }
}
