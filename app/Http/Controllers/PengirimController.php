<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengirim;

class PengirimController extends Controller
{
    public function index()
    {
        $pengirims = Pengirim::all();

        return response()->json([
            'status' => 200,
            'message' => 'Pengirim retrieved successfully.',
            'data' => $pengirims
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:15'
        ]);

        $pengirim = Pengirim::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Pengirim created successfully.',
            'data' => $pengirim
        ], 200);
    }

    public function show($id)
    {
        $pengirim = Pengirim::find($id);

        if (!$pengirim) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengirim not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Pengirim retrieved successfully.',
            'data' => $pengirim
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $pengirim = Pengirim::find($id);

        if (!$pengirim) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengirim not found.',
                'data' => null
            ], 404);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'nomor_telepon' => 'sometimes|string|max:15'
        ]);

        $pengirim->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Pengirim updated successfully.',
            'data' => $pengirim
        ], 200);
    }

    public function destroy($id)
    {
        $pengirim = Pengirim::find($id);

        if (!$pengirim) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengirim not found.',
                'data' => null
            ], 404);
        }

        $pengirim->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pengirim deleted successfully.',
            'data' => null
        ], 200);
    }
}
