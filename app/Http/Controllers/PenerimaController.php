<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerima;
use Illuminate\Support\Facades\Validator;

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

    /**
     * @OA\Get(
     *     path="/api/penerimas/filter/nama",
     *     summary="Filter penerima berdasarkan nama (partial match)",
     *     tags={"Penerima"},
     *     @OA\Parameter(
     *         name="nama",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Data penerima yang difilter berhasil diambil")
     * )
     */
    public function filterByNama(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $penerimas = Penerima::where('nama', 'like', '%' . $request->nama . '%')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Filtered penerima by nama retrieved successfully.',
            'data' => $penerimas
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/penerimas/filter/nomor_telepon",
     *     summary="Filter penerima berdasarkan nomor telepon (exact match)",
     *     tags={"Penerima"},
     *     @OA\Parameter(
     *         name="nomor_telepon",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", maxLength=15)
     *     ),
     *     @OA\Response(response=200, description="Data penerima yang difilter berhasil diambil")
     * )
     */
    public function filterByNomorTelepon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_telepon' => 'required|string|max:15'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $penerimas = Penerima::where('nomor_telepon', $request->nomor_telepon)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Filtered penerima by nomor telepon retrieved successfully.',
            'data' => $penerimas
        ], 200);
    }
}
