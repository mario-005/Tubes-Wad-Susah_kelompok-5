<?php

namespace App\Http\Controllers;

use App\Models\RumahMakan;
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

    public function create(Request $request)
    {
        $rumahMakanId = $request->query('rumah_makan_id');
        $rumahMakan = RumahMakan::findOrFail($rumahMakanId);
        return view('operational_statuses.create', compact('rumahMakan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'status' => 'required|in:open,closed',
            'rumah_makan_id' => 'required|exists:rumah_makans,id'
        ]);

        OperationalStatus::create($validated);

        return redirect()->route('rumah-makan.show', $request->rumah_makan_id)
            ->with('success', 'Status operasional berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $status = OperationalStatus::findOrFail($id);
        return view('operational_statuses.show', compact('status'));
    }

    public function edit(OperationalStatus $operationalStatus)
    {
        return view('operational_statuses.edit', compact('operationalStatus'));
    }

    public function update(Request $request, OperationalStatus $operationalStatus)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'status' => 'required|in:open,closed'
        ]);

        $operationalStatus->update($validated);

        return redirect()->route('rumah-makan.show', $operationalStatus->rumah_makan_id)
            ->with('success', 'Status operasional berhasil diperbarui');
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

    public function destroy(OperationalStatus $operationalStatus)
    {
        $rumahMakanId = $operationalStatus->rumah_makan_id;
        $operationalStatus->delete();

        return redirect()->route('rumah-makan.show', $rumahMakanId)
            ->with('success', 'Status operasional berhasil dihapus');
    }
}
