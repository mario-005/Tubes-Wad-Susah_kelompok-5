<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RumahMakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index()
    {
        try {
            $rooms = Room::all();
            return view('rooms.index', compact('rooms'));
        } catch (\Exception $e) {
            Log::error('Error fetching rooms:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal mengambil data ruangan');
        }
    }

    public function create(Request $request)
    {
        $rumahMakanId = $request->query('rumah_makan_id');
        $rumahMakan = RumahMakan::findOrFail($rumahMakanId);
        return view('rooms.create', compact('rumahMakan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,dipesan,maintenance',
            'rumah_makan_id' => 'required|exists:rumah_makans,id'
        ]);

        Room::create($validated);

        return redirect()->route('rumah-makan.show', $request->rumah_makan_id)
            ->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function edit(Room $room)
    {
        try {
            return view('rooms.edit', compact('room'));
        } catch (\Exception $e) {
            Log::error('Error loading room edit form:', [
                'room_id' => $room->id,
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal memuat form edit');
        }
    }

    public function update(Request $request, Room $room)
    {
        try {
            Log::info('Room update request data:', [
                'room_id' => $room->id,
                'data' => $request->all()
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'capacity' => 'required|integer|min:1',
                'status' => 'required|in:tersedia,dipesan,maintenance'
            ]);

            Log::info('Attempting to update room with data:', [
                'room_id' => $room->id,
                'data' => $validated
            ]);

            $room->update($validated);
            
            Log::info('Room updated successfully:', ['id' => $room->id]);

            return redirect()->route('rumah-makan.show', $room->rumah_makan_id)
                ->with('success', 'Ruangan berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating room:', [
                'room_id' => $room->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui ruangan: ' . $e->getMessage());
        }
    }

    public function destroy(Room $room)
    {
        try {
            Log::info('Attempting to delete room:', ['id' => $room->id]);

            $rumahMakanId = $room->rumah_makan_id;
            $room->delete();
            
            Log::info('Room deleted successfully:', ['id' => $room->id]);

            return redirect()->route('rumah-makan.show', $rumahMakanId)
                ->with('success', 'Ruangan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting room:', [
                'room_id' => $room->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Gagal menghapus ruangan');
        }
    }
}
