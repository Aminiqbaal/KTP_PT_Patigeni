<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateImport implements WithHeadings
{
    public function headings(): array
    {
        return [
            [
                'Nama',
                'Jenis Kelamin (male/female)',
                'Tempat Lahir',
                'Tanggal Lahir (mm/dd/yyyy)',
                'Provinsi',
                'Kabupaten',
                'Kecamatan',
                'Alamat',
            ],
            [
                'Anton',
                'male',
                'Malang',
                '12/31/1999',
                'JAWA TIMUR',
                'KOTA MALANG',
                'Lowokwaru',
                'Jalan jalan no 123',
                'Ini baris contoh, tidak akan ikut dimasukkan dalam data',
            ],
        ];
    }
}
