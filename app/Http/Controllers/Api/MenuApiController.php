<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MenuApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('rumahMakan')->get();
        return response()->json($menus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|in:available,out_of_stock',
            'rumah_makan_id' => 'required|exists:rumah_makans,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('public/menu_images');
                $data['image'] = str_replace('public/', '', $path);
            } catch (\Exception $e) {
                // File upload gagal, lewati image
                $data['image'] = null;
            }
        }
        $menu = Menu::create($data);
        return response()->json($menu, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $menu = Menu::with('rumahMakan')->find($id);
        if (!$menu) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|max:5120',
            'status' => 'sometimes|required|in:available,out_of_stock',
            'rumah_makan_id' => 'sometimes|required|exists:rumah_makans,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        if ($request->hasFile('image')) {
            try {
                if ($menu->image) {
                    Storage::delete('public/' . $menu->image);
                }
                $path = $request->file('image')->store('public/menu_images');
                $data['image'] = str_replace('public/', '', $path);
            } catch (\Exception $e) {
                // File upload gagal, lewati image
                unset($data['image']);
            }
        }
        $menu->update($data);
        return response()->json($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Not found'], 404);
        }
        if ($menu->image) {
            Storage::delete('public/' . $menu->image);
        }
        $menu->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
