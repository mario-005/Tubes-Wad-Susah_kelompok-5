<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RumahMakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RumahMakanApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rumahMakans = RumahMakan::with(['menus', 'rooms', 'operationalStatuses', 'ulasans'])->get();
        return response()->json($rumahMakans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable',
            'foto' => 'nullable|image|max:51200',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if ($request->hasFile('foto')) {
            try {
                $path = $request->file('foto')->store('public/fotos');
                $data['foto'] = str_replace('public/', '', $path);
            } catch (\Exception $e) {
                // File upload gagal, lewati foto
                $data['foto'] = null;
            }
        }
        $rumahMakan = RumahMakan::create($data);
        return response()->json($rumahMakan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rumahMakan = RumahMakan::with(['menus', 'rooms', 'operationalStatuses', 'ulasans'])->find($id);
        if (!$rumahMakan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($rumahMakan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rumahMakan = RumahMakan::find($id);
        if (!$rumahMakan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'kategori' => 'sometimes|required|string|max:255',
            'jam_buka' => 'nullable',
            'jam_tutup' => 'nullable',
            'foto' => 'nullable|image|max:51200',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if ($request->hasFile('foto')) {
            try {
                $path = $request->file('foto')->store('public/fotos');
                $data['foto'] = str_replace('public/', '', $path);
            } catch (\Exception $e) {
                // File upload gagal, lewati foto
                unset($data['foto']);
            }
        }
        $rumahMakan->update($data);
        return response()->json($rumahMakan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rumahMakan = RumahMakan::find($id);
        if (!$rumahMakan) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $rumahMakan->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
