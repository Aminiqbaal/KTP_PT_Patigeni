@extends('pages.layouts.master')

@section('title', 'Data KTP')

@section('content')
    <div>
        <a href="/export-csv" class="btn btn-sm mb-2 btn-success text-white"><i class="fas fa-file-csv"></i> Ekspor CSV</a>
        <a href="/export-pdf" class="btn btn-sm mb-2 btn-success text-white"><i class="fas fa-file-pdf"></i> Ekspor PDF</a>
    </div>
    <div class="card">
        @if(Auth::user()->role == 'admin')
        <div class="card-header">
            <a href="/data/create" class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Tambah</a>
        </div>
        @endif
        <div class="card-body">
            <table id="list-data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div><!-- /.card-body -->
    </div>
@endsection

@push('js')
    <script>
        var MyTable = $('#list-data').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('data.getData')}}",
            columns: [
                { data: 'nik' },
                { data: 'name' },
                { data: 'tl' },
                { data: 'address' },
                { data: 'photo' },
                { data: 'aksi' },
            ],
            columnDefs: [
                { className: 'align-middle', targets: [0,1,2,3,4] },
                { className: 'text-center align-middle', targets: [5] },
            ]
        })

        $('div.dataTables_filter input').focus()
    </script>
@endpush
