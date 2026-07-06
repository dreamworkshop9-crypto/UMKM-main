<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.index');
    }

    public function list(Request $request)
    {
        $query = Brand::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        $brands = $query->orderBy('name')->get()->map(function ($brand) {
            return [
                'id'        => $brand->id,
                'name'      => $brand->name,
                'slug'      => $brand->slug,
                'image_url' => $brand->image ? Storage::url($brand->image) : null,
            ];
        });

        return response()->json($brands);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
        ]);

        Brand::create([
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'is_active' => 1,
        ]);

        return response()->json([
            'message' => 'Merek berhasil ditambahkan',
        ], 201);
    }

    public function show(Brand $brand)
    {
        return response()->json([
            'id'        => $brand->id,
            'name'      => $brand->name,
            'slug'      => $brand->slug,
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
        ]);

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'message' => 'Merek berhasil diperbarui',
        ]);
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        $brand->delete();

        return response()->json([
            'message' => 'Merek berhasil dihapus',
        ]);
    }
}