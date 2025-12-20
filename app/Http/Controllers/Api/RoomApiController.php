<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with(['rumahMakan', 'reservations'])->get();
        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,dipesan,maintenance',
            'rumah_makan_id' => 'required|exists:rumah_makans,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $room = Room::create($data);
        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Room::with(['rumahMakan', 'reservations'])->find($id);
        if (!$room) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|in:tersedia,dipesan,maintenance',
            'rumah_makan_id' => 'sometimes|required|exists:rumah_makans,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $room->update($data);
        return response()->json($room);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $room->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
