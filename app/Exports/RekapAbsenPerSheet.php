<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Models\Absensi;
use App\Models\Siswa;

class RekapAbsenPerSheet implements FromArray, WithTitle, WithHeadings, WithStyles, WithEvents
{
    // WithHeadings, WithStyles, FromArray,
    public $jurusan;
    public $kelas;
    public $tahun;
    public $bulan;
    public $bulan_int;
    public $b = array();
    public $tanggal;

    public function __construct($tahun, $bulan, $bulan_int, $jurusan, $kelas){
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->bulan_int = $bulan_int;
        $this->jurusan = $jurusan;
        $this->kelas = $kelas;
        $this->tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan_int, $tahun); 
    }

    public function styles(Worksheet $sheet){
        return  [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
        ];

    }

    public function registerEvents(): array {        
        return [
            AfterSheet::class => function($event){
                $lastColumn = Coordinate::stringFromColumnIndex($this->tanggal + 1);                
                $nextColumn = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($lastColumn)+1);
                $lastRow = count($this->b) + 3;
                $columnHadir = Coordinate::stringFromColumnIndex($this->tanggal + 2);
                $columnIzin = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($nextColumn)+1);
                $columnSakit = Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($nextColumn)+2);
                // dd("{$lastColumn}1:{$columnSakit}2");               

                $event->sheet->mergeCells("A1:A3");
                $event->sheet->mergeCells("B1:{$lastColumn}1");
                $event->sheet->mergeCells("B2:{$lastColumn}2");
                $event->sheet->mergeCells("{$columnHadir}1:{$columnSakit}2");
                $event->sheet->setCellValue("A1", "NAMA SISWA");
                $event->sheet->setCellValue("B1", $this->bulan);
                $event->sheet->setCellValue("B2", "Tanggal");
                $event->sheet->setCellValue($nextColumn."1", "Total");
                $event->sheet->setCellValue(Coordinate::stringFromColumnIndex(Coordinate::columnIndexFromString($nextColumn))."3", "Hadir");
                $event->sheet->setCellValue($columnIzin."3", "Izin");
                $event->sheet->setCellValue($columnSakit."3", "Sakit");

                for ($row = 4; $row <= $lastRow; $row++){
                    $event->sheet->setCellValue(
                        "{$columnHadir}{$row}","=COUNTIF(B{$row}:{$lastColumn}{$row}, \"hadir\")"
                    );
                    $event->sheet->setCellValue(
                        "{$columnIzin}{$row}","=COUNTIF(B{$row}:{$lastColumn}{$row}, \"izin\")"
                    );
                    $event->sheet->setCellValue(
                        "{$columnSakit}{$row}","=COUNTIF(B{$row}:{$lastColumn}{$row}, \"sakit\")"
                    );
                }

                // border semua 
                $event->sheet->getStyle("A1:{$columnSakit}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin',
                        ]
                    ]
                ]);

                // Header style
                $event->sheet->getStyle("A1:{$columnSakit}3")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => '4F81BD'],
                    ],
                ]);

                // auto size kolom
                foreach (range('A', $lastColumn) as $col){
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

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

                    if($get_tahun == $this->tahun && $this->bulan == $bulan_in_string){
                        $this->b[$i][$hari_in_int]= $n['status'];
                    }
                }
        }
        sort($this->b);
        return [
            $this->b,
            // [$absen[0]['nama_siswa'], 'hadir'],
            // [$absen[1]['nama_siswa'], 'hadir'],
        ];
    }

    public function headings(): array {
        // $tanggal = cal_days_in_month(CAL_GREGORIAN, $this->bulan_int, $this->tahun); 
        $row1 = [' '];
        $row2 = [' '];
        $row3 = [' '];
        for($i = 1; $i <= $this->tanggal; $i++){                         
            $row3[($i+2)]=$i;
        }
        return [
           $row1,
           $row2,
           $row3
        ];
    }

    public function title(): string
    {
        return "$this->tahun - $this->bulan";
    }
}