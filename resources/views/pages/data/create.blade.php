@extends('pages.layouts.master')

@section('title', 'Tambah Data KTP')

@section('content')
    <div class="card">
        <form action="/data" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="birth_city">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birth_city" name="birth_city" value="{{ old('birth_city') }}" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="birth_date">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="gender">Jenis Kelamin</label>
                                <select name="gender" class="form-control" required>
                                    <option value="" hidden>Pilih Jenis Kelamin</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="photo">Foto</label><br>
                            <div class="text-center">
                                <img src="" alt="Foto" class="img-thumbnail" id="ct-photo" style="max-height: 150px;"/>
                            </div>
                            <input type="file" class="form-control imgInput mt-1 border-0" data-img="ct-photo" name="photo" accept="image/*" required>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="province">Provinsi</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="" hidden>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="regency">Kabupaten</label>
                                <select name="regency" id="regency" class="form-control" required>
                                    <option value="" hidden>Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="district">Kecamatan</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="" hidden>Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
    $(document).on("change", ".imgInput", function() {
        var target = '#' + $(this).attr("data-img")
        loadPreview(this, target)
    })

    function loadPreview(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader()

            reader.onload = function (e) {
                $(target).attr('src', e.target.result)
            }

            reader.readAsDataURL(input.files[0])
        }
    }

    $('#province').change(function(){
        $.get('/province/'+$(this).val()+'/regencies', function(data) {
            option = '<option value="" hidden>Pilih Kabupaten</option>'+data
            $('#regency').html(option)
        })
    })

    $('#regency').change(function(){
        $.get('/regency/'+$(this).val()+'/districts', function(data) {
            option = '<option value="" hidden>Pilih Kecamatan</option>'+data
            $('#district').html(option)
        })
    })
</script>
@endpush
