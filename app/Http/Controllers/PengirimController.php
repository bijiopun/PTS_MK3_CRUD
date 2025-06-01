<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;

class PengirimanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pengirims",  // sesuaikan ke /api/pengirimans kalau endpointnya pengiriman
     *     summary="Ambil semua data pengiriman",
     *     tags={"Pengiriman"},
     *     @OA\Response(response=200, description="Data pengiriman berhasil diambil")
     * )
     */
    public function index()
    {
        $pengirimans = Pengiriman::all();

        return response()->json([
            'status' => 200,
            'message' => 'Pengiriman retrieved successfully.',
            'data' => $pengirimans
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pengirimans",
     *     summary="Buat pengiriman baru",
     *     tags={"Pengiriman"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"pengirim_id", "penerima_id", "paket_id", "status", "tanggal_kirim"},
     *             @OA\Property(property="pengirim_id", type="integer"),
     *             @OA\Property(property="penerima_id", type="integer"),
     *             @OA\Property(property="paket_id", type="integer"),
     *             @OA\Property(property="status", type="string", maxLength=50),
     *             @OA\Property(property="tanggal_kirim", type="string", format="date"),
     *             @OA\Property(property="tanggal_terima", type="string", format="date", nullable=true),
     *             @OA\Property(property="keterangan", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pengiriman berhasil dibuat")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengirim_id' => 'required|integer|exists:pengirims,id',
            'penerima_id' => 'required|integer|exists:penerimas,id',
            'paket_id' => 'required|integer|exists:pakets,id',
            'status' => 'required|string|max:50',
            'tanggal_kirim' => 'required|date',
            'tanggal_terima' => 'nullable|date|after_or_equal:tanggal_kirim',
            'keterangan' => 'nullable|string'
        ]);

        $pengiriman = Pengiriman::create($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Pengiriman created successfully.',
            'data' => $pengiriman
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/pengirimans/{id}",
     *     summary="Ambil detail pengiriman",
     *     tags={"Pengiriman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pengiriman ditemukan"),
     *     @OA\Response(response=404, description="Pengiriman tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $pengiriman = Pengiriman::find($id);

        if (!$pengiriman) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengiriman not found.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Pengiriman retrieved successfully.',
            'data' => $pengiriman
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/pengirimans/{id}",
     *     summary="Update data pengiriman",
     *     tags={"Pengiriman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="pengirim_id", type="integer"),
     *             @OA\Property(property="penerima_id", type="integer"),
     *             @OA\Property(property="paket_id", type="integer"),
     *             @OA\Property(property="status", type="string", maxLength=50),
     *             @OA\Property(property="tanggal_kirim", type="string", format="date"),
     *             @OA\Property(property="tanggal_terima", type="string", format="date", nullable=true),
     *             @OA\Property(property="keterangan", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Pengiriman berhasil diperbarui"),
     *     @OA\Response(response=404, description="Pengiriman tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $pengiriman = Pengiriman::find($id);

        if (!$pengiriman) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengiriman not found.',
                'data' => null
            ], 404);
        }

        $request->validate([
            'pengirim_id' => 'sometimes|integer|exists:pengirims,id',
            'penerima_id' => 'sometimes|integer|exists:penerimas,id',
            'paket_id' => 'sometimes|integer|exists:pakets,id',
            'status' => 'sometimes|string|max:50',
            'tanggal_kirim' => 'sometimes|date',
            'tanggal_terima' => 'nullable|date|after_or_equal:tanggal_kirim',
            'keterangan' => 'nullable|string'
        ]);

        $pengiriman->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Pengiriman updated successfully.',
            'data' => $pengiriman
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/pengirimans/{id}",
     *     summary="Hapus pengiriman",
     *     tags={"Pengiriman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Pengiriman berhasil dihapus"),
     *     @OA\Response(response=404, description="Pengiriman tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $pengiriman = Pengiriman::find($id);

        if (!$pengiriman) {
            return response()->json([
                'status' => 404,
                'message' => 'Pengiriman not found.',
                'data' => null
            ], 404);
        }

        $pengiriman->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Pengiriman deleted successfully.',
            'data' => null
        ], 200);
    }
}
