<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        About::create([
            'title' => 'LEVEL UP YOUR GAMING EXPERIENCE',
            'content' => "Kami adalah platform distribusi game digital terdepan yang didirikan oleh gamers, untuk gamers. \n\nMisi kami sederhana: Memberikan akses instan ke ribuan judul game original dengan harga yang masuk akal. Tanpa menunggu pengiriman fisik, tanpa ribet. \n\nBergabunglah dengan komunitas kami dan mulailah petualangan barumu detik ini juga.",
            'image' => null,
        ]);
    }
}
