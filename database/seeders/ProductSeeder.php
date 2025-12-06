<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // --- 10 PRODUK LAMA ---
            [
                'name' => 'Laptop Gaming ASUS ROG',
                'price' => 15000000,
                'description' => 'Laptop spesifikasi tinggi dengan Intel Core i7 dan RTX 3060. Cocok untuk game berat dan rendering video.',
                'stock' => 5,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Mouse Wireless Logitech',
                'price' => 150000,
                'description' => 'Mouse tanpa kabel yang ergonomis dan hemat baterai. Koneksi stabil 2.4Ghz.',
                'stock' => 20,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Keyboard Mechanical RGB',
                'price' => 550000,
                'description' => 'Keyboard mekanikal dengan Blue Switch yang clicky. Dilengkapi lampu RGB yang bisa diatur.',
                'stock' => 15,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Monitor Samsung 24 Inch',
                'price' => 2100000,
                'description' => 'Monitor Full HD dengan panel IPS. Warna tajam dan nyaman di mata untuk penggunaan lama.',
                'stock' => 8,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Headset Gaming Razer',
                'price' => 1200000,
                'description' => 'Headset dengan suara surround 7.1. Busa telinga empuk dan mic jernih.',
                'stock' => 10,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'SSD NVMe 1TB Samsung',
                'price' => 1400000,
                'description' => 'Penyimpanan super cepat. Kecepatan baca hingga 3500MB/s.',
                'stock' => 25,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'RAM 16GB DDR4 Corsair',
                'price' => 850000,
                'description' => 'Memori RAM kit 2x8GB dengan heatsink pendingin. Stabil untuk multitasking.',
                'stock' => 30,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Kursi Gaming Ergonomis',
                'price' => 1800000,
                'description' => 'Kursi nyaman dengan sandaran punggung yang bisa direbahkan hingga 180 derajat.',
                'stock' => 3,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Meja Kerja Minimalis',
                'price' => 750000,
                'description' => 'Meja kayu dengan rangka besi yang kokoh. Ukuran 120x60cm.',
                'stock' => 5,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Kabel HDMI 2.0 (2 Meter)',
                'price' => 45000,
                'description' => 'Kabel HDMI support 4K 60Hz. Kabel tebal dan awet.',
                'stock' => 50,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],

            // --- 3 PRODUK BARU ---
            [
                'name' => 'Webcam Full HD 1080p',
                'price' => 450000,
                'description' => 'Webcam jernih dengan autofocus dan built-in microphone. Cocok untuk meeting online dan streaming.',
                'stock' => 12,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Speaker Bluetooth JBL',
                'price' => 950000,
                'description' => 'Speaker portable dengan suara bass yang nendang. Tahan air (IPX7) dan baterai tahan 10 jam.',
                'stock' => 7,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
            [
                'name' => 'Smartwatch Xiaomi Band',
                'price' => 599000,
                'description' => 'Gelang pintar pelacak kebugaran. Layar AMOLED, monitor detak jantung, dan notifikasi HP.',
                'stock' => 18,
                'image' => null,
                'download_url' => 'https://www.asus.com/id/laptops/for-gaming/tuf-gaming/',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
