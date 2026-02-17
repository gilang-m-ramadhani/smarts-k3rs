<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Maintenance extends Model // implements Auditable
{
    use HasFactory;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'maintenance';
    protected $primaryKey = 'wo_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'wo_number',
        'id_apar',
        'teknisi_id',
        'supervisor_id',
        'assigned_to',
        'created_by',
        'scheduled_date',
        'completed_date',
        'maintenance_type',
        'work_description',
        'material_used',
        'cost',
        'before_photo',
        'after_photo',
        'supervisor_approval',
        'approval_date',
        'approval_notes',
        'status',
        'priority',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'approval_date' => 'date',
        'cost' => 'decimal:2',
        'supervisor_approval' => 'boolean',
    ];

    // Relationships
    public function apar()
    {
        return $this->belongsTo(Apar::class, 'id_apar', 'id_apar');
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Accessors
    public function getMaintenanceTypeLabelAttribute(): string
    {
        return match($this->maintenance_type) {
            'ringan' => 'Ringan (Monthly)',
            'sedang' => 'Sedang (6 Monthly)',
            'berat' => 'Berat (Yearly)',
            default => $this->maintenance_type,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'in_progress' => 'badge-info',
            'completed' => 'badge-success',
            'cancelled' => 'badge-error',
            default => 'badge-ghost',
        };
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeNeedsApproval($query)
    {
        return $query->where('status', 'completed')
                     ->where('supervisor_approval', false);
    }

    public function scopeByTeknisi($query, $teknisiId)
    {
        return $query->where('teknisi_id', $teknisiId);
    }

    // Methods
    public static function generateWoNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $lastWo = self::where('wo_number', 'like', "WO-{$year}{$month}-%")
            ->orderBy('wo_number', 'desc')
            ->first();

        if ($lastWo) {
            $lastNumber = (int) substr($lastWo->wo_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf("WO-%s%s-%04d", $year, $month, $newNumber);
    }

    public function markAsInProgress(): void
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markAsCompleted(array $data = []): void
    {
        $this->update(array_merge([
            'status' => 'completed',
            'completed_date' => now(),
        ], $data));
    }

    public function approve(?string $notes = null): void
    {
        $this->update([
            'supervisor_approval' => true,
            'approval_date' => now(),
            'approval_notes' => $notes,
        ]);
    }
}


