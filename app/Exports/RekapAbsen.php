<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;

class RekapAbsen implements WithMultipleSheets
{
    use Exportable;
    public $jurusan;
    public $kelas;
    public $tgl_mulai;
    public $tgl_selesai;

    public function __construct($jurusan, $kelas, $tgl_mulai, $tgl_selesai){
        $this->jurusan = $jurusan;
        $this->kelas = $kelas;
        $this->tgl_mulai = $tgl_mulai;
        $this->tgl_selesai = $tgl_selesai;
    }

    public function sheets(): array {
        $sheet = [];
        // $start = Carbon::create(2024, 07, 1);  // 1 Januari 2024
        // $end = Carbon::create(2025, 07, 31); // 31 Desember 2024
        $start = Carbon::create($this->tgl_mulai);
        $end = Carbon::create($this->tgl_selesai); // 31 Desember 2024
        $intervalInMonths = $start->diffInMonths($end);

        $date_interval = [];

        while($start->lte($end)) {
            $date_interval[] = [
                'bulan' => $start->format('F'),
                'bulan_in_int' => $start->format('m'),
                'tahun' => $start->year
            ];

            $start->addMonth();
        }
        foreach ($date_interval as $d) {
            $tahun = $d['tahun'];
            $bulan = $d['bulan'];
            $bulan_int = $d['bulan_in_int'];
            $date = $tahun . "-" . $bulan;

            $sheet[] = new RekapAbsenPerSheet($tahun, $bulan, $bulan_int, $this->jurusan, $this->kelas);
        }

        return $sheet;
    }
}
