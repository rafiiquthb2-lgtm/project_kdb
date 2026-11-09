<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CustomerDetail extends Model
{
    protected $table = 'customer_detail';
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'registration_date',
        'customer_name',
        'customer_type',
        'dob',
        'province',
        'registration_channel',
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    // ========================================
    // AES-256 ENCRYPTION MUTATORS & ACCESSORS
    // ========================================

    /**
     * Encrypt customer_name before storing in database.
     * Laravel's Crypt facade uses AES-256-CBC by default.
     */
    public function setCustomerNameAttribute($value): void
    {
        $this->attributes['customer_name'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt customer_name when retrieving from database.
     * Returns '[ENCRYPTED]' placeholder if decryption fails or user lacks permission.
     */
    public function getCustomerNameAttribute($value): string
    {
        if (!$value) return '';
        
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return '[ENCRYPTED]';
        }
    }

    /**
     * Get the raw encrypted value of customer_name (for display purposes).
     */
    public function getRawCustomerName(): ?string
    {
        return $this->attributes['customer_name'] ?? null;
    }

    /**
     * Encrypt dob before storing in database.
     */
    public function setDobAttribute($value): void
    {
        $this->attributes['dob'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Decrypt dob when retrieving from database.
     */
    public function getDobAttribute($value): string
    {
        if (!$value) return '';
        
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return '[ENCRYPTED]';
        }
    }

    /**
     * Get the raw encrypted value of dob.
     */
    public function getRawDob(): ?string
    {
        return $this->attributes['dob'] ?? null;
    }

    // Relationships
    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'customer_id', 'customer_id');
    }

    public function transactions()
    {
        return $this->hasMany(TransactionDetail::class, 'customer_id', 'customer_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'customer_id', 'customer_id');
    }
}
