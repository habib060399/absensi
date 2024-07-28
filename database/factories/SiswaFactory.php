<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Siswa;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'id' => Str::random(10),
            'id_sekolah' => 1,
            'id_jurusan' => 1,
            'id_kelas' => 1,
            'nama_siswa' => $this->faker->name(),
            'email' => $this->faker->email(),
            'rfid' => $this->faker->randomNumber(5, true),
            'no_hp' => $this->faker->randomNumber(5, true),
            'no_hp_ortu' => $this->faker->randomNumber(5, true)
        ];
    }
}
