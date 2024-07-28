<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Absensi;
use App\Models\Siswa;

class RekapAbsenPerSheet implements FromArray, WithTitle, WithHeadings
{
    // WithHeadings, WithStyles, FromArray,
    public $jurusan;
    public $kelas;
    public $tahun;
    public $bulan;
    public $bulan_int;
    public $b = array();

    public function __construct($tahun, $bulan, $bulan_int, $jurusan, $kelas){
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->bulan_int = $bulan_int;
        $this->jurusan = $jurusan;
        $this->kelas = $kelas;
    }

    // public function __construct($jurusan, $kelas, $tgl_mulai, $tgl_selesai) {
    //     $this->jurusan = $jurusan;
    //     $this->kelas = $kelas;
    //     $this->tgl_mulai = $tgl_mulai;
    //     $this->tgl_selesai = $tgl_selesai;  
    // }

    public function array(): array {
        $siswa = Siswa::where('id_jurusan', $this->jurusan)->where('id_kelas', $this->kelas)->select('*')->get();
        
        for ($i=0; $i < count($siswa); $i++) { 
            $this->b[$i] = array();
            $this->b[$i]['nama_siswa']= $siswa[$i]['nama_siswa'];
            $absen = Absensi::where('id_siswa', $siswa[$i]['id'])->get();

            $tanggal = cal_days_in_month(CAL_GREGORIAN, $this->bulan_int, $this->tahun);
 
            for ($k=1; $k <= $tanggal; $k++) {
                if(strlen((String)$k) == 1){
                    $k = sprintf("%02d", $k);
                }
                $this->b[$i][$k]= "";
            }

                foreach ($absen as $n) {
                    $get_tahun =  date('Y', strtotime($n['tanggal']));
                    $hari_in_int = date('d', strtotime($n['tanggal']));
                    $bulan_in_string = date('F', strtotime($n['tanggal']));
                    // dd($get_tahun, $bulan_in_string, $this->bulan, $hari_in_int);

                    if($get_tahun == $this->tahun && $this->bulan == $bulan_in_string){
                        $this->b[$i][$hari_in_int]= $n['status'];
                    }
                }
           
        //     for ($j=0; $j < (count($absen)); $j++) {
        //         $date = date('d', strtotime($absen[$j]['tanggal']));
                
        //             $this->b[$i][$date]= $absen[$j]['tanggal'];
                
            
        // }
    
        }
        sort($this->b);
        // dd($this->b);
        return [
            $this->b,
            // [$absen[0]['nama_siswa'], 'hadir'],
            // [$absen[1]['nama_siswa'], 'hadir'],
        ];
    }

    // public function getNama($id_siswa){
    //     $nama = Siswa::where('id', $id_siswa)->select('nama_siswa')->first();
    //     return $nama;
    // }

    public function headings(): array {
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $this->bulan_int, $this->tahun);
        $heading =array('Nama Siswa');
        for($i = 1; $i <= $tanggal; $i++){
            $heading[($i+2)]=$i;
        }
        return $heading;
    }

    // public function styles(Worksheet $sheet) {
    //     // $sheet->mergeCells('M2:R20');
    // }

    public function title(): string
    {
        return "$this->tahun - $this->bulan";
    }
}
