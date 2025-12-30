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
        try {
            $rumahMakans = RumahMakan::all();
            $menus = Menu::all();
            return view('menus.index', compact('rumahMakans', 'menus'));
        } catch (\Exception $e) {
            \Log::error('MenuController@index error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function create(Request $request)
    {
        $rumahMakanId = $request->query('rumah_makan_id');
        $rumahMakan = RumahMakan::findOrFail($rumahMakanId);
        return view('menus.create', compact('rumahMakan'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'image' => 'nullable|image|max:5120',
                'status' => 'required|in:available,out_of_stock',
                'rumah_makan_id' => 'required|exists:rumah_makans,id'
            ]);

            // Set default empty string untuk image jika tidak ada upload
            $validated['image'] = '';
            
            if ($request->hasFile('image')) {
                try {
                    $disk = config('filesystems.default', 'local');
                    $path = $request->file('image')->store('menu_images', $disk);
                    $validated['image'] = $path;
                } catch (\Throwable $e) {
                    \Log::error('Menu image upload failed: '.$e->getMessage());
                    // Tetap gunakan empty string jika upload gagal
                }
            }

            Menu::create($validated);

            return redirect()->route('rumah-makan.show', $request->rumah_makan_id)
                ->with('success', 'Menu berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('MenuController@store error: ' . $e->getMessage() . ' | Line: ' . $e->getLine() . ' | File: ' . $e->getFile());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'image' => 'nullable|image|max:5120',
                'status' => 'required|in:available,out_of_stock'
            ]);

            if ($request->hasFile('image')) {
                try {
                    $disk = config('filesystems.default', 'local');
                    if ($menu->image) {
                        Storage::disk($disk)->delete($menu->image);
                    }
                    $path = $request->file('image')->store('menu_images', $disk);
                    $validated['image'] = $path;
                } catch (\Throwable $e) {
                    \Log::error('Menu image upload failed: '.$e->getMessage());
                    // Jangan update image jika upload gagal
                    unset($validated['image']);
                }
            }

            $menu->update($validated);

            return redirect()->route('rumah-makan.show', $menu->rumah_makan_id)
                ->with('success', 'Menu berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('MenuController@update error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            $rumahMakanId = $menu->rumah_makan_id;
            
            if ($menu->image) {
                try {
                    $disk = config('filesystems.default', 'local');
                    Storage::disk($disk)->delete($menu->image);
                } catch (\Throwable $e) {
                    logger()->warning('Menu image delete failed: '.$e->getMessage());
                }
            }
            
            $menu->delete();

            return redirect()->route('rumah-makan.show', $rumahMakanId)
                ->with('success', 'Menu berhasil dihapus');
        } catch (\Exception $e) {
            logger()->error('MenuController@destroy error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus menu']);
        }
    }
}
