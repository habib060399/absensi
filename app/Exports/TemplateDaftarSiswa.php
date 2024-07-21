<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use App\Helpers\Helper;
use App\Models\Jurusan;
use App\Models\Kelas;

class TemplateDaftarSiswa implements WithHeadings, WithStyles, FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    
    // }

    public function getContent() {
        // $id_jurusan = 0;
        $content = '';
        $jurusan = Jurusan::where('id_sekolah', Helper::getSession())->get();
        
        for ($i=0; $i < count($jurusan); $i++) { 
            $kelas = Kelas::where('id_jurusan', $jurusan[$i]['id'])->get();
            $id_jurusan = $jurusan[$i]['id'];
            $content .= "(Id: $id_jurusan)"." - ".$jurusan[$i]['nama_jurusan']."\n";
            for ($a=0; $a < count($kelas); $a++) { 
                $content .= $kelas[$a]['kelas']." - Id Kelas: ".$kelas[$a]['id']."\n";
            }
        }
        
        return $content;
    }

    public function array(): array
    {
        return [
            [null, null, null, null, null, null, null, null, null, null, null, null, $this->getContent()],
        ];
    }

    public function headings(): array {
        return [
            "ID_SEKOLAH",
            "NAMA SEKOLAH",
            "JURUSAN",
            "KELAS",
            "NAMA SISWA",
            "EMAIL",
            "RFID",
            "NO HP",
            "NO HP ORANGTUA"
        ];
    }

    public function column(): array {
        return ['M' => Text::make('Name', 'name')];
    }
        
    public function styles(Worksheet $sheet) {
        $sheet->mergeCells('M2:R20');
    }
}
