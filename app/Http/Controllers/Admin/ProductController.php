<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('admin.products.create');
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'download_url' => 'required|url',
        ]);

        $data = $request->all();

        // Cek jika ada upload gambar
        if ($request->hasFile('image')) {
            // Jika ada file diupload, simpan ke storage
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // Jika tidak ada file, tapi ada link URL, simpan linknya
            $data['image'] = $request->image_url;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Update data ke database
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'download_url' => 'required|url',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // 1. Jika user upload file baru
            // Hapus gambar lama jika itu file lokal (bukan link)
            if ($product->image && !str_starts_with($product->image, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            // Simpan yang baru
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // 2. Jika user memasukkan link baru
            // Hapus gambar lama jika itu file lokal
            if ($product->image && !str_starts_with($product->image, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            // Simpan linknya
            $data['image'] = $request->image_url;
        } else {
            // 3. Jika tidak diubah apa-apa, pakai gambar lama (hapus key image dari array data agar tidak tertimpa null)
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus data
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}
