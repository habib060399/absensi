<?php

namespace App\Imports;

use App\Helpers\Helper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Siswa;

class SiswaImportWithJurusan implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    var $message = null;
    var $id_sekolah = '';
    public $id_jurusan;
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
                        'id_jurusan' => $row['jurusan'],
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
            'limit' => $this->message
        ];
    }

    public function withValidator($validator){
        $validator->after(function ($validator){
            if($this->message){
                $validator->errors()->add("limit", "$this->message");
            }
        });
    }

}
