<?php
namespace Database\Seeders;

use App\Models\Mountain;
use Illuminate\Database\Seeder;

class MountainSeeder extends Seeder
{
    public function run(): void
    {
        $mountains = [
            [
                'name'           => 'Gunung Rinjani',
                'location'       => 'Lombok, NTB',
                'price'          => 850000,
                'departure_date' => now()->addDays(30),
                'quota'          => 20,
                'altitude'       => 3726,
                'difficulty'     => 'Hard',
                'description'    => 'Rinjani adalah gunung berapi aktif tertinggi kedua di Indonesia...',
                'itinerary'      => "Hari 1: Meeting point di Senaru, briefing, mulai pendakian\nHari 2: Menuju Plawangan Senaru (2641 mdpl)\nHari 3: Summit attack ke puncak 3726 mdpl\nHari 4: Turun via Sembalun, kembali ke basecamp",
                'is_active'      => true,
            ],
            [
                'name'           => 'Gunung Semeru',
                'location'       => 'Lumajang, Jawa Timur',
                'price'          => 650000,
                'departure_date' => now()->addDays(14),
                'quota'          => 15,
                'altitude'       => 3676,
                'difficulty'     => 'Hard',
                'description'    => 'Mahameru, puncak abadi para dewa, tertinggi di Pulau Jawa...',
                'itinerary'      => "Hari 1: Tumpang → Ranu Pani → Ranu Kumbolo\nHari 2: Ranu Kumbolo → Kalimati (summit camp)\nHari 3: Summit Mahameru → Ranu Pani → Tumpang",
                'is_active'      => true,
            ],
            [
                'name'           => 'Gunung Prau',
                'location'       => 'Wonosobo, Jawa Tengah',
                'price'          => 350000,
                'departure_date' => now()->addDays(7),
                'quota'          => 25,
                'altitude'       => 2565,
                'difficulty'     => 'Easy',
                'description'    => 'Spot terbaik untuk menyaksikan golden sunrise dengan latar 7 gunung...',
                'itinerary'      => "Hari 1: Basecamp Dieng → Puncak Prau (2 jam)\nHari 2: Sunrise, foto-foto, turun ke basecamp",
                'is_active'      => true,
            ],
        ];

        foreach ($mountains as $data) {
            Mountain::create($data);
        }
    }
}