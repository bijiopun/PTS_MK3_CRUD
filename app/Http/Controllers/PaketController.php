<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pakets",
     *     summary="Ambil semua data paket",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Data paket berhasil diambil",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Paket retrieved successfully."),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id_paket", type="integer", example=1),
     *                 @OA\Property(property="id_pengirim", type="integer", example=1),
     *                 @OA\Property(property="id_penerima", type="integer", example=1),
     *                 @OA\Property(property="id_laporan", type="integer", example=1),
     *                 @OA\Property(property="berat", type="number", format="float", example=2.5),
     *                 @OA\Property(property="status_pengiriman", type="string", example="pending"),
     *                 @OA\Property(property="jenis", type="string", example="Dokumen"),
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
        $pakets = Paket::all();

        return response()->json([
            'status' => 200,
            'message' => 'Paket retrieved successfully.',
            'data' => $pakets
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pakets",
     *     summary="Buat paket baru",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_pengirim", "id_penerima", "id_laporan", "berat", "status_pengiriman", "jenis"},
     *             @OA\Property(property="id_pengirim", type="integer", example=1),
     *             @OA\Property(property="id_penerima", type="integer", example=1),
     *             @OA\Property(property="id_laporan", type="integer", example=1),
     *             @OA\Property(property="berat", type="number", format="float", example=2.5),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "proses", "dikirim", "diterima"}, example="pending"),
     *             @OA\Property(property="jenis", type="string", example="Dokumen")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Paket berhasil dibuat"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/pakets/{id}",
     *     summary="Ambil detail paket",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Detail paket ditemukan"),
     *     @OA\Response(response=404, description="Paket tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/pakets/{id}",
     *     summary="Update data paket",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="id_pengirim", type="integer", example=1),
     *             @OA\Property(property="id_penerima", type="integer", example=1),
     *             @OA\Property(property="id_laporan", type="integer", example=1),
     *             @OA\Property(property="berat", type="number", format="float", example=3.0),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "proses", "dikirim", "diterima"}, example="proses"),
     *             @OA\Property(property="jenis", type="string", example="Elektronik")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Paket berhasil diperbarui"),
     *     @OA\Response(response=404, description="Paket tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/pakets/{id}",
     *     summary="Hapus paket",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Paket berhasil dihapus"),
     *     @OA\Response(response=404, description="Paket tidak ditemukan"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/paket/filter/status",
     *     summary="Filter paket berdasarkan status",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", enum={"pending", "proses", "dikirim", "diterima"})
     *     ),
     *     @OA\Response(response=200, description="Data paket yang difilter berhasil diambil"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function filterByStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,proses,dikirim,diterima'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $pakets = Paket::where('status_pengiriman', $request->status)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Filtered paket retrieved successfully.',
            'data' => $pakets
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/paket/filter/jenis",
     *     summary="Filter paket berdasarkan jenis",
     *     tags={"Paket"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="jenis",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Data paket yang difilter berhasil diambil"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function filterByJenis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $pakets = Paket::where('jenis', $request->jenis)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Filtered paket by jenis retrieved successfully.',
            'data' => $pakets
        ], 200);
    }
}
