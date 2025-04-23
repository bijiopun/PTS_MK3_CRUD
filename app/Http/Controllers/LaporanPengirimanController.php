<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPengiriman;

class LaporanPengirimanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/laporans",
     *     summary="Ambil semua laporan pengiriman",
     *     tags={"LaporanPengiriman"},
     *     @OA\Response(
     *         response=200,
     *         description="Data laporan berhasil diambil"
     *     )
     * )
     */
    public function index()
    {
        $laporans = LaporanPengiriman::all();

        return response()->json([
            'status' => 200,
            'message' => 'Laporan pengiriman retrieved successfully.',
            'data' => $laporans
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/laporans",
     *     summary="Buat laporan pengiriman baru",
     *     tags={"LaporanPengiriman"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"wilayah", "jumlah_paket", "status_pengiriman"},
     *             @OA\Property(property="wilayah", type="string"),
     *             @OA\Property(property="jumlah_paket", type="integer"),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "dalam perjalanan", "selesai"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Laporan berhasil dibuat")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/laporans/{id}",
     *     summary="Ambil detail laporan pengiriman",
     *     tags={"LaporanPengiriman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Detail laporan ditemukan"),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/laporans/{id}",
     *     summary="Update laporan pengiriman",
     *     tags={"LaporanPengiriman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="wilayah", type="string"),
     *             @OA\Property(property="jumlah_paket", type="integer"),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "dalam perjalanan", "selesai"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Laporan berhasil diperbarui"),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/laporans/{id}",
     *     summary="Hapus laporan pengiriman",
     *     tags={"LaporanPengiriman"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Laporan berhasil dihapus"),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan")
     * )
     */
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
