<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerima;

class PenerimaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/penerimas",
     *     summary="Ambil semua data penerima",
     *     tags={"Penerima"},
     *     @OA\Response(response=200, description="Data penerima berhasil diambil")
     * )
     */
    public function index()
    {
        $penerimas = Penerima::all();

        return response()->json([
            'status' => 200,
            'message' => 'Penerima retrieved successfully.',
            'data' => $penerimas
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/penerimas",
     *     summary="Buat penerima baru",
     *     tags={"Penerima"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "alamat", "nomor_telepon"},
     *             @OA\Property(property="nama", type="string", maxLength=255),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="nomor_telepon", type="string", maxLength=15)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Penerima berhasil dibuat")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/penerimas/{id}",
     *     summary="Ambil detail penerima",
     *     tags={"Penerima"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Penerima ditemukan"),
     *     @OA\Response(response=404, description="Penerima tidak ditemukan")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/penerimas/{id}",
     *     summary="Update data penerima",
     *     tags={"Penerima"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nama", type="string", maxLength=255),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="nomor_telepon", type="string", maxLength=15)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Penerima berhasil diperbarui"),
     *     @OA\Response(response=404, description="Penerima tidak ditemukan")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/penerimas/{id}",
     *     summary="Hapus penerima",
     *     tags={"Penerima"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Penerima berhasil dihapus"),
     *     @OA\Response(response=404, description="Penerima tidak ditemukan")
     * )
     */
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
