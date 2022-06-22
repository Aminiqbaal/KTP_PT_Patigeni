<?php

namespace App\Http\Controllers;

use App\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    function regencies(Province $province) {
        $collection = $province->regencies;
        return view('pages.list', compact('collection'));
    }
}
