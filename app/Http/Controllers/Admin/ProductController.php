<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index(Request $request)
    {
        // 1. MULAI QUERY DENGAN RELASI STATISTIK
        $query = Product::query()
            ->withAvg('reviews', 'rating') // Hitung rata-rata bintang -> reviews_avg_rating
            ->withCount('reviews')         // Hitung jumlah ulasan -> reviews_count
            ->withSum(['orderItems' => function ($q) { // Hitung total terjual (Lunas)
                $q->whereHas('order', fn($o) => $o->where('status', 'paid'));
            }], 'quantity'); // -> order_items_sum_quantity

        // 2. LOGIKA SEARCH
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. LOGIKA SORTIR
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popular': // Terlaris
                    $query->orderByRaw('COALESCE(order_items_sum_quantity, 0) DESC');
                    break;
                case 'rating_high': // Bintang Tertinggi
                    $query->orderByRaw('COALESCE(reviews_avg_rating, 0) DESC');
                    break;
                case 'rating_low': // Bintang Terendah
                    $query->orderByRaw('COALESCE(reviews_avg_rating, 0) ASC');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // latest
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        // 4. Secondary Sort (Agar urutan stabil)
        if ($request->sort !== 'latest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(10)->appends($request->all());

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
