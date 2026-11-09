<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'customer_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ========================================
    // ROLE CHECK HELPERS
    // ========================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDataAnalyst(): bool
    {
        return $this->role === 'data_analyst';
    }

    public function isAuditor(): bool
    {
        return $this->role === 'auditor';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            return $this->role === $roles;
        }
        return in_array($this->role, $roles);
    }

    // ========================================
    // RELATIONSHIPS
    // ========================================

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Link to customer_detail record (for customer role users).
     */
    public function customerDetail()
    {
        return $this->belongsTo(CustomerDetail::class, 'customer_id', 'customer_id');
    }
}
