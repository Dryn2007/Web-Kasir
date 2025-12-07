<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // Pastikan import ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index(Request $request)
    {
        // 1. MULAI QUERY DENGAN RELASI STATISTIK
        $query = Product::query()
            ->with('category') // Load relasi kategori
            ->withAvg('reviews', 'rating') // Hitung rata-rata bintang
            ->withCount('reviews')         // Hitung jumlah ulasan
            ->withSum(['orderItems' => function ($q) { // Hitung total terjual (Lunas)
                $q->whereHas('order', fn($o) => $o->where('status', 'paid'));
            }], 'quantity');

        // 2. LOGIKA SEARCH
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. LOGIKA FILTER KATEGORI (PENTING: Agar dropdown filter di Admin berfungsi)
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // 4. LOGIKA SORTIR
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

        // 5. Secondary Sort (Agar urutan stabil)
        if ($request->sort !== 'latest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(10)->appends($request->all());

        // AMBIL SEMUA KATEGORI (PENTING: Untuk dropdown filter di halaman index admin)
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Menampilkan form tambah
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
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
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
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
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->image_url;
        } else {
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus data
    public function destroy(Product $product)
    {
        if ($product->image && !str_starts_with($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}
