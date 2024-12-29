<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolah = new Sekolah();
        $sekolah->id = 112233;
        $sekolah->id_user = 1;
        $sekolah->id_wa = 1;
        $sekolah->id_mesin = 1;
        $sekolah->id_paket = 1;
        $sekolah->nama_sekolah = 'SMK SWASTA PAB 12';
        $sekolah->email = 'smkpab12@gmail.com';
        $sekolah->pendidikan = 'SMK';
        $sekolah->no_hp = 233453453;
        $sekolah->npsn = '122434';
        $sekolah->limit_siswa = 100;
        $sekolah->id_slug_user = 'PAB12';
        $sekolah->save();
    }
}
