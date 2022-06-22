<?php

namespace App\Http\Controllers;

use App\Data;
use App\District;
use App\Exports\DataExport;
use App\Province;
use App\Regency;
use Illuminate\Http\Request;
use Auth;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->hasRole(['admin', 'user']);

        return view('pages.data.index');
    }

    function getData(Request $request) {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Data::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Data::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Data::orderBy($columnName,$columnSortOrder)
            ->where('data.name', 'like', '%' .$searchValue . '%')
            ->select('data.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach($records as $record){
            $photo = file_exists(public_path('uploads/\photo\\'.$record->photo)) ? asset('uploads/photo/' . $record->photo) : $record->photo;

            $data_arr[] = array(
                'nik' => $record->nik,
                'name' => $record->name,
                'tl' => \Carbon\Carbon::parse($record->birth_date)->diffInYears() . ' tahun',
                'address' => $record->address,
                'photo' => '<img src="'.$photo.'" alt="Foto" class="img-thumbnail" id="ct-photo" style="max-height: 150px;"/>',
                'aksi' => '
                    <a href="/data/'.$record->nik.'/edit" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>
                    <form action="/data/'.$record->nik.'" method="POST" style="display: inline;">
                        '.csrf_field().'
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm" onclick="return confirm(`Apakah Anda yakin ingin menghapus data ini?`)"><i class="far fa-trash-alt"></i> Delete</button>
                    </form>'
            );
        }

        $response = array(
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->hasRole(['admin']);

        $provinces = Province::all();
        return view('pages.data.create', compact('provinces'));
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

        $request->validate([
            'name' => ['required'],
            'birth_city' => ['required'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'photo' => ['required'],
            'district' => ['required'],
            'address' => ['required'],
        ]);

        $nik = $this->generate_nik($request->district, $request->birth_date, $request->gender);

        $file = $request->file('photo');
        $filename = $nik . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("uploads\/photo\\"), $filename);

        $data = new Data();
        $data['nik'] = $nik;
        $data['name'] = $request->name;
        $data['birth_city'] = $request->birth_city;
        $data['birth_date'] = $request->birth_date;
        $data['gender'] = $request->gender;
        $data['district_id'] = $request->district;
        $data['address'] = $request->address;
        $data['photo'] = $filename;

        if($data->save()) session()->flash('toast', ['success', 'Data KTP berhasil ditambahkan']);
        else session()->flash('toast', ['error', 'Data KTP gagal ditambahkan']);

        return redirect('/data');
    }

    static function generate_nik($district_id, $birth_date, $gender) {
        $result = $district_id;
        $birth = date_create($birth_date);
        $birth_date = (int)date_format($birth, 'd');
        if($gender == 'female'){
            $birth_date += 40;
        }
        $result .= str_pad($birth_date, 2, '0', STR_PAD_LEFT) . date_format($birth, 'my');

        $similar_count = Data::where('nik', 'like', "$result%")->count();
        $result .= str_pad($similar_count + 1, 4, '0', STR_PAD_LEFT);

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function edit(Data $data)
    {
        Auth::user()->hasRole(['admin']);

        $provinces = Province::all();
        $regencies = Regency::where('province_id', $data->district->regency->province->id)->get();
        $districts = District::where('regency_id', $data->district->regency->id)->get();
        return view('pages.data.edit', compact('data', 'provinces', 'regencies', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Data $data)
    {
        Auth::user()->hasRole(['admin']);

        $request->validate([
            'name' => ['required'],
            'birth_city' => ['required'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'district' => ['required'],
            'address' => ['required'],
        ]);

        $nik = $this->generate_nik($request->district, $request->birth_date, $request->gender);

        if($request->has('photo')) {
            $file = $request->file('photo');
            $filename = $nik . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("uploads\/photo\\"), $filename);
            $data->photo = $filename;
        }

        $data->nik = $nik;
        $data->name = $request->name;
        $data->birth_city = $request->birth_city;
        $data->birth_date = $request->birth_date;
        $data->gender = $request->gender;
        $data->district_id = $request->district;
        $data->address = $request->address;

        if($data->save()) session()->flash('toast', ['success', 'Data KTP berhasil diubah']);
        else session()->flash('toast', ['error', 'Data KTP gagal diubah']);

        return redirect('/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Data $data)
    {
        Auth::user()->hasRole(['admin']);

        if($data->photo)
            if(file_exists(public_path("uploads/\photo\\$data->photo")))
                unlink(public_path("uploads/\photo\\$data->photo"));

        if($data->delete()) session()->flash('toast', ['success', 'Data KTP berhasil dihapus']);
        else session()->flash('toast', ['error', 'Data KTP gagal dihapus']);

        return redirect('/data');
    }

    public function export_csv() {
        Auth::user()->hasRole(['admin', 'user']);

        $log = request()->user()->logs()->create(['action' => 'export-csv']);
        $log->save();

        return Excel::download(new DataExport, 'ktp.csv');
    }

    public function export_pdf() {
        Auth::user()->hasRole(['admin', 'user']);

        $data = Data::all();

        $log = request()->user()->logs()->create(['action' => 'export-pdf']);
        $log->save();

        $pdf = PDF::loadview('pages.data.pdf', compact('data'));
        return $pdf->download('ktp');
    }
}
