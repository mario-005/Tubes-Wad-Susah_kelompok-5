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

        $disk = config('filesystems.default');
        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('menu_images', $disk);
                $validated['image'] = $path;
            } catch (\Throwable $e) {
                logger()->error('Menu image upload failed: '.$e->getMessage());
                $validated['image'] = '';
            }
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

        $disk = config('filesystems.default');
        if ($request->hasFile('image')) {
            try {
                if ($menu->image) {
                    Storage::disk($disk)->delete($menu->image);
                }
            } catch (\Throwable $e) {
                logger()->warning('Menu image delete failed: '.$e->getMessage());
            }
            try {
                $path = $request->file('image')->store('menu_images', $disk);
                $validated['image'] = $path;
            } catch (\Throwable $e) {
                logger()->error('Menu image upload failed: '.$e->getMessage());
            }
        }

        $menu->update($validated);

        return redirect()->route('rumah-makan.show', $menu->rumah_makan_id)
            ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        $rumahMakanId = $menu->rumah_makan_id;
        $disk = config('filesystems.default');
        
        if ($menu->image) {
            try {
                Storage::disk($disk)->delete($menu->image);
            } catch (\Throwable $e) {
                logger()->warning('Menu image delete failed: '.$e->getMessage());
            }
        }
        
        $menu->delete();

        return redirect()->route('rumah-makan.show', $rumahMakanId)
            ->with('success', 'Menu berhasil dihapus');
    }
}
