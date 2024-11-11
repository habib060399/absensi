<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = new Kelas();
        $kelas->id_user = 2;
        $kelas->id_sekolah = 1;
        $kelas->id_jurusan = 1;
        $kelas->kelas = 'X';
        $kelas->save();

        $kelas1 = new Kelas();
        $kelas1->id_user = 3;
        $kelas1->id_sekolah = 1;
        $kelas1->id_jurusan = 2;
        $kelas1->kelas = 'XI';
        $kelas1->save();
    }
}
