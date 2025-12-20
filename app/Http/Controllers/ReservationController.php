<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RumahMakan;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        try {
            $reservations = Reservation::with('room')->get();
            $rooms = Room::all();
            return view('reservations.index', compact('reservations', 'rooms'));
        } catch (\Exception $e) {
            Log::error('Error fetching reservations:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal mengambil data reservasi');
        }
    }

    public function create(Request $request)
    {
        $rumahMakanId = $request->query('rumah_makan_id');
        $rumahMakan = RumahMakan::with('rooms')->findOrFail($rumahMakanId);
        $rooms = $rumahMakan->rooms;
        return view('reservations.create', compact('rumahMakan', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string'
        ]);

        // Check if room is available
        $room = Room::findOrFail($request->room_id);
        if ($room->status !== 'tersedia') {
            return back()->withInput()->with('error', 'Ruangan tidak tersedia untuk saat ini');
        }

        // Check for conflicting reservations
        $conflicting = Reservation::where('room_id', $request->room_id)
            ->where('reservation_date', $request->reservation_date)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($conflicting) {
            return back()->withInput()->with('error', 'Waktu reservasi bertabrakan dengan reservasi lain');
        }

        $validated['status'] = 'pending';
        Reservation::create($validated);

        return redirect()->route('rumah-makan.show', $room->rumah_makan_id)
            ->with('success', 'Reservasi berhasil dibuat');
    }

    public function edit(Reservation $reservation)
    {
        $rumahMakan = $reservation->room->rumahMakan;
        $rooms = $rumahMakan->rooms;
        return view('reservations.edit', compact('reservation', 'rumahMakan', 'rooms'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string',
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        if ($request->status === 'confirmed') {
            $reservation->room->update(['status' => 'dipesan']);
        } elseif ($request->status === 'cancelled' && $reservation->status === 'confirmed') {
            $reservation->room->update(['status' => 'tersedia']);
        }

        $reservation->update($validated);

        return redirect()->route('rumah-makan.show', $reservation->room->rumah_makan_id)
            ->with('success', 'Reservasi berhasil diperbarui');
    }

    public function destroy(Reservation $reservation)
    {
        $rumahMakanId = $reservation->room->rumah_makan_id;
        
        if ($reservation->status === 'confirmed') {
            $reservation->room->update(['status' => 'tersedia']);
        }
        
        $reservation->delete();

        return redirect()->route('rumah-makan.show', $rumahMakanId)
            ->with('success', 'Reservasi berhasil dihapus');
    }
}
