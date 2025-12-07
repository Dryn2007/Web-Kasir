<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        // Ambil data pertama (karena cuma ada 1 record)
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $about = About::first();

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // Handle Upload Gambar Baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($about->image && Storage::exists('public/' . $about->image)) {
                Storage::delete('public/' . $about->image);
            }
            // Simpan gambar baru
            $path = $request->file('image')->store('about', 'public');
            $data['image'] = $path;
        }

        $about->update($data);

        return redirect()->back()->with('success', 'Halaman About Us berhasil diupdate!');
    }
}
