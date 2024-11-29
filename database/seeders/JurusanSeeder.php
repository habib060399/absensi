<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Sekolah;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        $jurusan = new Jurusan();
        $jurusan->id = 8900;
        $jurusan->id_sekolah = 112233;
        $jurusan->nama_jurusan = 'Teknik Komputer Jaringan';
        $jurusan->save();

        $jurusan1 = new Jurusan();
        $jurusan1->id = 89000;
        $jurusan1->id_sekolah = 112233;
        $jurusan1->nama_jurusan = 'Teknik Kendaraan Ringan';
        $jurusan1->save();
    }
}
