<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Brand;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        return view('admin.produk.index');
    }

    public function stok(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name', 'like', '%' . $s . '%')
                  ->orWhere('slug', 'like', '%' . $s . '%')
                  ->orWhere('sku', 'like', '%' . $s . '%');
        }

        $produks = $query->orderBy('stock', 'asc')->paginate($request->per_page ?? 10);

        return view('admin.stok', compact('produks'));
    }

    public function create()
    {
        return view('admin.produk.create', [
            'brands'   => Brand::orderBy('name')->get(),
            'kategoris' => Kategori::orderBy('name')->get(),
        ]);
    }

    public function edit($id)
    {
        return view('admin.produk.edit', [
            'produk'   => Produk::findOrFail($id),
            'brands'   => Brand::orderBy('name')->get(),
            'kategoris' => Kategori::orderBy('name')->get(),
        ]);
    }

    public function list(Request $request)
    {
        $query = Produk::with(['brand', 'kategori']);

        // Fix pencarian supaya tidak tabrakan
        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', $s)
                  ->orWhere('slug', 'like', $s);
            });
        }

        $items = $query->orderBy('name')->get();
        $items->makeHidden(['terjual', 'rating']);

        return response()->json($items);
    }

    public function options()
    {
        return response()->json([
            'brands'    => Brand::orderBy('name')->get(['id', 'name']),
            'kategoris' => Kategori::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:150',
            'description'  => 'nullable|string',
            'brand_id'     => 'nullable|exists:brands,id',
            'kategori_id'  => 'required|exists:kategoris,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'sizes'        => 'required|array|min:1',
            'sizes.*'      => 'string|distinct',
            'colors'       => 'required|array|min:1',
            'colors.*'     => 'string|distinct',
            'image'        => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $path = $request->file('image')->store('produk', 'public');

        $produk = Produk::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'brand_id'    => $request->brand_id,
            'kategori_id' => $request->kategori_id,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'sizes'       => $request->sizes,
            'colors'      => $request->colors,
            'image'       => $path,
        ]);

        return response()->json([
            'message'  => "Produk \"{$produk->name}\" berhasil ditambahkan",
            'redirect' => route('admin.produk'),
        ], 201);
    }

    public function detailView($id)
    {
        $produk = Produk::with(['brand', 'kategori'])->findOrFail($id);
        return view('admin.produk.detail', compact('produk'));
    }

    public function show(Produk $produk)
    {
        $produk->load(['brand', 'kategori']);
        
        $data = $produk->toArray();
        $data['images'] = [['url' => $produk->image_url]];

        return response()->json($data);
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'name'         => 'required|string|max:150',
            'description'  => 'nullable|string',
            'brand_id'     => 'nullable|exists:brands,id',
            'kategori_id'  => 'required|exists:kategoris,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'sizes'        => 'required|array|min:1',
            'sizes.*'      => 'string|distinct',
            'colors'       => 'required|array|min:1',
            'colors.*'     => 'string|distinct',
            'image'        => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = [
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'brand_id'    => $request->brand_id,
            'kategori_id' => $request->kategori_id,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'sizes'       => $request->sizes,
            'colors'      => $request->colors,
        ];

        if ($request->hasFile('image')) {
            if ($produk->image) Storage::delete('public/' . $produk->image);
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        $produk->update($data);

        return response()->json([
            'message' => "Produk \"{$produk->name}\" berhasil diperbarui",
        ]);
    }

    public function destroy(Produk $produk)
    {
        $name = $produk->name;
        if ($produk->image) Storage::delete('public/' . $produk->image);
        $produk->delete();

        return response()->json([
            'message' => "Produk \"{$name}\" berhasil dihapus",
        ]);
    }
}