<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'pesanans';

    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public static function generateCode(): string
    {
        return 'SAL-' . strtoupper(uniqid()) . rand(100, 999);
    }

    public function hitungTotal(): int
    {
        return (int) ($this->subtotal ?? 0) + (int) ($this->ongkir ?? 0) - (int) ($this->diskon ?? 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'pesanan_id');
    }
}