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
                    <a class="nav-link active" href="javascript:void(0);"><i class="mdi mdi-account-outline mdi-20px me-1"></i>{{$karyawan->fullname}}&nbsp;<b>[{{$karyawan->nomor_identitas_karyawan}}]</b></a>
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
                            <img src="https://karyawan.sumberpangan.store/laravel/storage/app/public/foto_karyawan/{{$karyawan->foto_karyawan}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="template_foto_karyawan" />
                            @endif
                            <div class="button-wrapper">
                                <label for="foto_karyawan" class="btn btn-primary me-2 mb-3" tabindex="0">
                                    <span class="d-none d-sm-block">Upload Foto</span>
                                    <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                    <input type="hidden" name="foto_karyawan_lama" value="{{ $karyawan->foto_karyawan }}">
                                    <input type="file" name="foto_karyawan" id="foto_karyawan" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                </label>

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
                                @error('nik')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('npwp') is-invalid @enderror" type="number" id="npwp" name="npwp" value="{{old('npwp', $karyawan->npwp)}}" />
                                    <label for="npwp">NPWP</label>
                                </div>
                                @error('npwp')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $karyawan->name) }}">
                                    <label for="name">Nama</label>
                                </div>
                                @error('name')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control @error('fullname') is-invalid @enderror" type="text" name="fullname" id="fullname" value="{{ old('fullname', $karyawan->fullname)}}" />
                                    <label for="fullname">Fullname</label>
                                </div>
                                @error('fullname')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $karyawan->email) }}">
                                    <label for="email">E-mail</label>
                                </div>
                                @error('email')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $karyawan->telepon) }}">
                                    <label for="telepon">Telepon</label>
                                </div>
                                @error('telepon')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir',$karyawan->tempat_lahir) }}">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                </div>
                                @error('tempat_lahir')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="date" id="tgl_lahir" value="{{$karyawan->tgl_lahir}}" name="tgl_lahir" placeholder="Tanggal Lahir" />
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                </div>
                                @error('tgl_lahir')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control @error('tgl_join') is-invalid @enderror" id="tgl_join" name="tgl_join" value="{{ old('tgl_join', $karyawan->tgl_join) }}">
                                    <label for="tgl_join">Tanggal Join Perusahaan</label>
                                </div>
                                @error('tgl_join')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $karyawan->username) }}">
                                    <input type="hidden" name="password" value="{{ $karyawan->password }}">
                                    <label for="username">Username</label>
                                </div>
                                @error('username')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
                                @error('gender')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
                                @error('status_nikah')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
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
                                        ],
                                        [
                                            "kode_bank" => "BMANDIRI",
                                            "bank" => "BANK MANDIRI"
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
                                @error('nama_bank')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control  @error('nomor_rekening') is-invalid @enderror" id="nomor_rekening" name="nomor_rekening" value="{{old('nomor_rekening', $karyawan->nomor_rekening) }}" placeholder="Nomor Rekening" />
                                    <label for="nomor_rekening">Nomor Rekening</label>
                                </div>
                                @error('nomor_rekening')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <?php $kategori = array(
                                    [
                                        "kategori" => "Karyawan Bulanan"
                                    ],
                                    [
                                        "kategori" => "Karyawan Harian"
                                    ]
                                );
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="kategori" id="kategori" class="form-control selectpicker" data-live-search="true">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $a)
                                        @if(old('kategori', $karyawan->kategori) == $a["kategori"])
                                        <option value="{{ $a["kategori"] }}" selected>{{ $a["kategori"] }}</option>
                                        @else
                                        <option value="{{ $a["kategori"] }}">{{ $a["kategori"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="kategori">Kategori Karyawan</label>
                                </div>
                                @error('kategori')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_departemen" class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="departemen_id" id="id_departemen" class="form-control @error('departemen_id') is-invalid @enderror">
                                        <option value=""> Pilih Departemen</option>
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
                                @error('departemen_id')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_divisi" class="col-md-6">
                                <?php
                                $data_divisi = App\Models\Divisi::Where('dept_id', $karyawan->dept_id)->get();
                                // echo $kec;
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="divisi_id" id="id_divisi" class="form-control @error('divisi_id') is-invalid @enderror">
                                        @foreach ($data_divisi as $divisi)
                                        @if(old('divisi_id', $karyawan->divisi_id) == $divisi["id"])
                                        <option value="{{$divisi->id}}" {{($divisi->id == $karyawan->divisi_id) ? 'selected' : ''}}>{{$divisi->nama_divisi}}</option>
                                        @else
                                        <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="id_divisi">Divisi</label>
                                </div>
                                @error('divisi_id')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_bagian" class="col-md-3">
                                <?php
                                $data_bagian = App\Models\Bagian::Where('divisi_id', $karyawan->divisi_id)->get();
                                // echo $kec;
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="bagian_id" id="id_bagian" class="form-control @error('bagian_id') is-invalid @enderror">
                                        @foreach ($data_bagian as $bagian)
                                        <option value="{{$bagian->id}}" {{($bagian->id == $karyawan->bagian_id) ? 'selected' : ''}}>{{$bagian->nama_bagian}}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_bagian">Bagian</label>
                                </div>
                                @error('bagian_id')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_jabatan" class="col-md-3">
                                <?php
                                // Bagian
                                $data_bagian = App\Models\Bagian::Where('divisi_id', $karyawan->bagian_id)->get();
                                $data_bagian1 = App\Models\Bagian::Where('divisi_id', $karyawan->divisi1_id)->get();
                                $data_bagian2 = App\Models\Bagian::Where('divisi_id', $karyawan->divisi2_id)->get();
                                $data_bagian3 = App\Models\Bagian::Where('divisi_id', $karyawan->divisi3_id)->get();
                                $data_bagian4 = App\Models\Bagian::Where('divisi_id', $karyawan->divisi4_id)->get();
                                // Jabatan
                                $data_jabatan = App\Models\Jabatan::Where('bagian_id', $karyawan->bagian_id)->get();
                                $data_jabatan1 = App\Models\Jabatan::Where('bagian_id', $karyawan->bagian1_id)->get();
                                $data_jabatan2 = App\Models\Jabatan::Where('bagian_id', $karyawan->bagian2_id)->get();
                                $data_jabatan3 = App\Models\Jabatan::Where('bagian_id', $karyawan->bagian3_id)->get();
                                $data_jabatan4 = App\Models\Jabatan::Where('bagian_id', $karyawan->bagian4_id)->get();
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
                                @error('jabatan_id')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_jabatan_more" class="col-md-12">
                                <div class="accordion mt-3" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                                Tambahkan Atasan Karyawan
                                            </button>
                                        </h2>

                                        <div id="accordionOne" class="accordion-collapse collapse show " data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row g-2">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="atasan" id="atasan" class="form-control">
                                                                <option disabled selected value="">Atasan 1</option>
                                                                <?php
                                                                $level = App\Models\Jabatan::Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')->where('jabatans.id', $karyawan->jabatan_id)->first();
                                                                if ($level == '' || $level == NULL) {
                                                                    $get_atasan = NULL;
                                                                } else {
                                                                    $get_atasan = App\Models\User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                                                                        ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                                                                        ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                                                                        ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                                                                        ->where('users.kontrak_kerja', $karyawan->kontrak_kerja)
                                                                        ->where('level_jabatans.level_jabatan', '<', $level->level_jabatan)
                                                                        ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                                                                        ->get();
                                                                }
                                                                ?>
                                                                @if($karyawan->atasan_1==NULL || $karyawan->atasan_1=='')
                                                                @else
                                                                @foreach($get_atasan as $atasan)
                                                                <option value="{{$atasan->id}}" {{($atasan->id == $karyawan->atasan_1) ? 'selected' : ''}}>{{$atasan->name}} ({{$atasan->nama_jabatan}} | {{$atasan->nama_bagian}})</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                            <label for="atasan">Atasan 1</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="atasan2" id="atasan2" class="form-control">
                                                                <option disabled selected value="">Atasan 2</option>
                                                                <?php
                                                                $level = App\Models\Jabatan::Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')->where('jabatans.id', $karyawan->jabatan_id)->first();
                                                                if ($level == '' || $level == NULL) {
                                                                    $get_atasan = NULL;
                                                                } else {
                                                                    $get_atasan = App\Models\User::Join('jabatans', 'jabatans.id', 'users.jabatan_id')
                                                                        ->Join('divisis', 'divisis.id', 'jabatans.divisi_id')
                                                                        ->Join('bagians', 'bagians.id', 'jabatans.bagian_id')
                                                                        ->Join('level_jabatans', 'level_jabatans.id', 'jabatans.level_id')
                                                                        ->where('users.kontrak_kerja', $karyawan->kontrak_kerja)
                                                                        ->where('level_jabatans.level_jabatan', '<', $level->level_jabatan)
                                                                        ->select('users.*', 'jabatans.nama_jabatan', 'bagians.nama_bagian')
                                                                        ->get();
                                                                }
                                                                ?>
                                                                @if($karyawan->atasan_2==NULL || $karyawan->atasan_2=='')
                                                                @else
                                                                @foreach($get_atasan as $atasan)
                                                                <option value="{{$atasan->id}}" {{($atasan->id == $karyawan->atasan_2) ? 'selected' : ''}}>{{$atasan->name}} ({{$atasan->nama_jabatan}} | {{$atasan->nama_bagian}})</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                            <label for=" atasan2">Atasan 2</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form_kontrak" class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" readonly value="@if($karyawan->kontrak_kerja =='SP')CV. SUMBER PANGAN @elseif($karyawan->kontrak_kerja =='SPS') PT. SURYA PANGAN SEMESTA @elseif($karyawan->kontrak_kerja =='SIP') CV. SURYA INTI PANGAN  @endif">
                                    <input type="hidden" class="form-control" id="kontrak_kerja" name="kontrak_kerja" value="{{$karyawan->kontrak_kerja}}">
                                    <label for="kontrak_kerja">Kontrak Kerja</label>
                                </div>

                            </div>
                            <div class="col-md-6">
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
                                <p class="text-info">Untuk Kebutuhan Absensi</p>
                                @error('penempatan_kerja')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_tgl_mulai_kontrak" class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control @error('tgl_mulai_kontrak') is-invalid @enderror" id="tgl_mulai_kontrak" name="tgl_mulai_kontrak" value="{{old('tgl_mulai_kontrak', $karyawan->tgl_mulai_kontrak) }}" />
                                    <label for="tgl_mulai_kontrak">Tanggal Mulai Kontrak</label>
                                </div>
                                @error('tgl_mulai_kontrak')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_tgl_selesai_kontrak" class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control @error('tgl_selesai_kontrak') is-invalid @enderror" id="tgl_selesai_kontrak" name="tgl_selesai_kontrak" value="{{old('tgl_selesai_kontrak', $karyawan->tgl_selesai_kontrak) }}" />
                                    <label for=" tgl_selesai_kontrak">Tanggal Selesai Kontrak</label>
                                </div>
                                @error('tgl_selesai_kontrak')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_lama_kontrak" class="col-md-6">
                                <?php $lama_kontrak_kerja = array(
                                    [
                                        "lama_kontrak_kerja" => "6 bulan"
                                    ],
                                    [
                                        "lama_kontrak_kerja" => "1 tahun"
                                    ],
                                    [
                                        "lama_kontrak_kerja" => "2 bahun"
                                    ],
                                    [
                                        "lama_kontrak_kerja" => "tetap"
                                    ]
                                );
                                ?>
                                <div class="form-floating form-floating-outline">
                                    <select name="lama_kontrak_kerja" id="lama_kontrak_kerja" class="form-control selectpicker @error('lama_kontrak_kerja') is-invalid @enderror" data-live-search="true">
                                        <option value="">Pilih Kontrak</option>
                                        @foreach ($lama_kontrak_kerja as $a)
                                        @if(old('lama_kontrak_kerja', $karyawan->lama_kontrak_kerja) == $a["lama_kontrak_kerja"])
                                        <option value="{{ $a["lama_kontrak_kerja"] }}" selected>{{ $a["lama_kontrak_kerja"] }}</option>
                                        @else
                                        <option value="{{ $a["lama_kontrak_kerja"] }}">{{ $a["lama_kontrak_kerja"] }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <label for="lama_kontrak_kerja">Lama Kontrak</label>
                                </div>
                                @error('lama_kontrak_kerja')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_site" class="col-md-6">
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
                                <p class="text-info">Untuk Kebutuhan Approval</p>
                                @error('site_job')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div id="form_level" class="col-md-6">
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
                                @error('is_admin')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
                                @error('provinsi')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
                                @error('kabupaten')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
                                @error('kecamatan')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
                                @error('desa')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="rt" name="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="Masukkan RT" value="{{ old('rt', $karyawan->rt) }}" />
                                    <label for="rt">RT</label>
                                </div>
                                @error('rt')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="rw" name="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="Masukkan RW" value="{{ old('rw',$karyawan->rw) }}" />
                                    <label for="rw">RW</label>
                                </div>
                                @error('rw')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" value="{{ old('alamat',$karyawan->alamat) }}" />
                                    <label for="alamat">Keterangan Alamat(Jalan / Dusun)</label>
                                </div>
                                @error('alamat')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="kuota_cuti" name="kuota_cuti" class="form-control @error('kuota_cuti') is-invalid @enderror" placeholder="Masukkan Cuti Tahunan" value="{{ old('kuota_cuti',$karyawan->kuota_cuti_tahunan) }}" />
                                    <label for="kuota_cuti">Kuota Cuti Tahunan</label>
                                </div>
                                @error('kuota_cuti')
                                <p class="alert alert-danger">{{$message}}</p>
                                @enderror
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
        var kategori = '{{$karyawan->kategori}}';
        if (kategori == 'Karyawan Harian') {
            $('#form_departemen').hide();
            $('#form_divisi').hide();
            $('#form_jabatan_more').hide();
            $('#form_jabatan').hide();
            $('#form_lama_kotrak').hide();
            $('#form_bagian').hide();
            $('#form_kontrak').hide();
            $('#form_tgl_kontrak_kerja').hide();
            $('#form_level').hide();
            $('#form_tgl_mulai_kontrak').hide();
            $('#form_tgl_selesai_kontrak').hide();
            $('#form_site').hide();
            $('#form_lama_kontrak').hide();
        } else {
            $('#form_departemen').show();
            $('#form_divisi').show();
            $('#form_jabatan_more').show();
            $('#form_jabatan').show();
            $('#form_lama_kotrak').show();
            $('#form_bagian').show();
            $('#form_kontrak').show();
            $('#form_tgl_kontrak_kerja').show();
            $('#form_level').show();
            $('#form_lama_kontrak').show();
            $('#form_tgl_mulai_kontrak').show();
            $('#form_tgl_selesai_kontrak').show();
            $('#form_site').show();
        }
        $('#kategori').on('change', function() {
            var id = $(this).val();
            if (id == 'Karyawan Harian') {
                $('#form_departemen').hide();
                $('#form_divisi').hide();
                $('#form_jabatan_more').hide();
                $('#form_jabatan').hide();
                $('#form_lama_kotrak').hide();
                $('#form_bagian').hide();
                $('#form_kontrak').hide();
                $('#form_tgl_kontrak_kerja').hide();
                $('#form_level').hide();
                $('#form_tgl_mulai_kontrak').hide();
                $('#form_tgl_selesai_kontrak').hide();
                $('#form_site').hide();
                $('#form_lama_kontrak').hide();
            } else {
                $('#form_departemen').show();
                $('#form_divisi').show();
                $('#form_jabatan_more').show();
                $('#form_jabatan').show();
                $('#form_lama_kotrak').show();
                $('#form_bagian').show();
                $('#form_kontrak').show();
                $('#form_tgl_kontrak_kerja').show();
                $('#form_level').show();
                $('#form_lama_kontrak').show();
                $('#form_tgl_mulai_kontrak').show();
                $('#form_tgl_selesai_kontrak').show();
                $('#form_site').show();
            }
        });

    });
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
            console.log(id_divisi);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_bagian')}}",
                data: {
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_bagian').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_bagian').on('change', function() {
            let id_bagian = $('#id_bagian').val();
            // console.log(id_bagian);
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    id_bagian: id_bagian
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
        $('#id_jabatan').on('change', function() {
            let id = $(this).val();
            let divisi = $('#id_divisi').val();
            let holding = '{{$holding}}';
            let url = "{{url('karyawan/atasan/get_jabatan')}}" + "/" + divisi + "/" + id + "/" + holding;
            // console.log(divisi);
            console.log(holding);
            $.ajax({
                url: url,
                method: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                // data: {
                //     id_divisi: id_divisi
                // },
                success: function(response) {
                    // console.log(response);
                    $('#atasan').html(response);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        });
        $('#atasan').on('change', function() {
            let id = $('#id_jabatan').val();
            let divisi = $('#id_divisi').val();
            let holding = '{{$holding}}';
            let url = "{{url('karyawan/atasan2/get_jabatan')}}" + "/" + divisi + "/" + id + "/" + holding;
            console.log(divisi);
            // console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                // data: {
                //     id_divisi: id_divisi
                // },
                success: function(response) {
                    // console.log(response);
                    $('#atasan2').html(response);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        });

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
        let id = $(this).data('id');
        let holding = $(this).data("holding");
        // console.log(id);
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