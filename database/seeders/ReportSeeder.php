<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample reports for existing users
        $users = \App\Models\User::all();

        if ($users->count() > 0) {
            // Create 10 sample reports
            \App\Models\Report::factory(10)->create([
                'user_id' => $users->random()->id,
            ]);

            // Create specific sample reports for demonstration
            \App\Models\Report::factory()->pengaduan()->pending()->create([
                'user_id' => $users->first()->id,
                'title' => 'Lampu Jalan Rusak di Jalan Merdeka',
                'content' => 'Lampu jalan di sepanjang Jalan Merdeka sudah rusak sejak seminggu yang lalu. Hal ini membuat jalan menjadi gelap di malam hari dan berpotensi menimbulkan kecelakaan.',
                'location_address' => 'Jalan Merdeka No. 45, Jakarta Pusat',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
            ]);

            \App\Models\Report::factory()->aspirasi()->approved()->create([
                'user_id' => $users->first()->id,
                'title' => 'Usulan Pembangunan Taman Kota',
                'content' => 'Mengusulkan pembangunan taman kota di area kosong dekat perumahan untuk meningkatkan kualitas lingkungan dan ruang terbuka hijau.',
                'location_address' => 'Jl. Sudirman Blok A, Jakarta Selatan',
                'latitude' => -6.2297,
                'longitude' => 106.8230,
            ]);
        }
    }
}
