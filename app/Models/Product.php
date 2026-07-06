<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage; // ← TAMBAHKAN INI
 
class Product extends Model {
    use HasFactory;
    protected $table = 'produks';
    protected $fillable = ['name','slug','description','price','old_price','stock','stok','harga','thumbnail','image','sku','weight','kategori_id','subcategory_id','subsubcategory_id','brand_id','is_active','is_new','is_best_seller','sizes','colors'];
    protected $casts = ['is_active'=>'boolean','is_new'=>'boolean','is_best_seller'=>'boolean','price'=>'integer','old_price'=>'integer','sizes'=>'array','colors'=>'array'];
    protected $appends = ['thumbnail_url', 'price_formatted', 'terjual', 'rating'];
    public function category()   { return $this->belongsTo(Kategori::class, 'kategori_id'); }
    public function brand()      { return $this->belongsTo(Brand::class); }
    public function images()     { return $this->hasMany(ProductImage::class); }
    public function variants()   { return $this->hasMany(ProductVariant::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
 
    public function getStokAttribute() {
        return $this->attributes['stock'] ?? $this->attributes['stok'] ?? 0;
    }

    public function setStokAttribute($value) {
        $this->attributes['stock'] = (int) $value;
    }

    public function getHargaAttribute() {
        return $this->attributes['price'] ?? $this->attributes['harga'] ?? 0;
    }

    public function setHargaAttribute($value) {
        $this->attributes['price'] = (int) $value;
    }

    public function getDiscountPercentAttribute() {
        if (!$this->old_price || $this->old_price <= $this->price) return 0;
        return round((($this->old_price - $this->price) / $this->old_price) * 100);
    }
public function getThumbnailUrlAttribute() {
    // 1. PRIORITAS UTAMA: Kolom "image" (Gambar utama dari Form Create)
    if ($this->image) {
        return Storage::url($this->image);
    }
    
    // 2. FALLBACK: Gallery tambahan (tabel product_images)
    if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
        return Storage::url($this->images->first()->image);
    }
    
    // 3. Kolom thumbnail
    if ($this->thumbnail) {
        return Storage::url($this->thumbnail);
    }
    
    // 4. Default
    return asset('images/default-product.jpg');
}

    public function getPriceFormattedAttribute() { return 'Rp'.number_format($this->price,0,',','.'); }
    public function getOldPriceFormattedAttribute() { return $this->old_price ? 'Rp'.number_format($this->old_price,0,',','.') : null; }

    public function getTerjualAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->whereNotIn('status', ['menunggu', 'dibatalkan', 'pending']);
            })
            ->sum('quantity');
    }

    public function getRatingAttribute()
    {
        return Ulasan::whereHas('pesanan.items', function ($query) {
            $query->where('product_id', $this->id);
        })->avg('rating') ?? 0;
    }
}