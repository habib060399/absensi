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

// class TemplateDaftarSiswa implements WithHeadings, WithStyles, FromArray
class TemplateDaftarSiswa implements WithHeadings, FromArray
{
    var $id_jurusan;
    var $id_kelas;
    var $count = 1;

    public function __construct($id_jurusan, $id_kelas, $count)
    {
        $this->id_jurusan = $id_jurusan;
        $this->id_kelas = $id_kelas;
        $this->count = $count;
    }

    public function getContent() {
        // $id_jurusan = 0;
        $content = '';
        $jurusan = Jurusan::where('id_sekolah', session('id_sekolah'))->get();
        $content .= "Sekolah - id = " . session('id_sekolah') . "\n";
        for ($i=0; $i < count($jurusan); $i++) { 
            $kelas = Kelas::where('id_jurusan', $jurusan[$i]['id'])->get();
            $id_jurusan = $jurusan[$i]['id'];
            $content .= $jurusan[$i]['nama_jurusan']. " - Id = $id_jurusan\n";
            for ($a=0; $a < count($kelas); $a++) { 
                $content .= $kelas[$a]['kelas']." - Id Kelas = ".$kelas[$a]['id']."\n";
            }
        }
        
        return $content;
    }

    public function array(): array
    {
        $cell = array();
        for ($i=1; $i <= $this->count ; $i++) { 
            $cell[$i] = array_merge([session('id_sekolah'), $this->id_jurusan, $this->id_kelas, null, null, null, null, null, null, null, null, null]);
        }
        // dd($cell);
        return [
            $cell
        ];
    }

    public function headings(): array {
        return [
            "ID SEKOLAH",            
            "JURUSAN",
            "KELAS",
            "NAMA SISWA",
            "EMAIL",            
            "NO HP",
            "NO HP ORANGTUA"
        ];
    }

    // public function column(): array {
    //     return ['M' => Text::make('Name', 'name')];
    // }
        
    // public function styles(Worksheet $sheet) {
    //     $sheet->mergeCells('M2:R20');
    // }
}
