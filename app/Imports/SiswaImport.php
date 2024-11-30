<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Kelas;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
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
            'no_hp' => $row['no_hp'],
            'no_hp_ortu' => $row['no_hp_orangtua']
        ]);
    }

    public function rules(): array
    {
        return [
            'jurusan' => 'required|exists:jurusan,id',
            'kelas' => 'required|exists:kelas,id',
            'nama_siswa' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'no_hp_orangtua' => 'required'
        ];
    }

    public function customValidationMessages()
    {      
        
        return [
            'jurusan.in' =>  "Data Jurusan Tidak valid",
            'kelas.in' =>  "Data kelas Tidak valid",
        ];
    }
}
