<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $primaryKey = 'nik';

    protected $fillable = [
        'nik', 'name', 'birth_city', 'birth_date', 'gender', 'district_id', 'address'
    ];

    function district() {
        return $this->belongsTo('App\District');
    }
}
