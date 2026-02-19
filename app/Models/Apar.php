<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Apar extends Model // implements Auditable
{
    use HasFactory;
    // use \OwenIt\Auditing\Auditable;

    protected $table = 'apar';
    protected $primaryKey = 'id_apar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_apar',
        'kode_qr',
        'tipe_apar',
        'kapasitas',
        'merk',
        'no_seri',
        'tanggal_produksi',
        'tanggal_pengisian',
        'tanggal_expire',
        'id_lokasi',
        'id_vendor',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal_produksi' => 'date',
        'tanggal_pengisian' => 'date',
        'tanggal_expire' => 'date',
        'kapasitas' => 'decimal:2',
    ];

    protected $appends = ['is_expired', 'days_until_expire'];

    // Relationships
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor', 'id_vendor');
    }

    public function inspeksi()
    {
        return $this->hasMany(Inspeksi::class, 'id_apar', 'id_apar');
    }

    public function latestInspeksi()
    {
        return $this->hasOne(Inspeksi::class, 'id_apar', 'id_apar')->latestOfMany('id_inspeksi');
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'id_apar', 'id_apar');
    }

    // Accessors
    public function getIsExpiredAttribute(): bool
    {
        return $this->tanggal_expire->isPast();
    }

    public function getDaysUntilExpireAttribute(): int
    {
        return now()->diffInDays($this->tanggal_expire, false);
    }

    public function getTipeAparLabelAttribute(): string
    {
        return match($this->tipe_apar) {
            'powder' => 'Dry Chemical Powder',
            'co2' => 'Carbon Dioxide (CO2)',
            'foam' => 'Foam/Busa',
            'liquid' => 'Liquid/Cairan',
            default => $this->tipe_apar,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'aktif' => 'badge-success',
            'rusak' => 'badge-error',
            'expired' => 'badge-warning',
            'maintenance' => 'badge-info',
            'disposed' => 'badge-ungu',
            default => 'badge-ghost',
        };
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeExpired($query)
    {
        return $query->where('tanggal_expire', '<', now());
    }

    public function scopeWillExpireSoon($query, $days = 30)
    {
        return $query->whereBetween('tanggal_expire', [now(), now()->addDays($days)]);
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_apar', $tipe);
    }

    public function scopeByLokasi($query, $lokasiId)
    {
        return $query->where('id_lokasi', $lokasiId);
    }

    public function scopeNeedsInspection($query)
    {
        return $query->where('status', 'aktif')
            ->whereDoesntHave('inspeksi', function ($q) {
                $q->whereMonth('tanggal_inspeksi', now()->month)
                  ->whereYear('tanggal_inspeksi', now()->year);
            });
    }

    // Methods
    public static function generateId(): string
    {
        $year = date('Y');
        $lastApar = self::where('id_apar', 'like', "APAR-{$year}-%")
            ->orderBy('id_apar', 'desc')
            ->first();

        if ($lastApar) {
            $lastNumber = (int) substr($lastApar->id_apar, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return sprintf("APAR-%s-%04d", $year, $newNumber);
    }

    public static function generateQrCode(string $idApar): string
    {
        return 'QR-' . strtoupper(md5($idApar . time()));
    }

    public function generateQrImage()
    {
        return QrCode::size(200)
            ->format('svg')
            ->generate(route('apar.show', $this->id_apar));
    }
}


