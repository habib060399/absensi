<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumns;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Columns\Column;

class TemplateDaftarSiswa implements WithHeadings, WithStyles, WithColumns
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }

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
        $sheet->mergeCells('M1:R20');
    }
}
