<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pakets",
     *     summary="Ambil semua data paket",
     *     tags={"Paket"},
     *     @OA\Response(response=200, description="Data paket berhasil diambil")
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_pengirim", "id_penerima", "id_laporan", "berat", "status_pengiriman", "jenis"},
     *             @OA\Property(property="id_pengirim", type="integer"),
     *             @OA\Property(property="id_penerima", type="integer"),
     *             @OA\Property(property="id_laporan", type="integer"),
     *             @OA\Property(property="berat", type="number", format="float"),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "proses", "dikirim", "diterima"}),
     *             @OA\Property(property="jenis", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Paket berhasil dibuat")
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Detail paket ditemukan"),
     *     @OA\Response(response=404, description="Paket tidak ditemukan")
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="id_pengirim", type="integer"),
     *             @OA\Property(property="id_penerima", type="integer"),
     *             @OA\Property(property="id_laporan", type="integer"),
     *             @OA\Property(property="berat", type="number", format="float"),
     *             @OA\Property(property="status_pengiriman", type="string", enum={"pending", "proses", "dikirim", "diterima"}),
     *             @OA\Property(property="jenis", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Paket berhasil diperbarui"),
     *     @OA\Response(response=404, description="Paket tidak ditemukan")
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Paket berhasil dihapus"),
     *     @OA\Response(response=404, description="Paket tidak ditemukan")
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
}