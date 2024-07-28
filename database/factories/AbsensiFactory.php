<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Siswa;
use App\Models\Absensi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AbsensiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Absensi::class;

    public function definition(): array
    {
        $count = Siswa::all()->count();
        $siswa = Siswa::all();
        $a = 0;
        while ($a <= $count) {
            $a += 1;
            
            return [
                'id_siswa' => $siswa[$a]['id'],
                'tanggal' => $this->faker->date('Y_m_d'),
                'waktu' => $this->faker->time('H_i_s'),
                'status' => 'Hadir'
            ];            
        }
    }

    public function custom()
    {
        $count = Siswa::all()->count();
        $siswa = Siswa::all();
        $a = 0;
        while ($a < $count) {
            Absensi::create([
                'id_siswa' => $siswa[$a]['id'],
                'tanggal' => "2024-07-05",
                'waktu' => $this->faker->time('H:i:s'),
                'status' => 'Hadir'
            ]);
            $a++;
            // return [
            //     'id_siswa' => $siswa[$a]['id'],
            //     'tanggal' => $this->faker->date('Y_m_d'),
            //     'waktu' => $this->faker->time('H_i_s'),
            //     'status' => 'Hadir'
            // ];            
        }
    }
}
