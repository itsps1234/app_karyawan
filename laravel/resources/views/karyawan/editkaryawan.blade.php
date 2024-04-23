@extends('layouts.dashboard')
@section('isi')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-outline card-primary">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($karyawan->foto_karyawan == null)
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/img/foto_default.jpg') }}" alt="User profile picture">
                        @else
                        <img class="profile-user-img img-fluid img-circle" src="{{ url('storage/'.$karyawan->foto_karyawan) }}" alt="User profile picture">
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{ $karyawan->name }}</h3>

                    <p class="text-muted text-center">{{ $karyawan->Jabatan->nama_jabatan }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $karyawan->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right">{{ $karyawan->username }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Telepon</b> <a class="float-right">{{ $karyawan->telepon }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-9">
            <div class="card card-outline card-primary">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#depaertemen" data-toggle="tab">Lihat Departemen</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                            <form method="post" action="{{ url('/karyawan/proses-edit/'.$karyawan->id.'/'.$holding) }}" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-row">
                                    <div class="col">
                                        <label for="name">Nama Karyawan</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name', $karyawan->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="foto_karyawan" class="form-label">Foto Karyawan</label>
                                        <input class="form-control @error('foto_karyawan') is-invalid @enderror" type="file" id="foto_karyawan" name="foto_karyawan">
                                        @error('foto_karyawan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="foto_karyawan_lama" value="{{ $karyawan->foto_karyawan }}">
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $karyawan->email) }}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="telepon">Nomor Telfon</label>
                                        <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $karyawan->telepon) }}">
                                        @error('telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control @error('fullname') is-invalid @enderror" id="fullname" name="fullname" value="{{ old('fullname', $karyawan->fullname) }}">
                                        @error('fullname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $karyawan->username) }}">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="password" value="{{ $karyawan->password }}">
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="datetime" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $karyawan->tgl_lahir) }}">
                                        @error('tgl_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <?php $gender = array(
                                            [
                                                "gender" => "Laki-Laki"
                                            ],
                                            [
                                                "gender" => "Perempuan"
                                            ]
                                        );
                                        ?>
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control selectpicker" data-live-search="true">
                                            @foreach ($gender as $g)
                                            @if(old('gender', $karyawan->gender) == $g["gender"])
                                            <option value="{{ $g["gender"] }}" selected>{{ $g["gender"] }}</option>
                                            @else
                                            <option value="{{ $g["gender"] }}">{{ $g["gender"] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('gender')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="tgl_join">Tanggal Masuk Perusahaan</label>
                                        <input type="datetime" class="form-control @error('tgl_join') is-invalid @enderror" id="tgl_join" name="tgl_join" value="{{ old('tgl_join', $karyawan->tgl_join) }}">
                                        @error('tgl_join')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <?php $sNikah = array(
                                            [
                                                "status" => "Lajang"
                                            ],
                                            [
                                                "status" => "Menikah"
                                            ]
                                        );
                                        ?>
                                        <label for="status_nikah">Status Pernikahan</label>
                                        <select name="status_nikah" id="status_nikah" class="form-control selectpicker" data-live-search="true">
                                            @foreach ($sNikah as $s)
                                            @if(old('status_nikah', $karyawan->status_nikah) == $s["status"])
                                            <option value="{{ $s["status"] }}" selected>{{ $s["status"] }}</option>
                                            @else
                                            <option value="{{ $s["status"] }}">{{ $s["status"] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('status_nikah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="departemen_id">Departemen</label>
                                        <select name="departemen_id" id="id_departemen" class="form-control selectpicker" data-live-search="true">
                                            @foreach ($data_departemen as $dj)
                                            @if(old('departemen_id', $karyawan->dept_id) == $dj->id)
                                            <option value="{{ $dj->id }}" selected>{{ $dj->nama_departemen }}</option>
                                            @else
                                            <option value="{{ $dj->id }}">{{ $dj->nama_departemen }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('departemen_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <?php $is_admin = array(
                                            [
                                                "is_admin" => "admin"
                                            ],
                                            [
                                                "is_admin" => "user"
                                            ]
                                        );
                                        ?>
                                        <label for="is_admin">Level User</label>
                                        <select name="is_admin" id="is_admin" class="form-control selectpicker" data-live-search="true">
                                            @foreach ($is_admin as $a)
                                            @if(old('is_admin', $karyawan->is_admin) == $a["is_admin"])
                                            <option value="{{ $a["is_admin"] }}" selected>{{ $a["is_admin"] }}</option>
                                            @else
                                            <option value="{{ $a["is_admin"] }}">{{ $a["is_admin"] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('is_admin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <?php
                                    $divisi = App\Models\Divisi::Where('dept_id', $karyawan->dept_id)->get();
                                    $jabatan = App\Models\Jabatan::Where('divisi_id', $karyawan->divisi_id)->get();
                                    // echo $kab;
                                    ?>
                                    <table class="table table-bordered" id="dynamicTable">
                                        <tr>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select name="addmore[0][divisi_id]" id="id_divisi" class="form-control" data-live-search="true">
                                                    @foreach ($jabatan as $jabatan)
                                                    <option value="{{$jabatan->id}}" {{($jabatan->id == $karyawan->jabatan_id) ? 'selected' : ''}}>{{$jabatan->nama_jabatan}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="addmore[0][jabatan_id]" id="id_jabatan" class="form-control" data-live-search="true">
                                                    @foreach ($divisi as $divisi)
                                                    <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><button type="button" name="add" id="add" class="btn btn-sm btn-success">Add</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="kontrak_kerja">Kontrak Kerja</label>
                                        <input type="text" class="form-control" readonly id="kontrak_kerja" name="kontrak_kerja" value="@if($holding =='sp')CV. SUMBER PANGAN @elseif($holding =='sps') PT. SURYA PANGAN SEMESTA @elseif($holding =='sip') CV. SURYA INTI PANGAN  @endif">

                                    </div>
                                    <div class="col">
                                        <?php $penempatan_kerja = array(
                                            [
                                                "penempatan_kerja" => "CV. SUMBER PANGAN"
                                            ],
                                            [
                                                "penempatan_kerja" => "PT. SURYA PANGAN SEMESTA"
                                            ],
                                            [
                                                "penempatan_kerja" => "CV. SURYA INTI PANGAN"
                                            ]
                                        );
                                        ?>
                                        <label for="penempatan_kerja">Penempatan Kerja</label>
                                        <select class="form-control @error('penempatan_kerja') is-invalid @enderror" id="penempatan_kerja" name="penempatan_kerja">
                                            <option selected disabled value=""> Pilih Lokasi Penempatan</option>
                                            @foreach ($penempatan_kerja as $a)
                                            @if(old('penempatan_kerja',$karyawan->penempatan_kerja) == $a["penempatan_kerja"])
                                            <option value="{{ $a["penempatan_kerja"] }}" selected>{{ $a["penempatan_kerja"] }}</option>
                                            @else
                                            <option value="{{ $a["penempatan_kerja"] }}">{{ $a["penempatan_kerja"] }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('penempatan_kerja')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="cuti_dadakan">Cuti Dadakan</label>
                                        <input type="number" class="form-control @error('cuti_dadakan') is-invalid @enderror" id="cuti_dadakan" name="cuti_dadakan" value="{{ old('cuti_dadakan', $karyawan->cuti_dadakan) }}">
                                        @error('cuti_dadakan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="cuti_bersama">Cuti Bersama</label>
                                        <input type="number" class="form-control @error('cuti_bersama') is-invalid @enderror" id="cuti_bersama" name="cuti_bersama" value="{{ old('cuti_bersama', $karyawan->cuti_bersama) }}">
                                        @error('cuti_bersama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="cuti_menikah">Cuti Menikah</label>
                                        <input type="number" class="form-control @error('cuti_menikah') is-invalid @enderror" id="cuti_menikah" name="cuti_menikah" value="{{ old('cuti_menikah', $karyawan->cuti_menikah) }}">
                                        @error('cuti_menikah')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="cuti_diluar_tanggungan">Cuti Diluar Tanggungan</label>
                                        <input type="number" class="form-control @error('cuti_diluar_tanggungan') is-invalid @enderror" id="cuti_diluar_tanggungan" name="cuti_diluar_tanggungan" value="{{ old('cuti_diluar_tanggungan', $karyawan->cuti_diluar_tanggungan) }}">
                                        @error('cuti_diluar_tanggungan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="cuti_khusus">Cuti Khusus</label>
                                        <input type="number" class="form-control @error('cuti_khusus') is-invalid @enderror" id="cuti_khusus" name="cuti_khusus" value="{{ old('cuti_khusus', $karyawan->cuti_khusus) }}">
                                        @error('cuti_khusus')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="cuti_melahirkan">Cuti Melahirkan</label>
                                        <input type="number" class="form-control @error('cuti_melahirkan') is-invalid @enderror" id="cuti_melahirkan" name="cuti_melahirkan" value="{{ old('cuti_melahirkan', $karyawan->cuti_melahirkan) }}">
                                        @error('cuti_melahirkan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="izin_telat">Izin Telat</label>
                                        <input type="number" class="form-control @error('izin_telat') is-invalid @enderror" id="izin_telat" name="izin_telat" value="{{ old('izin_telat', $karyawan->izin_telat) }}">
                                        @error('izin_telat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="izin_pulang_cepat">Izin Pulang Cepat</label>
                                        <input type="number" class="form-control @error('izin_pulang_cepat') is-invalid @enderror" id="izin_pulang_cepat" name="izin_pulang_cepat" value="{{ old('izin_pulang_cepat', $karyawan->izin_pulang_cepat) }}">
                                        @error('izin_pulang_cepat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <label for="alamat">Alamat</label>
                                <?php
                                if ($karyawan->provinsi == NULL) {
                                    $data_provinsi = App\Models\Provincies::Where('code', $karyawan->provinsi)->get();
                                }
                                // echo $data_provinsi;
                                $data_kabupaten = App\Models\Cities::Where('code', $karyawan->kabupaten)->get();
                                $data_kecamatan = App\Models\District::Where('code', $karyawan->kecamatan)->get();
                                $data_desa = App\Models\Village::Where('code', $karyawan->desa)->get();
                                ?>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="provinsi">Provinsi</label>
                                        <select class="form-control" id="id_provinsi" name="provinsi">
                                            <option value=""> Pilih Provinsi </option>
                                            @foreach ($data_provinsi as $provinsi)
                                            <option value="{{$provinsi->code}}" {{($provinsi->code == $karyawan->provinsi) ? 'selected' : ''}}>{{$provinsi->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="kabupaten">Kabupaten / Kota</label>
                                        <select class="form-control" id="id_kabupaten" name="kabupaten">
                                            <option value=""> Pilih Kabupaten / Kota</option>
                                            @foreach ($data_kabupaten as $kabupaten)
                                            <option value="{{$kabupaten->code}}" {{($kabupaten->code == $karyawan->kabupaten) ? 'selected' : ''}}>{{$kabupaten->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('kabupaten')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="kecamatan">kecamatan</label>
                                        <select class="form-control @error('kecamatan') is-invalid @enderror" id="id_kecamatan" name="kecamatan">
                                            <option value=""> Pilih kecamatan</option>
                                            @foreach ($data_kecamatan as $kecamatan)
                                            <option value="{{$kecamatan->code}}" {{($kecamatan->code == $karyawan->kecamatan) ? 'selected' : ''}}>{{$kecamatan->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('kecamatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="desa">Desa</label>
                                        <select class="form-control @error('desa') is-invalid @enderror" id="id_desa" name="desa">
                                            <option value=""> Pilih Desa</option>
                                            @foreach ($data_desa as $desa)
                                            <option value="{{$desa->code}}" {{($desa->code == $karyawan->desa) ? 'selected' : ''}}>{{$desa->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('desa')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form">
                                    <div class="col">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $karyawan->alamat) }}">
                                        @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection
@section('js')
<script type="text/javascript">
    var i = 0;

    $("#add").click(function() {

        ++i;
        let id_departemen = $('#id_departemen').val();
        // console.log(id_departemen);
        $.ajax({
            type: 'GET',
            url: "{{url('karyawan/get_divisi')}}",
            data: {
                id_departemen: id_departemen
            },
            cache: false,

            success: function(msg) {
                // $('#id_divisi').html(msg);
                $('#dynamicTable').append('<tr><td><select name="addmore[' + i + '][divisi_id]" id="addmore[' + i + ']id_divisi" class="select_divisi' + i + ' form-control" data-live-search="true">' + msg + '</select></td><td><select name="addmore[' + i + '][jabatan_id]" id="addmore[' + i + ']id_jabatan" class="select_jabatan' + i + ' form-control" data-live-search="true"></select></td><td><button type="button" class="btn btn-sm btn-danger remove-tr">Remove</button></td></tr>');
                var get = 'addmore[' + i + ']id_divisi';
            },
            error: function(data) {
                console.log('error:', data)
            },

        })

        // return get;

        // console.log('addmore[1]id_divisi');
        $(document).on('change', '.select_divisi' + i + '', function() {
            console.log('OK');
            let id_divisi = $(this).val();
            console.log(id_divisi);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    // console.log(msg);
                    $('.select_jabatan' + i + '').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    });
    $('#id_departemen').on('change', function() {
        let id_departemen = $('#id_departemen').val();
        console.log(id_departemen);
        $.ajax({
            type: 'GET',
            url: "{{url('karyawan/get_divisi')}}",
            data: {
                id_departemen: id_departemen
            },
            cache: false,

            success: function(msg) {
                // console.log(msg);
                // $('#id_divisi').html(msg);
                $('#id_divisi').html(msg);
            },
            error: function(data) {
                console.log('error:', data)
            },

        })
    })
    $('#id_divisi').on('change', function() {
        let id_divisi = $('#id_divisi').val();
        console.log(id_divisi);
        $.ajax({
            type: 'GET',
            url: "{{url('karyawan/get_jabatan')}}",
            data: {
                id_divisi: id_divisi
            },
            cache: false,

            success: function(msg) {
                $('#id_jabatan').html(msg);
            },
            error: function(data) {
                console.log('error:', data)
            },

        })
    })
</script>
@endsection