<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function list(Request $request)
    {
        $query = Kategori::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $kategori = Kategori::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => "Kategori \"{$kategori->name}\" berhasil ditambahkan",
        ], 201);
    }

    public function show(Kategori $kategori)
    {
        return response()->json($kategori);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $kategori->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => "Kategori \"{$kategori->name}\" berhasil diperbarui",
        ]);
    }

    public function destroy(Kategori $kategori)
    {
        $name = $kategori->name;
        $kategori->delete();

        return response()->json([
            'message' => "Kategori \"{$name}\" berhasil dihapus",
        ]);
    }
}
