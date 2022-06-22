<?php

namespace App\Exports;

use App\Data;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Data::all();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Jenis Kelamin',
            'TTL',
            'Alamat',
        ];
    }

    public function map($data): array
    {
        return [
            "'".$data->nik,
            $data->name,
            $data->gender == 'male' ? 'Laki-laki' : 'Perempuan',
            $data->birth_city . ', ' . date_format(date_create($data->birth_date), 'd F Y'),
            sprintf('%s, %s, %s, %s', $data->address, $data->district->name, $data->district->regency->name, $data->district->regency->province->name)
        ];
    }
}
