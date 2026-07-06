<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Kategori;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('kategoris.id', 'kategoris.name', DB::raw('COUNT(produks.id) as produk_count'))
                        ->leftJoin('produks', 'kategoris.id', '=', 'produks.kategori_id') 
                        ->groupBy('kategoris.id', 'kategoris.name')
                        ->orderBy('kategoris.name')
                        ->get();

        $produk = Product::with(['category', 'brand'])
                        ->where('is_active', true)
                        ->latest()
                        ->take(12)
                        ->get();

        $orders = [];
        if (Auth::check()) {
            $orders = Order::where('user_id', Auth::id())
                ->with(['items.produk', 'ulasan'])
                ->latest()
                ->get();
        }

        return view('front.landing', [
            'kategori'    => $kategori,
            'produk'      => $produk,
            'orders'      => $orders,
            'provinsi'    => $this->provinsiList(),
            'kurir'       => ['jne' => 'JNE', 'jnt' => 'J&T', 'sicepat' => 'SiCepat'],
            'ongkirRates' => $this->ongkirRates(),
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $produk = Product::with(['category', 'brand'])
                        ->where('is_active', true)
                        ->latest()
                        ->skip($offset)
                        ->take($limit)
                        ->get();

        $html = '';
        foreach ($produk as $p) {
            $html .= view('front.partials.product_card', compact('p'))->render();
        }

        return response()->json([
            'html' => $html,
            'hasMore' => $produk->count() === $limit
        ]);
    }

    public function produkDetail($id)
    {
        $produk = Product::with(['category', 'brand', 'images'])->findOrFail($id);

        $mainImage = null;
        if ($produk->image) {
            $mainImage = str_starts_with($produk->image, 'http')
                ? $produk->image
                : asset('storage/' . $produk->image);
        } elseif ($produk->thumbnail) {
            $mainImage = str_starts_with($produk->thumbnail, 'http')
                ? $produk->thumbnail
                : asset('storage/' . $produk->thumbnail);
        }

        $allImages = [];
        if ($produk->images && $produk->images->count()) {
            foreach ($produk->images as $img) {
                $path = $img->image ?? $img->file ?? '';
                if ($path) {
                    $allImages[] = [
                        'id'  => $img->id,
                        'url' => str_starts_with($path, 'http') ? $path : asset('storage/' . $path),
                    ];
                }
            }
        }
        if (!$mainImage && count($allImages)) {
            $mainImage = $allImages[0]['url'];
        }

        return response()->json([
            'data' => [
                'id'          => $produk->id,
                'name'        => $produk->name,
                'slug'        => $produk->slug,
                'description' => $produk->description,
                'price'       => $produk->price,
                'old_price'   => $produk->old_price,
                'stock'       => $produk->stock,
                'sizes'       => $produk->sizes ?? [],
                'colors'      => $produk->colors ?? [],
                'rating'      => $produk->rating,
                'terjual'     => $produk->terjual,
                'is_active'   => $produk->is_active,
                'category'    => $produk->category,
                'brand'       => $produk->brand,
                'images'      => count($allImages) ? $allImages : [['id' => $produk->id, 'url' => $mainImage]],
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'user'    => [
                'name'  => $user->name,
                'phone' => $user->phone,
            ]
        ]);
    }

    private function provinsiList(): array
    {
        return [
            'aceh'             => 'Aceh',
            'sumatera-utara'   => 'Sumatera Utara',
            'sumatera-barat'   => 'Sumatera Barat',
            'riau'             => 'Riau',
            'kepulauan-riau'   => 'Kepulauan Riau (Kepri)',
            'jambi'            => 'Jambi',
            'bengkulu'         => 'Bengkulu',
            'sumatera-selatan' => 'Sumatera Selatan',
            'bangka-belitung'  => 'Kepulauan Bangka Belitung',
            'lampung'          => 'Lampung',
            'dki-jakarta'      => 'DKI Jakarta',
            'banten'           => 'Banten',
            'jawa-barat'       => 'Jawa Barat',
            'jawa-tengah'      => 'Jawa Tengah',
            'diy-yogyakarta'   => 'DI Yogyakarta',
            'jawa-timur'       => 'Jawa Timur',
            'bali'             => 'Bali',
            'ntb'              => 'Nusa Tenggara Barat (NTB)',
            'ntt'              => 'Nusa Tenggara Timur (NTT)',
            'kalimantan-barat' => 'Kalimantan Barat',
            'kalimantan-tengah'=> 'Kalimantan Tengah',
            'kalimantan-selatan'=> 'Kalimantan Selatan',
            'kalimantan-timur' => 'Kalimantan Timur',
            'kalimantan-utara' => 'Kalimantan Utara',
            'sulawesi-utara'   => 'Sulawesi Utara',
            'gorontalo'        => 'Gorontalo',
            'sulawesi-tengah'  => 'Sulawesi Tengah',
            'sulawesi-barat'   => 'Sulawesi Barat',
            'sulawesi-selatan' => 'Sulawesi Selatan',
            'sulawesi-tenggara'=> 'Sulawesi Tenggara',
            'maluku'           => 'Maluku',
            'maluku-utara'     => 'Maluku Utara',
            'papua-barat'      => 'Papua Barat',
            'papua'            => 'Papua',
            'papua-tengah'     => 'Papua Tengah',
            'papua-pegunungan' => 'Papua Pegunungan',
            'papua-selatan'    => 'Papua Selatan',
            'papua-barat-daya' => 'Papua Barat Daya',
        ];
    }

    private function ongkirRates(): array
    {
        $rates = \App\Models\ShippingRate::all();
        $formatted = [];
        foreach ($rates as $rate) {
            $formatted[$rate->province_code][$rate->courier] = [
                'cost' => $rate->cost,
                'estimation' => $rate->estimation,
            ];
        }
        return $formatted;
    }

    public function toggleWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id'
        ]);

        $user = Auth::user();
        $wishlist = \App\Models\Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
        } else {
            \App\Models\Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id
            ]);
            $status = 'added';
        }

        return response()->json([
            'status' => 'success',
            'wishlist_status' => $status,
            'count' => $user->wishlists()->count()
        ]);
    }

    public function getWishlist()
    {
        $wishlists = \App\Models\Wishlist::where('user_id', Auth::id())
            ->with(['product.category', 'product.brand'])
            ->latest()
            ->get();

        $data = $wishlists->map(function ($w) {
            if (!$w->product) return null;
            return [
                'id' => $w->id,
                'product_id' => $w->product_id,
                'name' => $w->product->name,
                'price' => $w->product->price,
                'formatted_price' => $w->product->price_formatted,
                'thumbnail_url' => $w->product->thumbnail_url,
                'category_name' => $w->product->category->name ?? '',
                'brand_name' => $w->product->brand->name ?? 'UMKM Lokal',
            ];
        })->filter()->values();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}