<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengirim;

class PengirimController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pengirims",
     *     summary="Ambil semua data pengirim",
     *     tags={"Pengirim"},
     *     @OA\Response(response=200, description="Data pengirim berhasil diambil")
     * )
     */
    public function index()
    {
        $pengirims = Pengirim::all();

        return response()->json([
            'status' => 200,
            'message' => 'Pengirim retrieved successfully.',
            'data' => $pengirims
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pengirims",
     *     summary="Buat pengirim baru",
     *     tags={"Pengirim"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "alamat", "nomor_telepon"},
     *             @OA\Property(property="nama", type="string", maxLength=255),
     *             @OA\Property(property="alamat", type="string"),
     *             @OA\Property(property="nomor_telepon", type="string", maxLength=15)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pengirim berhasil dibuat")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/pengirims/{id}",
     *     summary="Ambil detail pengirim",
     *     tags={"Pengirim"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pengirim ditemukan"),
     *     @OA\Response(response=404, description="Pengirim tidak ditemukan")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/pengirims/{id}",
     *     summary="Update data pengirim",
     *     tags={"Pengirim"},
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
     *     @OA\Response(response=200, description="Pengirim berhasil diperbarui"),
     *     @OA\Response(response=404, description="Pengirim tidak ditemukan")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/pengirims/{id}",
     *     summary="Hapus pengirim",
     *     tags={"Pengirim"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pengirim berhasil dihapus"),
     *     @OA\Response(response=404, description="Pengirim tidak ditemukan")
     * )
     */
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