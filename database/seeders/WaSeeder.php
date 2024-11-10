<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wa;

class WaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wa = new Wa();
        $wa->id = 1;
        $wa->id_akun = 1;
        $wa->no_wa = "082169376803";
        $wa->wa_group = "";
    }
}
