@extends('pages.layouts.master')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="list-data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $key => $log)
                    <tr>
                        <td class="align-middle">{{ $key + 1 }}</td>
                        <td class="align-middle">{{ $log->user->name }}</td>
                        <td class="align-middle">{{ $log->user->username }}</td>
                        <td class="align-middle">{{ $log->action }}</td>
                        <td class="align-middle">{{ date_format(date_create($log->created_at), 'd F Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /.card-body -->
    </div>
@endsection

@push('js')
    <script>
        var MyTable = $('#list-data').dataTable()

        $('div.dataTables_filter input').focus()
    </script>
@endpush
