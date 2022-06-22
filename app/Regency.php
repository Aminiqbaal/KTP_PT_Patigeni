<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    function districts() {
        return $this->hasMany('App\District');
    }

    function province() {
        return $this->belongsTo('App\Province');
    }
}
