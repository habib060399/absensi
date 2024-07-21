<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Siswa;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    // public function collection(Collection $collection)
    // {
    //     //
    // }

    public function model(array $row) {
        return new Siswa([
            'id_sekolah' => $row['id_sekolah'],
            'id_jurusan' => $row['jurusan'],
            'id_kelas' => $row['kelas'],
            'nama_siswa' => $row['nama_siswa'],
            'email' => $row['email'],
            'rfid' => $row['rfid'],
            'no_hp' => $row['no_hp'],
            'no_hp_ortu' => $row['no_hp_orangtua']
        ]);
    }
}
