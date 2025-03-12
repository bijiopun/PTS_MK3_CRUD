<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPengiriman;

class LaporanPengirimanController extends Controller
{
    public function index()
    {
        $laporans = LaporanPengiriman::all();

        return response()->json([
            'status' => 200,
            'message' => 'Laporan pengiriman retrieved successfully.',
            'data' => $laporans
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'wilayah' => 'required|string|max:255',
            'jumlah_paket' => 'required|integer',
            'status_pengiriman' => 'required|in:pending,dalam perjalanan,selesai'
        ]);

        $laporan = LaporanPengiriman::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Laporan pengiriman created successfully.',
            'data' => $laporan
        ], 200);
    }

    public function show($id)
    {
        $laporan = LaporanPengiriman::find($id);

        if (!$laporan) {
            return response()->json([
                'status' => 404,
                'message' => 'Laporan pengiriman not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Laporan pengiriman retrieved successfully.',
            'data' => $laporan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanPengiriman::find($id);

        if (!$laporan) {
            return response()->json([
                'status' => 404,
                'message' => 'Laporan pengiriman not found.',
                'data' => null
            ], 404);
        }

        $request->validate([
            'wilayah' => 'sometimes|string|max:255',
            'jumlah_paket' => 'sometimes|integer',
            'status_pengiriman' => 'sometimes|in:pending,dalam perjalanan,selesai'
        ]);

        $laporan->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Laporan pengiriman updated successfully.',
            'data' => $laporan
        ], 200);
    }

    public function destroy($id)
    {
        $laporan = LaporanPengiriman::find($id);

        if (!$laporan) {
            return response()->json([
                'status' => 404,
                'message' => 'Laporan pengiriman not found.',
                'data' => null
            ], 404);
        }

        $laporan->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Laporan pengiriman deleted successfully.',
            'data' => null
        ], 200);
    }
}
