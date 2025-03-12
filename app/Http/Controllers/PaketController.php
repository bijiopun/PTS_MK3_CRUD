<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();

        return response()->json([
            'status' => 200,
            'message' => 'Paket retrieved successfully.',
            'data' => $pakets
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengirim' => 'required|exists:pengirim,id_pengirim',
            'id_penerima' => 'required|exists:penerima,id_penerima',
            'id_laporan' => 'required|exists:laporan_pengiriman,id_laporan',
            'berat' => 'required|numeric',
            'status_pengiriman' => 'required|in:pending,proses,dikirim,diterima',
            'jenis' => 'required|string|max:255'
        ]);

        $paket = Paket::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Paket created successfully.',
            'data' => $paket
        ], 200);
    }

    public function show($id)
    {
        $paket = Paket::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 404,
                'message' => 'Paket not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Paket retrieved successfully.',
            'data' => $paket
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 404,
                'message' => 'Paket not found.',
                'data' => null
            ], 404);
        }

        $request->validate([
            'id_pengirim' => 'sometimes|exists:pengirim,id_pengirim',
            'id_penerima' => 'sometimes|exists:penerima,id_penerima',
            'id_laporan' => 'sometimes|exists:laporan_pengiriman,id_laporan',
            'berat' => 'sometimes|numeric',
            'status_pengiriman' => 'sometimes|in:pending,proses,dikirim,diterima',
            'jenis' => 'sometimes|string|max:255'
        ]);

        $paket->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Paket updated successfully.',
            'data' => $paket
        ], 200);
    }

    public function destroy($id)
    {
        $paket = Paket::find($id);

        if (!$paket) {
            return response()->json([
                'status' => 404,
                'message' => 'Paket not found.',
                'data' => null
            ], 404);
        }

        $paket->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Paket deleted successfully.',
            'data' => null
        ], 200);
    }
}
