<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Inspeksi extends Model // implements Auditable
{
    use HasFactory;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'inspeksi';
    protected $primaryKey = 'id_inspeksi';

    protected $fillable = [
        'id_apar',
        'id_user',
        'tanggal_inspeksi',
        'next_inspection',
        'pressure_status',
        'physical_condition',
        'seal_condition',
        'hose_condition',
        'nozzle_condition',
        'handle_condition',
        'label_condition',
        'signage_condition',
        'height_position',
        'accessibility',
        'cleanliness',
        'overall_status',
        'catatan',
        'photo_path',
        'signature_path',
    ];

    protected $casts = [
        'tanggal_inspeksi' => 'date',
        'next_inspection' => 'date',
        'seal_condition' => 'boolean',
        'hose_condition' => 'boolean',
        'nozzle_condition' => 'boolean',
        'handle_condition' => 'boolean',
        'label_condition' => 'boolean',
        'signage_condition' => 'boolean',
        'height_position' => 'boolean',
        'accessibility' => 'boolean',
        'cleanliness' => 'boolean',
    ];

    // Relationships
    public function apar()
    {
        return $this->belongsTo(Apar::class, 'id_apar', 'id_apar');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Accessors
    public function getChecklistScoreAttribute(): int
    {
        $score = 0;
        $checks = [
            'seal_condition', 'hose_condition', 'nozzle_condition',
            'handle_condition', 'label_condition', 'signage_condition',
            'height_position', 'accessibility', 'cleanliness'
        ];

        foreach ($checks as $check) {
            if ($this->$check) $score++;
        }

        // Pressure & physical add to score
        if ($this->pressure_status === 'hijau') $score++;
        if ($this->physical_condition === 'baik') $score++;

        return $score;
    }

    public function getOverallStatusBadgeAttribute(): string
    {
        return match($this->overall_status) {
            'baik' => 'badge-primary',
            'kurang' => 'badge-accent',
            'rusak' => 'badge-error',
            default => 'badge-ghost',
        };
    }

    // Scopes
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('tanggal_inspeksi', now()->month)
                     ->whereYear('tanggal_inspeksi', now()->year);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('overall_status', $status);
    }

    // Methods
    public function calculateOverallStatus(): string
    {
        $score = $this->checklist_score;
        
        if ($score >= 10) return 'baik';
        if ($score >= 7) return 'kurang';
        return 'rusak';
    }

    public static function getChecklist(): array
    {
        return [
            'physical_condition' => 'Kondisi fisik tabung (tidak penyok, korosi)',
            'pressure_status' => 'Pressure gauge dalam zona hijau',
            'seal_condition' => 'Seal/pin pengaman utuh',
            'hose_condition' => 'Selang tidak tersumbat, lentur',
            'nozzle_condition' => 'Nozzle bersih, tidak rusak',
            'handle_condition' => 'Handle operasi berfungsi',
            'label_condition' => 'Label instruksi jelas terbaca',
            'signage_condition' => 'Signage "APAR" terpasang dengan benar',
            'height_position' => 'Jarak dari lantai 1-1.5 meter',
            'accessibility' => 'Akses tidak terhalang (min. 1 meter)',
            'cleanliness' => 'Kebersihan alat dan sekitarnya',
        ];
    }
}