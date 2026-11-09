<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditObserver
{
    /**
     * Columns that contain encrypted data.
     * These are stored as ciphertext in DB, so we label them accordingly
     * in audit logs rather than exposing raw ciphertext or plaintext.
     */
    protected array $encryptedColumns = ['customer_name', 'dob'];

    /**
     * Handle the "created" event.
     */
    public function created(Model $model): void
    {
        $attributes = $model->getAttributes();
        $this->logAudit('INSERT', $model, null, $this->sanitizeValues($attributes));
    }

    /**
     * Handle the "updated" event.
     */
    public function updated(Model $model): void
    {
        $oldValues = [];
        $newValues = [];

        foreach ($model->getChanges() as $key => $newValue) {
            if ($key === 'updated_at') continue;

            $originalValue = $model->getOriginal($key);

            // For encrypted columns: indicate that the value changed
            // without logging the raw ciphertext or plaintext
            if (in_array($key, $this->encryptedColumns)) {
                $oldValues[$key] = '[ENCRYPTED - changed]';
                $newValues[$key] = '[ENCRYPTED - updated]';
            } else {
                $oldValues[$key] = $originalValue;
                $newValues[$key] = $newValue;
            }
        }

        if (!empty($newValues)) {
            $this->logAudit('UPDATE', $model, $oldValues, $newValues);
        }
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $original = $model->getOriginal();
        $this->logAudit('DELETE', $model, $this->sanitizeValues($original), null);
    }

    /**
     * Sanitize values to avoid logging raw ciphertext or plaintext PII.
     */
    protected function sanitizeValues(array $values): array
    {
        foreach ($this->encryptedColumns as $col) {
            if (isset($values[$col])) {
                $values[$col] = '[ENCRYPTED]';
            }
        }
        return $values;
    }

    /**
     * Write the audit log entry to the database.
     */
    protected function logAudit(string $eventType, Model $model, ?array $oldValues, ?array $newValues): void
    {
        AuditLog::create([
            'user_id'    => Auth::id(),
            'event_type' => $eventType,
            'table_name' => $model->getTable(),
            'record_id'  => (string) $model->getKey(),
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip_address'  => Request::ip(),
            'created_at'  => now(),
        ]);
    }
}
