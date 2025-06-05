<?php

namespace App\Http\Controllers;

use App\Models\OperationalStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OperationalStatusController extends Controller
{
    public function index()
    {
        $statuses = OperationalStatus::orderBy('date', 'desc')->get();
        return view('operational_statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('operational_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'status' => 'required|in:open,closed',
        ]);

        OperationalStatus::create($request->all());

        return redirect()->route('operational-statuses.index')->with('success', 'Status operasional dibuat.');
    }

    public function show(string $id)
    {
        $status = OperationalStatus::findOrFail($id);
        return view('operational_statuses.show', compact('status'));
    }

    public function edit(string $id)
    {
        $status = OperationalStatus::findOrFail($id);
        return view('operational_statuses.edit', compact('status'));
    }

    public function update(Request $request, string $id)
    {
        $status = OperationalStatus::findOrFail($id);

        // Gunakan nilai lama jika input kosong
        $openTime = $request->input('open_time') ?: $status->open_time;
        $closeTime = $request->input('close_time') ?: $status->close_time;

        // Validasi manual
        $validator = \Validator::make([
            'date' => $request->input('date'),
            'open_time' => $openTime,
            'close_time' => $closeTime,
            'status' => $request->input('status'),
        ], [
            'date' => 'required|date',
            'status' => 'required|in:open,closed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update hanya data yang diubah atau fallback
        $status->update([
            'date' => $request->input('date'),
            'open_time' => $openTime,
            'close_time' => $closeTime,
            'status' => $request->input('status'),
        ]);

        return redirect()->route('operational-statuses.index')->with('success', 'Status diperbarui.');
    }

    public function realTimeStatus()
    {
        $now = Carbon::now();
        $today = OperationalStatus::where('date', $now->toDateString())->first();

        if (!$today) {
            return response()->json(['status' => 'closed', 'message' => 'Tidak ada jadwal untuk hari ini.']);
        }

        $open = Carbon::createFromTimeString($today->open_time);
        $close = Carbon::createFromTimeString($today->close_time);

        $isOpen = $now->between($open, $close) && $today->status === 'open';

        return response()->json([
            'status' => $isOpen ? 'open' : 'closed',
            'open_time' => $today->open_time,
            'close_time' => $today->close_time,
            'now' => $now->toTimeString(),
        ]);
    }

    public function destroy(string $id)
    {
        $status = \App\Models\OperationalStatus::findOrFail($id);
        $status->delete();
        return redirect()->route('operational-statuses.index')->with('success', 'Jadwal dihapus.');
    }
}
