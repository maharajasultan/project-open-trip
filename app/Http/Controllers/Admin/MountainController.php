<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MountainController extends Controller
{
    public function index()
    {
        $mountains = Mountain::latest()->paginate(10);
        return view('admin.mountains.index', compact('mountains'));
    }

    public function create()
    {
        return view('admin.mountains.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'location'       => 'nullable|string|max:255',
            'price'          => 'required|numeric|min:0',
            'departure_date' => 'required|date|after:today',
            'quota'          => 'required|integer|min:1',
            'description'    => 'required|string',
            'itinerary'      => 'required|string',
            'altitude'       => 'nullable|integer',
            'difficulty'     => 'nullable|in:Easy,Medium,Hard',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('mountains', 'public');
        }

        Mountain::create($validated);

        return redirect()->route('admin.mountains.index')
            ->with('success', 'Data gunung berhasil ditambahkan!');
    }

    public function edit(Mountain $mountain)
    {
        return view('admin.mountains.edit', compact('mountain'));
    }

    public function update(Request $request, Mountain $mountain)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'location'       => 'nullable|string|max:255',
            'price'          => 'required|numeric|min:0',
            'departure_date' => 'required|date',
            'quota'          => 'required|integer|min:1',
            'description'    => 'required|string',
            'itinerary'      => 'required|string',
            'altitude'       => 'nullable|integer',
            'difficulty'     => 'nullable|in:Easy,Medium,Hard',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($mountain->image) {
                Storage::disk('public')->delete($mountain->image);
            }
            $validated['image'] = $request->file('image')->store('mountains', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $mountain->update($validated);

        return redirect()->route('admin.mountains.index')
            ->with('success', 'Data gunung berhasil diperbarui!');
    }

    public function destroy(Mountain $mountain)
    {
        if ($mountain->image) {
            Storage::disk('public')->delete($mountain->image);
        }

        $mountain->delete();

        return redirect()->route('admin.mountains.index')
            ->with('success', 'Data gunung berhasil dihapus!');
    }

    public function show(Mountain $mountain)
    {
        $mountain->load('transactions.user');
        return view('admin.mountains.show', compact('mountain'));
    }
}
