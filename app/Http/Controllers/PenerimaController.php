<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerima;

class PenerimaController extends Controller
{
    public function index()
    {
        $penerimas = Penerima::all();

        return response()->json([
            'status' => 200,
            'message' => 'Penerima retrieved successfully.',
            'data' => $penerimas
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:15'
        ]);

        $penerima = Penerima::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Penerima created successfully.',
            'data' => $penerima
        ], 200);
    }

    public function show($id)
    {
        $penerima = Penerima::find($id);

        if (!$penerima) {
            return response()->json([
                'status' => 404,
                'message' => 'Penerima not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Penerima retrieved successfully.',
            'data' => $penerima
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $penerima = Penerima::find($id);

        if (!$penerima) {
            return response()->json([
                'status' => 404,
                'message' => 'Penerima not found.',
                'data' => null
            ], 404);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'nomor_telepon' => 'sometimes|string|max:15'
        ]);

        $penerima->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Penerima updated successfully.',
            'data' => $penerima
        ], 200);
    }

    public function destroy($id)
    {
        $penerima = Penerima::find($id);

        if (!$penerima) {
            return response()->json([
                'status' => 404,
                'message' => 'Penerima not found.',
                'data' => null
            ], 404);
        }

        $penerima->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Penerima deleted successfully.',
            'data' => null
        ], 200);
    }
}
