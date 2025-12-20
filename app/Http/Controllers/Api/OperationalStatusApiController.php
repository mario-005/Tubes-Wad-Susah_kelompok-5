<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OperationalStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperationalStatusApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = OperationalStatus::with('rumahMakan')->get();
        return response()->json($statuses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'status' => 'required|in:open,closed',
            'rumah_makan_id' => 'required|exists:rumah_makans,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $status = OperationalStatus::create($data);
        return response()->json($status, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $status = OperationalStatus::with('rumahMakan')->find($id);
        if (!$status) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $status = OperationalStatus::find($id);
        if (!$status) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'date' => 'sometimes|required|date',
            'open_time' => 'sometimes|required|date_format:H:i',
            'close_time' => 'sometimes|required|date_format:H:i|after:open_time',
            'status' => 'sometimes|required|in:open,closed',
            'rumah_makan_id' => 'sometimes|required|exists:rumah_makans,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $status->update($data);
        return response()->json($status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = OperationalStatus::find($id);
        if (!$status) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $status->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
