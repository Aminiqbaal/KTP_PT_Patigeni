<?php

namespace App\Imports;

use App\Data;
use App\District;
use App\Http\Controllers\DataController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class DataImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach($rows->slice(2) as $row){
            $district_id = District::where('name', $row[6])->first()->id;

            $nik = DataController::generate_nik($district_id, $row[3], $row[1]);

            Data::create([
                'nik' => $nik,
                'name' => $row[0],
                'gender' => $row[1],
                'birth_city' => $row[2],
                'birth_date' => date_format(date_create($row[3]), 'Y-m-d'),
                'district_id' => $district_id,
                'address' => $row[7],
            ]);
        }
    }
}
