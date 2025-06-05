<?php

namespace App\Http\Controllers;

use App\Models\Room;
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

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        try {
            Log::info('Room creation request data:', $request->all());

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'capacity' => 'required|integer|min:1',
                'status' => 'required|in:tersedia,dipesan,maintenance'
            ]);

            Log::info('Attempting to create room with data:', $validated);

            $room = Room::create($validated);
            
            Log::info('Room created successfully:', ['id' => $room->id]);

            return redirect()
                ->route('rooms.index')
                ->with('success', 'Ruangan berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error creating room:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan ruangan: ' . $e->getMessage());
        }
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

            return redirect()
                ->route('rooms.index')
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

            $room->delete();
            
            Log::info('Room deleted successfully:', ['id' => $room->id]);

            return back()->with('success', 'Ruangan berhasil dihapus');
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
