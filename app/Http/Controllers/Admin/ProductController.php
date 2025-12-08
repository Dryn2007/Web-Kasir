<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage; // No longer needed for local storage
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary; // Import Cloudinary

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

        // 3. LOGIKA FILTER KATEGORI
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

        // 5. Secondary Sort
        if ($request->sort !== 'latest') {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(10)->appends($request->all());
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
        // Build validation rules
        $rules = [
            'name' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Validasi file image
            'image_url' => 'nullable|url',
        ];

        if (config('features.product_management.set_price')) {
            $rules['price'] = 'required|numeric';
        }
        if (config('features.product_management.set_stock')) {
            $rules['stock'] = 'required|integer';
        }
        if (config('features.product_management.set_download')) {
            $rules['download_url'] = 'required|url';
        }
        if (config('features.product_management.assign_category')) {
            $rules['category_id'] = 'nullable|exists:categories,id';
        }

        $request->validate($rules);

        // Build data array
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => config('features.product_management.set_price') ? $request->price : 0,
            'stock' => config('features.product_management.set_stock') ? $request->stock : 0,
            'download_url' => config('features.product_management.set_download') ? $request->download_url : '#',
            'category_id' => config('features.product_management.assign_category') ? $request->category_id : null,
        ];

        // --- CLOUDINARY UPLOAD LOGIC ---
        if (config('features.product_management.upload_image')) {
            if ($request->hasFile('image')) {
                // Upload ke Cloudinary folder 'products'
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'products',
                ])->getSecurePath();
                
                $data['image'] = $uploadedFileUrl; // Simpan URL Cloudinary
            } elseif ($request->filled('image_url')) {
                $data['image'] = $request->image_url;
            }
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
        $rules = [
            'name' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
        ];

        if (config('features.product_management.set_price')) {
            $rules['price'] = 'required|numeric';
        }
        if (config('features.product_management.set_stock')) {
            $rules['stock'] = 'required|integer';
        }
        if (config('features.product_management.set_download')) {
            $rules['download_url'] = 'required|url';
        }
        if (config('features.product_management.assign_category')) {
            $rules['category_id'] = 'nullable|exists:categories,id';
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => config('features.product_management.set_price') ? $request->price : $product->price,
            'stock' => config('features.product_management.set_stock') ? $request->stock : $product->stock,
            'download_url' => config('features.product_management.set_download') ? $request->download_url : $product->download_url,
            'category_id' => config('features.product_management.assign_category') ? $request->category_id : $product->category_id,
        ];

        // --- CLOUDINARY UPDATE LOGIC ---
        if (config('features.product_management.upload_image')) {
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada (Opsional, perlu logic ekstrak public_id)
                // Cloudinary::destroy($public_id); 

                // Upload gambar baru
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'products',
                ])->getSecurePath();

                $data['image'] = $uploadedFileUrl;
            } elseif ($request->filled('image_url')) {
                $data['image'] = $request->image_url;
            }
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    // Hapus data
    public function destroy(Product $product)
    {
        // Jika ingin menghapus file di Cloudinary saat produk dihapus, 
        // Anda perlu menyimpan 'public_id' Cloudinary di database juga.
        // Untuk sekarang kita hanya hapus data di DB.
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}