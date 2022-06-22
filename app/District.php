<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    function regency() {
        return $this->belongsTo('App\Regency');
    }
}
