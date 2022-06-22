<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
			font-size: 9pt;
		}
	</style>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="white-space: nowrap;">NIK</th>
                <th style="white-space: nowrap;">Nama</th>
                <th style="white-space: nowrap;">Jenis Kelamin</th>
                <th style="white-space: nowrap;">TTL</th>
                <th style="white-space: nowrap;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $data)
            <tr>
                <td>{{ $data->nik }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $data->birth_city . ', ' . date_format(date_create($data->birth_date), 'd F Y') }}</td>
                <td>{{ sprintf('%s, %s, %s, %s', $data->address, $data->district->name, $data->district->regency->name, $data->district->regency->province->name) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
