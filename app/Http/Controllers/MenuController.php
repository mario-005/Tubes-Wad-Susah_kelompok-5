<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\RumahMakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $rumahMakans = RumahMakan::all();
        $menus = Menu::all();
        return view('menus.index', compact('rumahMakans', 'menus'));
    }

    public function create(Request $request)
    {
        $rumahMakanId = $request->query('rumah_makan_id');
        $rumahMakan = RumahMakan::findOrFail($rumahMakanId);
        return view('menus.create', compact('rumahMakan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|in:available,out_of_stock',
            'rumah_makan_id' => 'required|exists:rumah_makans,id'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/menu_images');
            $validated['image'] = str_replace('public/', '', $path);
        }

        Menu::create($validated);

        return redirect()->route('rumah-makan.show', $request->rumah_makan_id)
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'status' => 'required|in:available,out_of_stock'
        ]);

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete($menu->image);
            }
            $path = $request->file('image')->store('public/menu_images');
            $validated['image'] = str_replace('public/', '', $path);
        }

        $menu->update($validated);

        return redirect()->route('rumah-makan.show', $menu->rumah_makan_id)
            ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        $rumahMakanId = $menu->rumah_makan_id;
        
        if ($menu->image) {
            Storage::delete($menu->image);
        }
        
        $menu->delete();

        return redirect()->route('rumah-makan.show', $rumahMakanId)
            ->with('success', 'Menu berhasil dihapus');
    }
}
