<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    // Sesuaikan nama tabel kamu
    protected $table = 'pesanans';

    // Status yang tersedia
    const STATUS_MENUNGGU      = 'menunggu';
    const STATUS_DIKONFIRMASI  = 'dikonfirmasi';
    const STATUS_DIKEMAS       = 'dikemas';
    const STATUS_DIKIRIM       = 'dikirim';
    const STATUS_DIPERJALANAN  = 'diperjalanan';
    const STATUS_SELESAI       = 'selesai';
    const STATUS_DIBATALKAN    = 'dibatalkan';

    protected $fillable = [
        'user_id',
        'invoice',
        'total',
        'payment_method',
        'payment_proof',
        'unique_code',
        'payment_status',
        'status',
        'notes',
        'shipping_address',
        'shipping_name',
        'shipping_phone',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail pesanan
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Scope: filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope: search
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where(function($q) use ($keyword) {
                $q->where('invoice', 'LIKE', "%{$keyword}%")
                  ->orWhere('id', 'LIKE', "%{$keyword}%")
                  ->orWhere('shipping_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('shipping_phone', 'LIKE', "%{$keyword}%");
            });
        }
        return $query;
    }
}