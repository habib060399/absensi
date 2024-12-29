<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paket = new Paket();
        $paket->id = 1;
        $paket->type = 'unit';
        $paket->nama_paket = 'A';
        $paket->siswa = 1;
        $paket->active = 1;
        $paket->price = 3000;
//        $paket->detail = `{"data":[{"text":"notifikasi Whatsapp","status": "active"},{"text":"10.000 pesan/bulan","status":"active"},{"text":"kirim pesan whatsapp","status":"inactive"},{"text":"sms","status":"inactive"},{"text":"support mesin absen","status":"inactive"},{"text":"support mobile app","status":"inactive"}]}`;
        $paket->save();
    }
}
