<?php

namespace App\Http\Controllers;

use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        // Fetch all shipping rates ordered by province name and courier
        $rates = ShippingRate::orderBy('province_name')->orderBy('courier')->get();
        return view('admin.shipping.index', compact('rates'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cost' => 'required|numeric|min:0',
            'estimation' => 'required|string|max:50',
        ]);

        $rate = ShippingRate::findOrFail($id);
        $rate->update([
            'cost' => $request->cost,
            'estimation' => $request->estimation,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estimasi dan biaya pengiriman berhasil diperbarui!',
            'data' => $rate
        ]);
    }
}
