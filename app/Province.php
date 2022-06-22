<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    function regencies() {
        return $this->hasMany('App\Regency');
    }
}
