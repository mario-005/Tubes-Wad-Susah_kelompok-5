<?php

namespace App\Http\Controllers;

use App\Models\RumahMakan;
use Illuminate\Http\Request;

class RumahMakanController extends Controller
{
    public function index()
    {
        $rumahMakans = RumahMakan::with(['menus', 'rooms', 'ulasans'])->get();
        return view('rumah_makan.index', compact('rumahMakans'));
    }

    public function create()
    {
        return view('rumah_makan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'jam_buka' => 'nullable|date_format:H:i',
            'jam_tutup' => 'nullable|date_format:H:i',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200', 
        ]);

        if ($request->hasFile('foto')) {
            try {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('fotos', $filename, 'public');
                $validated['foto'] = $path;
            } catch (\Exception $e) {
                // Jika gagal upload, lewati foto (untuk Vercel dan environment tanpa persistent storage)
                $validated['foto'] = null;
            }
        }

        RumahMakan::create($validated);

        return redirect()->route('dashboard')->with('success', 'Data berhasil ditambahkan');
    }


    public function show($id)
    {
        $rumahMakan = RumahMakan::with(['menus', 'rooms', 'rooms.reservations', 'operationalStatuses', 'ulasans'])
            ->findOrFail($id);
        return view('rumah_makan.show', compact('rumahMakan'));
    }

    public function edit($id)
    {
        $rumahMakan = RumahMakan::findOrFail($id);
        return view('rumah_makan.edit', compact('rumahMakan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'jam_buka' => 'nullable|date_format:H:i',
            'jam_tutup' => 'nullable|date_format:H:i',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:51200',
        ]);

        $rumahMakan = RumahMakan::findOrFail($id);
        
        if ($request->hasFile('foto')) {
            try {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('fotos', $filename, 'public');
                $validated['foto'] = $path;
            } catch (\Exception $e) {
                // Jika gagal upload, lewati foto (untuk Vercel dan environment tanpa persistent storage)
                unset($validated['foto']);
            }
        }

        $rumahMakan->update($validated);

        return redirect()->route('dashboard')->with('success', 'Data rumah makan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $rumahMakan = RumahMakan::findOrFail($id);
        $rumahMakan->delete();

        return redirect()->route('dashboard')->with('success', 'Rumah makan berhasil dihapus!');
    }
}
