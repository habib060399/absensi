<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Absensi;
use App\Models\Siswa;

class RekapAbsen implements WithHeadings, WithStyles, FromArray
{
    public $jurusan;
    public $kelas;
    public $tgl_mulai;
    public $tgl_selesai;

    public function __construct($jurusan, $kelas, $tgl_mulai, $tgl_selesai) {
        $this->jurusan = $jurusan;
        $this->kelas = $kelas;
        $this->tgl_mulai = $tgl_mulai;
        $this->tgl_selesai = $tgl_selesai;  
    }

    public function array(): array {
        $nama_siswa = '';
        $absen = Siswa::join('absensi', 'siswa.id', '=', 'absensi.id_siswa')->where('id_jurusan', $this->jurusan)->where('id_kelas', $this->kelas)->select('absensi.*','nama_siswa')->get();
        foreach ($absen as $a) {
            $nama_siswa .= $a->nama_siswa;
        }
        return [
            [$nama_siswa],
        ];
    }

    public function headings(): array {
        return [
            "Nama Siswa",
            "Bulan: "
        ];
    }
    public function styles(Worksheet $sheet) {
        $sheet->mergeCells('M2:R20');
    }
}
