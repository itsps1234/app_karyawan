@extends('admin.layouts.dashboard')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
@endsection
@section('isi')
@include('sweetalert::alert')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">KARYAWAN /</span> DETAIL KARYAWAN</h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="mdi mdi-account-outline mdi-20px me-1"></i>{{$karyawan->fullname}}</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h4 class="card-header">Detail Profil</h4>
                <!-- Account -->
                <form method="post" action="{{ url('/karyawan/proses-edit/'.$karyawan->id.'/'.$holding) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @if($karyawan->foto_karyawan == null)
                            <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="template_foto_karyawan" />
                            @else
                            <img src="{{Storage::url('foto_karyawan/'.$karyawan->foto_karyawan)}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                            @endif
                            <div class="button-wrapper">
                                <label for="foto_karyawan" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto</span>
                                    <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                    <input type="text" name="foto_karyawan_lama" value="{{ $karyawan->foto_karyawan }}">
                                    <input type="file" name="foto_karyawan" id="foto_karyawan" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="btn btn-outline-danger account-image-reset mb-3">
                                    <i class="mdi mdi-reload d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2 mt-1">

                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('nik') is-invalid @enderror" type="number" id="nik" name="nik" value="{{old('nik', $karyawan->nik)}}" autofocus />
                                    <label for="nik">NIK</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('npwp') is-invalid @enderror" type="number" id="npwp" name="npwp" value="{{old('npwp', $karyawan->npwp)}}" />
                                    <label for="npwp">NPWP</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $karyawan->name) }}">
                                    <label for="name">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('fullname') is-invalid @enderror" type="text" name="fullname" id="fullname" value="{{ old('fullname', $karyawan->fullname)}}" />
                                    <label for="fullname">Fullname</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $karyawan->email) }}">
                                    <label for="email">E-mail</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $karyawan->telepon) }}">
                                    <label for="telepon">Telepon</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir',$karyawan->tempat_lahir) }}">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="date" id="tgl_lahir" value="{{$karyawan->tgl_lahir}}" name="tgl_lahir" placeholder="Tanggal Lahir" />
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control @error('tgl_join') is-invalid @enderror" id="tgl_join" name="tgl_join" value="{{ old('tgl_join', $karyawan->tgl_join) }}">
                                    <label for="tgl_join">Tanggal Join Perusahaan</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $karyawan->username) }}">
                                    <input type="hidden" name="password" value="{{ $karyawan->password }}">
                                    <label for="username">Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="motto" name="motto" value="{{old('motto', $karyawan->motto) }}" placeholder="Motto" />
                                    <label for="motto">Motto</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <?php $gender = array(
                                        [
                                            "gender" => "Laki-Laki"
                                        ],
                                        [
                                            "gender" => "Perempuan"
                                        ]
                                    );
                                    ?>
                                    <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                                        @foreach ($gender as $g)
                                        @if(old('gender', $karyawan->gender) == $g["gender"])
                                        <option value="{{ $g["gender"] }}" selected>{{ $g["gender"] }}</option>
                                        @else
                                        <option value="{{ $g["gender"] }}">{{ $g["gender"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="gender">Kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <?php $sNikah = array(
                                        [
                                            "status" => "Lajang"
                                        ],
                                        [
                                            "status" => "Menikah"
                                        ]
                                    );
                                    ?>
                                    <select name="status_nikah" id="status_nikah" class="form-control selectpicker" data-live-search="true">
                                        @foreach ($sNikah as $s)
                                        @if(old('status_nikah', $karyawan->status_nikah) == $s["status"])
                                        <option value="{{ $s["status"] }}" selected>{{ $s["status"] }}</option>
                                        @else
                                        <option value="{{ $s["status"] }}">{{ $s["status"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="status_nikah">Status Nikah</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <?php $bank = array(
                                        [
                                            "kode_bank" => "BBRI",
                                            "bank" => "BANK RAKYAT INDONESIA (BRI)"
                                        ],
                                        [
                                            "kode_bank" => "BBCA",
                                            "bank" => "BANK CENTRAL ASIA (BCA)"
                                        ],
                                        [
                                            "kode_bank" => "BOCBC",
                                            "bank" => "BANK OCBC"
                                        ]
                                    );
                                    ?>
                                    <select name="nama_bank" id="nama_bank" onchange="bankCheck(this);" class="form-control  @error('nama_bank') is-invalid @enderror">
                                        <option value="">Pilih Bank</option>
                                        @foreach ($bank as $bank)
                                        @if(old('nama_bank', $karyawan->nama_bank) == $bank['kode_bank']) <option value="{{ $bank['kode_bank'] }}" selected>{{ $bank['bank'] }}</option>
                                        @else
                                        <option value="{{ $bank['kode_bank'] }}">{{ $bank['bank'] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="nama_bank">Nama Bank</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control  @error('nomor_rekening') is-invalid @enderror" id="nomor_rekening" name="nomor_rekening" value="{{old('nomor_rekening', $karyawan->nomor_rekening) }}" placeholder="Nomor Rekening" />
                                    <label for="nomor_rekening">Nomor Rekening</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="departemen_id" id="id_departemen" class="form-control @error('departemen_id') is-invalid @enderror">
                                        @foreach ($data_departemen as $dj)
                                        @if(old('departemen_id', $karyawan->dept_id) == $dj->id)
                                        <option value="{{ $dj->id }}" selected>{{ $dj->nama_departemen }}</option>
                                        @else
                                        <option value="{{ $dj->id }}">{{ $dj->nama_departemen }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="id_departemen">Departemen</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $data_divisi = App\Models\Divisi::Where('dept_id', $karyawan->dept_id)->get();
                                // echo $kec;
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="divisi_id" id="id_divisi" class="form-control @error('divisi_id') is-invalid @enderror">
                                        @foreach ($data_divisi as $divisi)
                                        <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_divisi">Divisi</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                $data_jabatan = App\Models\Jabatan::Where('divisi_id', $karyawan->divisi_id)->get();
                                $data_jabatan1 = App\Models\Jabatan::Where('divisi_id', $karyawan->divisi1_id)->get();
                                $data_jabatan2 = App\Models\Jabatan::Where('divisi_id', $karyawan->divisi2_id)->get();
                                $data_jabatan3 = App\Models\Jabatan::Where('divisi_id', $karyawan->divisi3_id)->get();
                                $data_jabatan4 = App\Models\Jabatan::Where('divisi_id', $karyawan->divisi4_id)->get();
                                // echo $kec;
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="jabatan_id" id="id_jabatan" class="form-control @error('jabatan_id') is-invalid @enderror">
                                        @foreach ($data_jabatan as $jabatan)
                                        <option value="{{$jabatan->id}}" {{($jabatan->id == $karyawan->jabatan_id) ? 'selected' : ''}}>{{$jabatan->nama_jabatan}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_jabatan">Jabatan</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="accordion mt-3" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                                Jika Karyawan Memiliki Lebih Dari 1 Jabatan
                                            </button>
                                        </h2>

                                        <div id="accordionOne" class="accordion-collapse collapse @if($karyawan->divisi1_id=='')@else show @endif" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row g-2">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="divisi1_id" id="id_divisi1" class="form-control">
                                                                <option disabled selected value="">Pilih Divisi</option>
                                                                @foreach ($data_divisi as $divisi)
                                                                <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi1_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_divisi1">Divisi 2</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="jabatan1_id" id="id_jabatan1" class="form-control">
                                                                @foreach ($data_jabatan1 as $jabatan)
                                                                <option value="{{$jabatan->id}}" {{($jabatan->id == $karyawan->jabatan1_id) ? 'selected' : ''}}>{{$jabatan->nama_jabatan}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_jabatan1">Jabatan 2</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 mt-2">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="divisi2_id" id="id_divisi2" class="form-control">
                                                                <option disabled selected value="">Pilih Divisi</option>
                                                                @foreach ($data_divisi as $divisi)
                                                                <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi2_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_divisi2">Divisi 3</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="jabatan2_id" id="id_jabatan2" class="form-control">
                                                                @foreach ($data_jabatan2 as $jabatan)
                                                                <option value="{{$jabatan->id}}" {{($jabatan->id == $karyawan->jabatan2_id) ? 'selected' : ''}}>{{$jabatan->nama_jabatan}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_jabatan2">Jabatan 3</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 mt-2">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="divisi3_id" id="id_divisi3" class="form-control">
                                                                <option disabled selected value="">Pilih Divisi</option>
                                                                @foreach ($data_divisi as $divisi)
                                                                <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi3_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_divisi3">Divisi 4</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="jabatan3_id" id="id_jabatan3" class="form-control">
                                                                @foreach ($data_jabatan3 as $jabatan)
                                                                <option value="{{$jabatan->id}}" {{($jabatan->id == $karyawan->jabatan3_id) ? 'selected' : ''}}>{{$jabatan->nama_jabatan}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_jabatan3">Jabatan 4</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 mt-2">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="divisi4_id" id="id_divisi4" class="form-control">
                                                                <option disabled selected value="">Pilih Divisi</option>
                                                                @foreach ($data_divisi as $divisi)
                                                                <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi4_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_divisi4">Divisi 5</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="jabatan4_id" id="id_jabatan4" class="form-control">
                                                                @foreach ($data_jabatan4 as $jabatan)
                                                                <option value="{{$jabatan->id}}" {{($jabatan->id == $karyawan->jabatan4_id) ? 'selected' : ''}}>{{$jabatan->nama_jabatan}}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for=" id_jabatan4">Jabatan 5</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" readonly value="@if($holding =='sp')CV. SUMBER PANGAN @elseif($holding =='sps') PT. SURYA PANGAN SEMESTA @elseif($holding =='sip') CV. SURYA INTI PANGAN  @endif">
                                    <input type="hidden" class="form-control" id="kontrak_kerja" name="kontrak_kerja" value="{{$holding}}">
                                    <label for="kontrak_kerja">Kontrak Kerja</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control @error('site_job') is-invalid @enderror" id="site_job" name="site_job">
                                        <option selected disabled value=""> Pilih Site Job</option>
                                        @foreach ($data_lokasi as $a)
                                        @if(old('site_job',$karyawan->site_job) == $a["lokasi_kantor"])
                                        <option value="{{ $a["lokasi_kantor"] }}" selected>{{ $a["lokasi_kantor"] }}</option>
                                        @else
                                        <option value="{{ $a["lokasi_kantor"] }}">{{ $a["lokasi_kantor"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="site_job">Site yang Dipegang</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control @error('penempatan_kerja') is-invalid @enderror" id="penempatan_kerja" name="penempatan_kerja">
                                        <option selected disabled value=""> Pilih Lokasi Penempatan</option>
                                        @foreach ($data_lokasi as $a)
                                        @if(old('penempatan_kerja',$karyawan->penempatan_kerja) == $a["lokasi_kantor"])
                                        <option value="{{ $a["lokasi_kantor"] }}" selected>{{ $a["lokasi_kantor"] }}</option>
                                        @else
                                        <option value="{{ $a["lokasi_kantor"] }}">{{ $a["lokasi_kantor"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="penempatan_kerja">Penempatan Kerja</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?php $is_admin = array(
                                    [
                                        "is_admin" => "admin"
                                    ],
                                    [
                                        "is_admin" => "user"
                                    ]
                                );
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="is_admin" id="is_admin" class="form-control selectpicker" data-live-search="true">
                                        @foreach ($is_admin as $a)
                                        @if(old('is_admin', $karyawan->is_admin) == $a["is_admin"])
                                        <option value="{{ $a["is_admin"] }}" selected>{{ $a["is_admin"] }}</option>
                                        @else
                                        <option value="{{ $a["is_admin"] }}">{{ $a["is_admin"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="is_admin">Level User</label>
                                </div>
                            </div>
                            <small class="text-light fw-medium mt-5">ALAMAT</small>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control @error('provinsi') is-invalid @enderror" id="id_provinsi" name="provinsi">
                                        <option value=""> Pilih Provinsi </option>
                                        @foreach($data_provinsi as $data)
                                        <option value="{{$data->code}}" {{($data->code == $karyawan->provinsi) ? 'selected' : ''}}>{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_provinsi">Provinsi</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?php
                                $kab = App\Models\Cities::Where('province_code', $karyawan->provinsi)->get();
                                $kec = App\Models\District::Where('city_code', $karyawan->kabupaten)->get();
                                $desa = App\Models\Village::Where('district_code', $karyawan->kecamatan)->get();
                                // echo $kab;
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control @error('kabupaten') is-invalid @enderror" id="id_kabupaten" name="kabupaten">
                                        <option value=""> Pilih Kabupaten / Kota</option>
                                        @foreach ($kab as $kabupaten)
                                        <option value="{{$kabupaten->code}}" {{($kabupaten->code == $karyawan->kabupaten) ? 'selected' : ''}}>{{$kabupaten->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_kabupaten">Kabupaten</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control @error('kecamatan') is-invalid @enderror" id="id_kecamatan" name="kecamatan">
                                        <option value=""> Pilih kecamatan</option>
                                        @foreach($kec as $data)
                                        <option value="{{$data->code}}" {{($data->code == $karyawan->kecamatan) ? 'selected' : ''}}>{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_kecamatan">kecamatan</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control @error('desa') is-invalid @enderror" id="id_desa" name="desa">
                                        <option value=""> Pilih Desa</option>
                                        @foreach ($desa as $data)
                                        <option value="{{$data->code}}" {{($data->code == $karyawan->desa) ? 'selected' : ''}}>{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_desa">Desa</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="rt" name="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="Masukkan RT" value="{{ old('rt', $karyawan->rt) }}" />
                                    <label for="rt">RT</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="rw" name="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="Masukkan RW" value="{{ old('rw',$karyawan->rw) }}" />
                                    <label for="rw">RW</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" value="{{ old('alamat',$karyawan->alamat) }}" />
                                    <label for="alamat">Keterangan Alamat(Jalan / Dusun)</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="kuota_cuti" name="kuota_cuti" class="form-control @error('kuota_cuti') is-invalid @enderror" placeholder="Masukkan Cuti Tahunan" value="{{ old('kuota_cuti',$karyawan->kuota_cuti) }}" />
                                    <label for="kuota_cuti">Kuota Cuti Tahunan</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan</button>
                            <a href="{{url('/karyawan/'.$holding)}}" type="button" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </div>
                    <!-- /Account -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    function bankCheck(that) {
        if (that.value == "BBRI") {
            Swal.fire({
                customClass: {
                    container: 'my-swal'
                },
                target: document.getElementById('modal_tambah_karyawan'),
                position: 'top',
                icon: 'warning',
                title: 'Apakah Benar Bank BRI?',
                showConfirmButton: true
            });
            bankdigit = 15;
            // document.getElementById("ifBRI").style.display = "block";
            // document.getElementById("ifBCA").style.display = "none";
            // document.getElementById("ifMANDIRI").style.display = "none";
        } else if (that.value == "BBCA") {
            Swal.fire({
                customClass: {
                    container: 'my-swal'
                },
                target: document.getElementById('modal_tambah_karyawan'),
                position: 'top',
                icon: 'warning',
                title: 'Apakah Benar Bank BCA?',
                showConfirmButton: true
            });
            bankdigit = 10;
            // document.getElementById("ifMANDIRI").style.display = "block";
            // document.getElementById("ifBCA").style.display = "none";
            // document.getElementById("ifBRI").style.display = "none";
        } else if (that.value == "BOCBC") {
            Swal.fire({
                customClass: {
                    container: 'my-swal'
                },
                target: document.getElementById('modal_tambah_karyawan'),
                position: 'top',
                icon: 'warning',
                title: 'Apakah Benar Bank OCBC?',
                showConfirmButton: true
            });
            bankdigit = 12;
            // document.getElementById("ifBCA").style.display = "block";
            // document.getElementById("ifMANDIRI").style.display = "none";
            // document.getElementById("ifBRI").style.display = "none";
        }
    }
    $(function() {
        $('#id_departemen').on('change', function() {
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
                    // console.log(msg);
                    // $('#id_divisi').html(msg);
                    $('#id_divisi').html(msg);
                    $('#id_divisi1').html(msg);
                    $('#id_divisi2').html(msg);
                    $('#id_divisi3').html(msg);
                    $('#id_divisi4').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi').on('change', function() {
            let id_divisi = $('#id_divisi').val();
            // console.log(id_divisi);
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
        $('#id_divisi1').on('change', function() {
            let id_divisi = $('#id_divisi1').val();
            // console.log(id_divisi);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_jabatan1').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi2').on('change', function() {
            let id_divisi = $('#id_divisi2').val();
            // console.log(id_divisi);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_jabatan2').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi3').on('change', function() {
            let id_divisi = $('#id_divisi3').val();
            // console.log(id_divisi);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_jabatan3').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi4').on('change', function() {
            let id_divisi = $('#id_divisi4').val();
            // console.log(id_divisi);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_jabatan4').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
    })
    $(function() {
        $('#nik').keyup(function(e) {
            if ($(this).val().length >= 16) {
                $(this).val($(this).val().substr(0, 16));
                document.getElementById("nik").focus();
                Swal.fire({
                    customClass: {
                        container: 'my-swal'
                    },
                    target: document.getElementById('modal_tambah_karyawan'),
                    position: 'top',
                    icon: 'warning',
                    title: 'Nomor NIK harus ' + 16 + ' karakter. Mohon cek kembali!',
                    showConfirmButton: false,
                    timer: 1500
                });
                // if (length !== bankdigit) {
                //     document.getElementById('nomor_rekening').value;
                //     alert('Nomor Rekening harus ' + bankdigit + ' karakter. Mohon cek kembali!');
                //     document.getElementById('nomor_rekening').focus();
            }
        });
        $('#npwp').keyup(function(e) {
            if ($(this).val().length >= 16) {
                $(this).val($(this).val().substr(0, 16));
                document.getElementById("npwp").focus();
                Swal.fire({
                    customClass: {
                        container: 'my-swal'
                    },
                    target: document.getElementById('modal_tambah_karyawan'),
                    position: 'top',
                    icon: 'warning',
                    title: 'Nomor NPWP harus ' + 16 + ' karakter. Mohon cek kembali!',
                    showConfirmButton: false,
                    timer: 1500
                });
                // if (length !== bankdigit) {
                //     document.getElementById('nomor_rekening').value;
                //     alert('Nomor Rekening harus ' + bankdigit + ' karakter. Mohon cek kembali!');
                //     document.getElementById('nomor_rekening').focus();
            }
        });
        $('#nomor_rekening').keyup(function(e) {
            if ($(this).val().length >= bankdigit) {
                $(this).val($(this).val().substr(0, bankdigit));
                document.getElementById("nomor_rekening").focus();
                Swal.fire({
                    customClass: {
                        container: 'my-swal'
                    },
                    target: document.getElementById('modal_tambah_karyawan'),
                    position: 'top',
                    icon: 'warning',
                    title: 'Nomor Rekening harus ' + bankdigit + ' karakter. Mohon cek kembali!',
                    showConfirmButton: false,
                    timer: 1500
                });
                // if (length !== bankdigit) {
                //     document.getElementById('nomor_rekening').value;
                //     alert('Nomor Rekening harus ' + bankdigit + ' karakter. Mohon cek kembali!');
                //     document.getElementById('nomor_rekening').focus();
            }
        });
        $('#id_provinsi').on('change', function() {
            let id_provinsi = $(this).val();
            let url = "{{url('/karyawan/get_kabupaten')}}" + "/" + id_provinsi;
            console.log(id_provinsi);
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                // data: {
                //     id_provinsi: id_provinsi
                // },
                success: function(response) {
                    // console.log(response);
                    $('#id_kabupaten').html(response);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_kabupaten').on('change', function() {
            let id_kabupaten = $(this).val();
            let url = "{{url('/karyawan/get_kecamatan')}}" + "/" + id_kabupaten;
            console.log(id_kabupaten);
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                // data: {
                //     id_kabupaten: id_kabupaten
                // },
                success: function(response) {
                    // console.log(response);
                    $('#id_kecamatan').html(response);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_kecamatan').on('change', function() {
            let id_kecamatan = $(this).val();
            let url = "{{url('/karyawan/get_desa')}}" + "/" + id_kecamatan;
            console.log(id_kecamatan);
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                // data: {
                //     id_kecamatan: id_kecamatan
                // },
                success: function(response) {
                    // console.log(response);
                    $('#id_desa').html(response);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#foto_karyawan').change(function() {

            let reader = new FileReader();
            console.log(reader);
            reader.onload = (e) => {

                $('#template_foto_karyawan').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

        });
    });
</script>
<script>
    $(document).on("click", "#btndetail_karyawan", function() {
        console.log('ok');
        let id = $(this).data('id');
        let holding = $(this).data("holding");
        let url = "{{ url('/karyawan/detail/')}}" + '/' + id + '/' + holding;
        $.ajax({
            url: url,
            method: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            // data: {
            //     id_kecamatan: id_kecamatan
            // },
            success: function(response) {
                // console.log(response);
                window.location.assign(url);
            },
            error: function(data) {
                console.log('error:', data)
            },

        })
    });
</script>
@endsection