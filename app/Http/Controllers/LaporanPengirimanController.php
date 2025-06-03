<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPengiriman;
use Illuminate\Support\Facades\Validator;

class LaporanPengirimanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/laporans",
     *     summary="Ambil semua laporan pengiriman",
     *     tags={"LaporanPengiriman"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data laporan berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Laporan pengiriman retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id_laporan", type="integer", example=1),
     *                 @OA\Property(property="wilayah", type="string", example="Jakarta"),
     *                 @OA\Property(property="jumlah_paket", type="integer", example=10),
     *                 @OA\Property(property="status_pengiriman", type="string", example="pending"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             ))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
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
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"wilayah", "jumlah_paket", "status_pengiriman"},
     *             @OA\Property(property="wilayah", type="string", example="Jakarta Selatan"),
     *             @OA\Property(property="jumlah_paket", type="integer", example=5),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "dalam perjalanan", "selesai"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Laporan berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Laporan pengiriman created successfully."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id_laporan", type="integer", example=1),
     *                 @OA\Property(property="wilayah", type="string", example="Jakarta Selatan"),
     *                 @OA\Property(property="jumlah_paket", type="integer", example=5),
     *                 @OA\Property(property="status_pengiriman", type="string", example="pending"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
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
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail laporan ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Laporan pengiriman retrieved successfully."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id_laporan", type="integer", example=1),
     *                 @OA\Property(property="wilayah", type="string", example="Jakarta"),
     *                 @OA\Property(property="jumlah_paket", type="integer", example=10),
     *                 @OA\Property(property="status_pengiriman", type="string", example="pending"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthenticated")
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
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="wilayah", type="string", example="Bandung"),
     *             @OA\Property(property="jumlah_paket", type="integer", example=15),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "dalam perjalanan", "selesai"}, example="dalam perjalanan")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Laporan berhasil diperbarui"),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
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
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Laporan berhasil dihapus"),
     *     @OA\Response(response=404, description="Laporan tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthenticated")
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


    /**
     * @OA\Get(
     *     path="/api/laporans/filter/status",
     *     summary="Filter laporan berdasarkan status pengiriman",
     *     tags={"LaporanPengiriman"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="status_pengiriman",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"pending", "dalam perjalanan", "selesai"})
     *     ),
     *     @OA\Response(response=200, description="Data laporan yang difilter berhasil diambil"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function filterByStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status_pengiriman' => 'required|in:pending,dalam perjalanan,selesai'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $laporans = LaporanPengiriman::where('status_pengiriman', $request->status_pengiriman)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Filtered laporan retrieved successfully.',
            'data' => $laporans
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/laporans/filter/wilayah",
     *     summary="Filter laporan berdasarkan wilayah",
     *     tags={"LaporanPengiriman"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="wilayah",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Data laporan yang difilter berhasil diambil"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function filterByWilayah(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wilayah' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $laporans = LaporanPengiriman::where('wilayah', $request->wilayah)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Filtered laporan by wilayah retrieved successfully.',
            'data' => $laporans
        ], 200);
    }
}
