<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // --- AAA GAMES ---
            [
                'name' => 'Cyberpunk 2077: Ultimate',
                'price' => 699000,
                'description' => 'Jelajahi Night City dalam game Open World RPG futuristik paling ambisius. Termasuk ekspansi Phantom Liberty.',
                'stock' => 50,
                // Official Steam Header Image
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/1091500/Cyberpunk_2077/',
            ],
            [
                'name' => 'God of War Ragnarök',
                'price' => 879000,
                'description' => 'Ikuti perjalanan Kratos dan Atreus ke setiap Sembilan Alam sebelum Ragnarök tiba. Action Adventure terbaik.',
                'stock' => 35,
                // Official PlayStation/Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2322010/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/2322010/God_of_War_Ragnarok/',
            ],
            [
                'name' => 'Elden Ring',
                'price' => 599000,
                'description' => 'Game of the Year. Jelajahi Lands Between yang luas dan penuh misteri dalam RPG fantasi gelap ini.',
                'stock' => 100,
                // Bandai Namco / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/1245620/ELDEN_RING/',
            ],
            [
                'name' => 'Red Dead Redemption 2',
                'price' => 450000,
                'description' => 'Kisah epik kehidupan di Amerika pada fajar era modern. Detail dunia yang luar biasa realistis.',
                'stock' => 20,
                // Rockstar Games / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1174180/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/1174180/Red_Dead_Redemption_2/',
            ],

            // --- FPS & SHOOTER ---
            [
                'name' => 'Call of Duty: Modern Warfare III',
                'price' => 1050000,
                'description' => 'Sekuel langsung dari MWII. Kampanye sinematik dan multiplayer kompetitif kelas dunia.',
                'stock' => 200,
                // Activision / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2519060/header.jpg',
                'download_url' => 'https://www.callofduty.com/',
            ],
            [
                'name' => 'Valorant (Starter Pack 5000 VP)',
                'price' => 499000,
                'description' => 'Kode Redeem 5000 VP untuk membeli skin senjata premium di store Valorant Indonesia.',
                'stock' => 999,
                // Riot Games Official Key Art
                'image' => 'https://cmsassets.rgpub.io/sanity/images/dsfx7636/news/e679ee15e6af2a6a09618d22736b0051674b83b6-2001x1126.jpg',
                'download_url' => 'https://playvalorant.com/',
            ],

            // --- SPORTS & RACING ---
            [
                'name' => 'EA SPORTS FC™ 24',
                'price' => 759000,
                'description' => 'Era baru The Worlds Game. 19.000+ pemain berlisensi penuh, 700+ tim, dan 30+ liga.',
                'stock' => 60,
                // EA Sports / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2195250/header.jpg',
                'download_url' => 'https://www.ea.com/games/ea-sports-fc/fc-24',
            ],
            [
                'name' => 'Forza Horizon 5',
                'price' => 699000,
                'description' => 'Petualangan Horizon terbaik menantimu! Jelajahi lanskap Meksiko yang hidup dan terus berubah.',
                'stock' => 45,
                // Xbox Game Studios / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1551360/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/1551360/Forza_Horizon_5/',
            ],

            // --- SURVIVAL & INDIE ---
            [
                'name' => 'Minecraft: Java & Bedrock',
                'price' => 350000,
                'description' => 'Bangun apa saja yang bisa kamu bayangkan. Jelajahi dunia tak terbatas dan bertahan hidup di malam hari.',
                'stock' => 500,
                // Xbox Store Image (Clean)
                'image' => 'https://image.api.playstation.com/vulcan/img/rnd/202010/2217/LsaRVLF2IU2L1fnGmqYfIqk2.png',
                'download_url' => 'https://www.minecraft.net/download',
            ],
            [
                'name' => 'Stardew Valley',
                'price' => 115000,
                'description' => 'Kamu mewarisi lahan pertanian tua kakekmu. Bisakah kamu belajar hidup dari tanah ini?',
                'stock' => 150,
                // ConcernedApe / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/413150/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/413150/Stardew_Valley/',
            ],

            // --- HORROR ---
            [
                'name' => 'Resident Evil 4 Remake',
                'price' => 830000,
                'description' => 'Survival horror lahir kembali. Leon S. Kennedy dikirim untuk menyelamatkan putri presiden yang diculik.',
                'stock' => 30,
                // Capcom / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/2050650/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/2050650/Resident_Evil_4/',
            ],
            [
                'name' => 'Phasmophobia',
                'price' => 120000,
                'description' => 'Horor psikologis kooperatif 4 pemain online. Aktivitas paranormal semakin tinggi, kamu harus berani.',
                'stock' => 80,
                // Kinetic Games / Steam Asset
                'image' => 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/739630/header.jpg',
                'download_url' => 'https://store.steampowered.com/app/739630/Phasmophobia/',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
