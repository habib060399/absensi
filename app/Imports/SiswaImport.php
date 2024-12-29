<?php

namespace App\Imports;

use App\Helpers\Helper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Siswa;

class SiswaImport implements ToCollection, WithHeadingRow, WithValidation
{

    public function collection(Collection $rows)
    {
        $limit = Helper::getSekolah('limit_siswa');

        foreach ($rows as $row) {
                if(Siswa::checkLimit((int) $limit->limit_siswa, ['id_sekolah' => $row['id_sekolah']])){
                    $this->message= "Data Siswa sudah mencapai batas limit";
                    return redirect()->route("siswa")->with("error", "Data Siswa sudah mencapai limit !");
                }else{
                    Siswa::create([
                        'id_sekolah' => $row['id_sekolah'],
                        'id_kelas' => $row['kelas'],
                        'nama_siswa' => $row['nama_siswa'],
                        'email' => $row['email'],
                        'no_hp' => $row['no_hp'],
                        'no_hp_ortu' => $row['no_hp_orangtua']
                    ]);
                }
        }
        return redirect()->route("siswa")->with("success", "Data Siswa berhasil ditambahkan");
    }

    public function rules(): array
    {
            return  [
                'kelas' => 'required|exists:kelas,id',
                'jurusan' => 'exists:jurusan,id',
                'nama_siswa' => 'required',
                'email' => 'required',
                'no_hp' => 'required',
                'no_hp_orangtua' => 'required'
            ];
    }
}
