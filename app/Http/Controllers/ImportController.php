<?php

namespace App\Http\Controllers;

use App\Exports\TemplateImport;
use App\Imports\DataImport;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Auth::user()->hasRole(['admin']);

        return view('pages.import.index');
    }

    public function template() {
        Auth::user()->hasRole(['admin']);

        return Excel::download(new TemplateImport, 'template.csv');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->hasRole(['admin']);

        Excel::import(new DataImport, request()->file('file'));

        $log = request()->user()->logs()->create(['action' => 'import']);
        $log->save();

        return redirect('/data');
    }
}
