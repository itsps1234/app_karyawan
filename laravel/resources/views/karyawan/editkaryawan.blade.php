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
                                <img class="profile-user-img img-fluid img-circle" src="{{ url('assets/img/foto_default.jpg') }}" alt="User profile picture">
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
                          <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="settings">
                                <form method="post" action="{{ url('/karyawan/proses-edit/'.$karyawan->id) }}" enctype="multipart/form-data">
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
                                            ]);
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
                                            ]);
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
                                            <label for="jabatan_id">Jabatan</label>
                                            <select name="jabatan_id" id="jabatan_id" class="form-control selectpicker" data-live-search="true">
                                                @foreach ($data_jabatan as $dj)
                                                    @if(old('jabatan_id', $karyawan->jabatan_id) == $dj->id)
                                                    <option value="{{ $dj->id }}" selected>{{ $dj->nama_jabatan }}</option>
                                                    @else
                                                    <option value="{{ $dj->id }}">{{ $dj->nama_jabatan }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('jabatan_id')
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
                                            ]);
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
