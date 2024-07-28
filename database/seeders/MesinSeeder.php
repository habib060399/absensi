<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mesin;

class MesinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesin = new Mesin();
        $mesin->id_mesin = '12345ff';
        $mesin->status = 'Used';
        $mesin->save();
    }
}
