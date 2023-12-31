<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Perangkat;

class AdminControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_device()
    {
        $nama_sekolah = 'SMK Budi Jaya';
        $uniq_id = '1234567899876543';
        $response = $this->post('/register-device/create', ['nama_sekolah' => $nama_sekolah, 'id_perangkat' => $uniq_id]);

        if($response->assertStatus(302)){
            Perangkat::create([
                'nama_sekolah' => $nama_sekolah,
                'id_mesin' => $uniq_id
            ]);
        }
    }
}
