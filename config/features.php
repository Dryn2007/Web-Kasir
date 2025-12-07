<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 🌍 FITUR GLOBAL (Semua Pengunjung)
    |--------------------------------------------------------------------------
    */

    // Light Mode & Dark Mode Switcher
    'darkmode' => true,

    // Tampilan Rating Bintang (Global)
    'show_rating_stars' => true, // Tampilkan bintang rating di seluruh halaman

    // Landing Page (Homepage)
    'landing_page' => [
        'enabled'       => true,
        'hero_section'  => true,  // Hero Section dengan animasi background
        'trending_now'  => true,  // Menampilkan game terlaris
        'fresh_drops'   => true,  // Menampilkan game terbaru
        'best_sellers'  => true,  // Grid produk terpopuler
    ],

    // Advanced Search & Filter
    'search_filter' => [
        'enabled'         => true,
        'live_search'     => true,  // Live Search (AJAX) - Suggestion otomatis
        'category_filter' => true,  // Filter Kategori dropdown
        'sorting'         => true,  // Sorting: Popularitas, Harga, Rating, Terbaru
    ],

    // Product Detail Page
    'product_detail' => [
        'enabled'       => true,
        'show_image'    => true,
        'show_price'    => true,
        'show_stock'    => true,
        'show_description' => true,
        'show_rating'   => true,   // Statistik rating & bintang di detail produk
        'show_sold'     => true,   // Total terjual
        'show_reviews'  => true,   // List review dari user
    ],

    // About Us Page
    'about_page' => true,

    /*
    |--------------------------------------------------------------------------
    | 👤 FITUR USER (Customer/Player)
    |--------------------------------------------------------------------------
    */

    // Authentication
    'auth' => [
        'enabled'         => true,
        'login'           => true,
        'register'        => true,
        'edit_profile'    => true,  // Edit Nama, Email, Foto
        'change_password' => true,
        'delete_account'  => true,
    ],

    // Keranjang Belanja (Cart)
    'cart' => [
        'enabled'         => true,
        'add_item'        => true,
        'update_quantity' => true,  // Update jumlah (validasi stok maks)
        'remove_item'     => true,
        'auto_calculate'  => true,  // Hitung subtotal & grand total otomatis
    ],

    // Checkout & Pembayaran (Simulasi)
    'checkout' => [
        'enabled'           => true,
        'payment_methods'   => [
            'qris'   => true,
            'gopay'  => true,
            'dana'   => true,
        ],
        'simulate_payment'  => true,  // Halaman scan QR / input HP/PIN dummy
        'stock_validation'  => true,  // Validasi stok sebelum checkout
    ],

    // Riwayat Pesanan (My Library)
    'order_history' => [
        'enabled'           => true,
        'show_status'       => true,  // Status: Pending, Paid, Cancelled
        'digital_access'    => true,  // Link download/Key jika PAID
        'copy_key_button'   => true,  // Tombol "Copy Key"
    ],

    // Review System
    'review' => [
        'enabled'           => true,
        'require_purchase'  => true,  // User hanya bisa review produk yang dibeli
        'rating_stars'      => true,  // Input Rating (Bintang 1-5)
        'comment'           => true,  // Input Komentar
    ],

    // Live Support Chat (Floating Widget)
    'live_chat' => [
        'enabled'           => true,
        'floating_widget'   => true,  // Tombol chat melayang pojok kanan bawah
        'realtime_polling'  => true,  // Kirim pesan real-time (polling)
        'notification_badge' => true, // Badge merah jika ada balasan belum dibaca
    ],

    /*
    |--------------------------------------------------------------------------
    | 🛡️ FITUR ADMIN (Administrator)
    |--------------------------------------------------------------------------
    */

    // Dashboard Utama
    'admin_dashboard' => [
        'quick_menu'      => true,  // Menu navigasi cepat (Grid modules)
    ],

    // Manajemen Produk
    'product_management' => [
        'enabled'         => true,
        'edit'           => true,
        'create'          => true,
        'update'          => true,
        'delete'          => true,
        'upload_image'    => true,
        'set_price'       => true,
        'set_stock'       => true,
        'set_download'    => true,
        'assign_category' => true,
    ],

    // Manajemen Kategori
    'category_management' => [
        'enabled'         => true,
        'create'          => true,
        'delete'          => true,
        'show_count'      => true,  // Jumlah produk per kategori
    ],

    // Manajemen Order (Transaksi)
    'order_management' => [
        'enabled'         => true,
        'manual_approval' => true,   // Ubah status Pending -> Paid
        'cancel_order'    => true,   // Batalkan Pesanan
    ],

    // Manajemen User
    'user_management' => [
        'enabled'         => true,
        'view_list'       => true,   // Melihat daftar user
        'view_history'    => true,   // Lihat history transaksi user
        'delete_user'     => true,   // Hapus user
    ],

    // Manajemen Review
    'review_management' => [
        'enabled'         => true,
        'view_all'        => true,   // Melihat semua ulasan
        'reply'           => true,   // Reply Review (muncul di halaman produk)
        'delete'          => true,   // Hapus review tidak pantas
    ],

    // Live Chat Admin (Inbox System)
    'admin_chat' => [
        'enabled'           => true,
        'inbox_view'        => true,  // Tampilan seperti WhatsApp Web
        'view_messages'     => true,  // Melihat pesan masuk
        'reply_messages'    => true,  // Membalas pesan user
        'notification_badge' => true, // Badge jumlah pesan belum dibaca
    ],

    // CMS Halaman About
    'about_management' => [
        'enabled'         => true,
        'edit_title'      => true,   // Edit Judul
        'edit_content'    => true,   // Edit Konten
        'edit_image'      => true,   // Edit Gambar
    ],
];
