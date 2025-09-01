<?php

namespace Database\Seeders;

use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seats = [];
        $now = Carbon::now();

        // Generate seats dari nomor 1 sampai 495
        for ($i = 1; $i <= 495; $i++) {
            $seats[] = [
                'seat_number' => $i, // Format: 1, 2, 3, dst
                'is_booked' => 0, // Default tidak di-booking
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert data ke tabel seats
        Seat::insert($seats);

        $this->command->info('Berhasil membuat 495 kursi (1 - 495)');
    }
}
