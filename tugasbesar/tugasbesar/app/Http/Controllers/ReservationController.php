<?php

namespace App\Http\Controllers;

use App\Models\Room;
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

    public function create()
    {
        try {
            $rooms = Room::where('status', 'tersedia')->get();
            return view('reservations.create', compact('rooms'));
        } catch (\Exception $e) {
            Log::error('Error loading create form:', [
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal memuat form tambah reservasi');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Reservation request data:', $request->all());

            $validated = $request->validate([
                'guest_name' => 'required|string|max:255',
                'room_id' => 'required|exists:rooms,id',
                'reservation_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'purpose' => 'required|string'
            ]);

            // Check if the room is available
            $room = Room::find($validated['room_id']);
            if ($room->status !== 'tersedia') {
                return back()
                    ->withInput()
                    ->with('error', 'Ruangan yang dipilih tidak tersedia');
            }

            // Check for conflicting reservations
            $conflictingReservation = Reservation::where('room_id', $validated['room_id'])
                ->where('reservation_date', $validated['reservation_date'])
                ->where(function ($query) use ($validated) {
                    $query->where(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['end_time'])
                          ->where('end_time', '>=', $validated['start_time']);
                    });
                })
                ->first();

            if ($conflictingReservation) {
                return back()
                    ->withInput()
                    ->with('error', 'Ruangan sudah direservasi untuk waktu tersebut');
            }

            // Create the reservation
            $reservation = Reservation::create($validated);
            Log::info('Reservation created:', ['id' => $reservation->id]);

            // Update room status
            $room->update(['status' => 'dipesan']);
            Log::info('Room status updated:', ['id' => $room->id]);

            return redirect()
                ->route('reservations.index')
                ->with('success', 'Reservasi berhasil dibuat');

        } catch (\Exception $e) {
            Log::error('Error creating reservation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat reservasi: ' . $e->getMessage());
        }
    }

    public function edit(Reservation $reservation)
    {
        try {
            $rooms = Room::all();
            return view('reservations.edit', compact('reservation', 'rooms'));
        } catch (\Exception $e) {
            Log::error('Error loading reservation edit form:', [
                'reservation_id' => $reservation->id,
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal memuat form edit reservasi');
        }
    }

    public function update(Request $request, Reservation $reservation)
    {
        try {
            Log::info('Reservation update request data:', [
                'reservation_id' => $reservation->id,
                'data' => $request->all()
            ]);

            $validated = $request->validate([
                'guest_name' => 'required|string|max:255',
                'room_id' => 'required|exists:rooms,id',
                'reservation_date' => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'purpose' => 'required|string'
            ]);

            // Check if the room is available
            $room = Room::find($validated['room_id']);
            if ($room->status !== 'tersedia' && $room->id !== $reservation->room_id) {
                return back()
                    ->withInput()
                    ->with('error', 'Ruangan yang dipilih tidak tersedia');
            }

            // Check for conflicting reservations
            $conflictingReservation = Reservation::where('room_id', $validated['room_id'])
                ->where('id', '!=', $reservation->id)
                ->where('reservation_date', $validated['reservation_date'])
                ->where(function ($query) use ($validated) {
                    $query->where(function ($q) use ($validated) {
                        $q->where('start_time', '<=', $validated['end_time'])
                          ->where('end_time', '>=', $validated['start_time']);
                    });
                })
                ->first();

            if ($conflictingReservation) {
                return back()
                    ->withInput()
                    ->with('error', 'Ruangan sudah direservasi untuk waktu tersebut');
            }

            // Update the reservation
            $reservation->update($validated);
            
            Log::info('Reservation updated successfully:', ['id' => $reservation->id]);

            return redirect()
                ->route('reservations.index')
                ->with('success', 'Reservasi berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error updating reservation:', [
                'reservation_id' => $reservation->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui reservasi: ' . $e->getMessage());
        }
    }

    public function destroy(Reservation $reservation)
    {
        try {
            Log::info('Attempting to delete reservation:', ['id' => $reservation->id]);

            $reservation->delete();
            
            Log::info('Reservation deleted successfully:', ['id' => $reservation->id]);

            return redirect()
                ->route('reservations.index')
                ->with('success', 'Reservasi berhasil dibatalkan');
        } catch (\Exception $e) {
            Log::error('Error deleting reservation:', [
                'reservation_id' => $reservation->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Gagal membatalkan reservasi');
        }
    }
}
