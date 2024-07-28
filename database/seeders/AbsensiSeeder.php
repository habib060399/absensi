<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\AbsensiFactory;
// use App\Models\Absensi;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $absensi = new Absensi();
        // $absensi->id_siswa = ;
        // $absensi->tanggal = ;
        // $absensi->waktu = ;
        // $absensi->status = ;
        // \App\Models\Absensi::factory(5)->create();
        $absensi = new AbsensiFactory();
        $absensi->custom();
    }
}
