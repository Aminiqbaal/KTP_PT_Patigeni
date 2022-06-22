@extends('pages.layouts.master')

@section('title', 'Impor Data KTP')

@section('content')
    <div class="card col-6">
        <div class="card-body">
            <a href="/template" class="btn btn-success text-white"><i class="fas fa-file-csv"></i> Download Template Import CSV</a>
            <hr>
            <form action="/import" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Upload File</label><br>
                    <input type="file" class="form-control mt-1 border-0" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div><!-- /.card-body -->
    </div>
@endsection

@push('js')
    <script>
        var MyTable = $('#list-data').dataTable()

        $('div.dataTables_filter input').focus()
    </script>
@endpush
