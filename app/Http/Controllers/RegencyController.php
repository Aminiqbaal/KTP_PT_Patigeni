<?php

namespace App\Http\Controllers;

use App\Regency;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    function districts(Regency $regency) {
        $collection = $regency->districts;
        return view('pages.list', compact('collection'));
    }
}
