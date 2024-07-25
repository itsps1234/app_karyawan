@extends('admin.layouts.dashboard')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
<style type="text/css">
    .my-swal {
        z-index: X;
    }
</style>
@endsection
@section('isi')
@include('sweetalert::alert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
        <!-- Transactions -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">DATA KARYAWAN</h5>
                    </div>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal_tambah_karyawan"><i class="menu-icon tf-icons mdi mdi-plus"></i>Tambah</button>
                    <button class="btn btn-sm btn-success waves-effect waves-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="menu-icon tf-icons mdi mdi-file-excel"></i> Excel
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_import_karyawan" href="">Import Excel</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal_export_karyawan" href="#">Export Excel</a></li>
                    </ul>
                    <a type="button" href="{{url('karyawan/pdfKaryawan/'.$holding)}}" class="btn btn-sm btn-danger waves-effect waves-light"><i class="menu-icon tf-icons mdi mdi-file-pdf-box"></i>PDF</a>
                    <hr class="my-5">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-primary rounded shadow">
                                        <i class="mdi mdi-account-tie mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Karyawan Laki- Laki</div>
                                    <h5 class="mb-0">{{$karyawan_laki}}&nbsp;Orang</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-success rounded shadow">
                                        <i class="mdi mdi-account-tie mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Karyawan Perempuan</div>
                                    <h5 class="mb-0">{{$karyawan_perempuan}}&nbsp;Orang</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-warning rounded shadow">
                                        <i class="mdi mdi-account-tie mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Karyawan Bulanan</div>
                                    <h5 class="mb-0">{{$karyawan_office}}&nbsp;Orang</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    <div class="avatar-initial bg-info rounded shadow">
                                        <i class="mdi mdi-account-tie mdi-24px"></i>
                                    </div>
                                </div>
                                <div class="ms-3">
                                    <div class="small mb-1">Karyawan Harian</div>
                                    <h5 class="mb-0">{{$karyawan_shift}}&nbsp;Orang</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-5">
                    <div class="modal fade" id="modal_tambah_karyawan" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <form method="post" action="{{ url('/karyawan/tambah-karyawan-proses/'.$holding) }}" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title" id="backDropModalTitle">Tambah Karyawan</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt="user-avatar" class="d-block w-px-120 h-px-120 rounded" id="template_foto_karyawan" />

                                        <div class="button-wrapper">
                                            <label for="foto_karyawan" class="btn btn-primary me-2 mb-3" tabindex="0">
                                                <span class="d-none d-sm-block">Upload Foto</span>
                                                <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                                <input type="file" name="foto_karyawan" id="foto_karyawan" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                            </label>

                                            <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK" value="{{ old('nik') }}" />
                                                <label for="nik">NIK</label>
                                            </div>
                                            @error('nik')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="npwp" name="npwp" class="form-control @error('npwp') is-invalid @enderror" placeholder="Masukkan NPWP" value="{{ old('npwp') }}" />
                                                <label for="npwp">NPWP</label>
                                            </div>
                                            @error('npwp')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" value="{{ old('name') }}" />
                                                <label for="name">Nama</label>
                                            </div>
                                            @error('name')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="fullname" name="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Masukkan Fullname" value="{{ old('fullname') }}" />
                                                <label for="fullname">Fullname</label>
                                            </div>
                                            @error('fullname')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{ old('email') }}" />
                                                <label for="email">Email</label>
                                            </div>
                                            @error('email')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="telepon" name="telepon" class="form-control @error('telepon') is-invalid @enderror" placeholder="Masukkan Telepon" value="{{ old('telepon') }}" />
                                                <label for="telepon">Telepon</label>
                                            </div>
                                            @error('telepon')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="motto" name="motto" class="form-control @error('motto') is-invalid @enderror" placeholder="Masukkan motto" value="{{ old('motto') }}" />
                                                <label for="motto">Motto</label>
                                            </div>
                                            @error('motto')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Masukkan Tempat Lahir" value="{{ old('tempat_lahir') }}" />
                                                <label for="tempat_lahir">Tempat Lahir</label>
                                            </div>
                                            @error('tempat_lahir')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir') }}" />
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                            </div>
                                            @error('tgl_lahir')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="date" id="tgl_join" name="tgl_join" class="form-control @error('tgl_join') is-invalid @enderror" value="{{ old('tgl_join') }}" />
                                                <label for="tgl_join">Tanggal Join Perusahaan</label>
                                            </div>
                                            @error('tgl_join')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan Username" value="{{ old('username') }}" />
                                                <label for="username">Username</label>
                                            </div>
                                            @error('username')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" value="{{ old('password') }}" />
                                                <label for="password">Password</label>
                                            </div>
                                            @error('password')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <?php $get_gender = array(
                                                [
                                                    "gender" => "Laki-Laki"
                                                ],
                                                [
                                                    "gender" => "Perempuan"
                                                ]
                                            );
                                            ?>
                                            <div class="form-floating form-floating-outline">
                                                <select name="gender" id="gender" class="form-control  @error('gender') is-invalid @enderror">
                                                    <option selected disabled value="">Pilih Gender</option>
                                                    @foreach ($get_gender as $g)
                                                    @if(old('gender') == $g['gender'])
                                                    <option value="{{ $g['gender'] }}" selected>{{ $g['gender'] }}</option>
                                                    @else
                                                    <option value="{{ $g['gender'] }}">{{ $g['gender'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="gender">Kelamin</label>
                                            </div>
                                            @error('gender')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <?php $sNikah = array(
                                                [
                                                    "status" => "Lajang"
                                                ],
                                                [
                                                    "status" => "Menikah"
                                                ]
                                            );
                                            ?>
                                            <div class="form-floating form-floating-outline">
                                                <select name="status_nikah" id="status_nikah" class="form-control selectpicker @error('status_nikah') is-invalid @enderror">
                                                    <option value="">Pilih Status</option>
                                                    @foreach ($sNikah as $s)
                                                    @if(old('status_nikah') == $s['status']) <option value="{{ $s['status'] }}" selected>{{ $s['status'] }}</option>
                                                    @else
                                                    <option value="{{ $s['status'] }}">{{ $s['status'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select> <label for="status_nikah">Status Menikah</label>
                                            </div>
                                            @error('status_nikah')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
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
                                            <div class="form-floating form-floating-outline">
                                                <select name="nama_bank" id="nama_bank" onchange="bankCheck(this);" class="selectpicker form-control  @error('nama_bank') is-invalid @enderror">
                                                    <option value="">Pilih Bank</option>
                                                    @foreach ($bank as $bank)
                                                    @if(old('nama_bank') == $bank['kode_bank']) <option value="{{ $bank['kode_bank'] }}" selected>{{ $bank['bank'] }}</option>
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
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="nomor_rekening" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror" placeholder="Masukkan Nomor Rekening" value="{{ old('nomor_rekening') }}" />
                                                <label for="nomor_rekening">Nomor Rekening</label>
                                            </div>
                                            @error('nomor_rekening')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">

                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <?php $kategori = array(
                                                    [
                                                        "level" => "Karyawan Harian"
                                                    ],
                                                    [
                                                        "level" => "Karyawan Bulanan"
                                                    ]
                                                );
                                                ?>
                                                <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach ($kategori as $a)
                                                    @if(old('kategori') == $a["level"])
                                                    <option value="{{ $a['level'] }}" selected>{{ $a['level'] }}</option>
                                                    @else
                                                    <option value="{{ $a['level'] }}">{{ $a['level'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="kategori">Kategori Karyawan</label>
                                            </div>
                                            @error('kategori')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('penempatan_kerja') is-invalid @enderror" id="penempatan_kerja" name="penempatan_kerja">
                                                    <option selected disabled value=""> Pilih Lokasi Penempatan</option>
                                                    @foreach ($data_lokasi as $a)
                                                    @if(old('penempatan_kerja') == $a["lokasi_kantor"])
                                                    <option value="{{ $a['lokasi_kantor'] }}" selected>{{ $a['lokasi_kantor'] }}</option>
                                                    @else
                                                    <option value="{{ $a['lokasi_kantor'] }}">{{ $a['lokasi_kantor'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="penempatan_kerja">Penempatan Kerja</label>
                                            </div>
                                            @error('penempatan_kerja')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                            <p class="text-info">Untuk Kebutuhan Absensi</p>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <?php $is_admin = array(
                                                    [
                                                        "level" => "admin"
                                                    ],
                                                    [
                                                        "level" => "user"
                                                    ]
                                                );
                                                ?>
                                                <select class="form-control @error('is_admin') is-invalid @enderror" name="is_admin" id="is_admin">
                                                    <option value="">Pilih Level</option>
                                                    @foreach ($is_admin as $a)
                                                    @if(old('is_admin') == $a["level"])
                                                    <option value="{{ $a['level'] }}" selected>{{ $a['level'] }}</option>
                                                    @else
                                                    <option value="{{ $a['level'] }}">{{ $a['level'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="is_admin">Level User</label>
                                            </div>
                                            @error('is_admin')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2" id="form_level_site">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('site_job') is-invalid @enderror" id="site_job" name="site_job">
                                                    <option selected disabled value=""> Pilih Site..</option>
                                                    @foreach ($data_lokasi as $a)
                                                    @if(old('site_job') == $a["lokasi_kantor"])
                                                    <option value="{{ $a['lokasi_kantor'] }}" selected>{{ $a['lokasi_kantor'] }}</option>
                                                    @else
                                                    <option value="{{ $a['lokasi_kantor'] }}">{{ $a['lokasi_kantor'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="site_job">Site yang Dipegang</label>
                                            </div>
                                            @error('site_job')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                            <p class="text-info">Untuk Kebutuhan Approval</p>
                                        </div>
                                    </div>
                                    <div id="form_kontrak_kerja" class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" readonly id="kontrak_kerja" name="kontrak_kerja" class="form-control @error('kontrak_kerja') is-invalid @enderror" placeholder="Masukkan Kontrak" value="@if($holding =='sp')CV. SUMBER PANGAN @elseif($holding =='sps') PT. SURYA PANGAN SEMESTA @elseif($holding =='sip') CV. SURYA INTI PANGAN  @endif" />
                                                <label for="kontrak_kerja">Kontrak Kerja</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <?php $get_kontrak = array(
                                                [
                                                    "kontrak" => "6 Bulan"
                                                ],
                                                [
                                                    "kontrak" => "1 Tahun"
                                                ],
                                                [
                                                    "kontrak" => "2 Tahun"
                                                ],
                                                [
                                                    "kontrak" => "Tetap"
                                                ]
                                            );
                                            ?>
                                            <div class="form-floating form-floating-outline">
                                                <select name="lama_kontrak_kerja" id="lama_kontrak_kerja" class="form-control  @error('lama_kontrak_kerja') is-invalid @enderror">
                                                    <option selected disabled value="">Pilih Kontrak</option>
                                                    @foreach ($get_kontrak as $g)
                                                    @if(old('lama_kontrak_kerja') == $g['kontrak'])
                                                    <option value="{{ $g['kontrak'] }}" selected>{{ $g['kontrak'] }}</option>
                                                    @else
                                                    <option value="{{ $g['kontrak'] }}">{{ $g['kontrak'] }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="lama_kontrak_kerja">Lama Kontrak Kerja</label>
                                            </div>
                                            @error('lama_kontrak_kerja')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="form_tgl_kontrak_kerja" class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="date" id="tgl_mulai_kontrak" name="tgl_mulai_kontrak" class="form-control @error('tgl_mulai_kontrak') is-invalid @enderror" placeholder="Masukkan Kontrak" value="@if($holding =='sp')CV. SUMBER PANGAN @elseif($holding =='sps') PT. SURYA PANGAN SEMESTA @elseif($holding =='sip') CV. SURYA INTI PANGAN  @endif" />
                                                <label for="tgl_mulai_kontrak">Tanggal Mulai Kontrak</label>
                                            </div>
                                            @error('tgl_mulai_kontrak')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="date" id="tgl_selesai_kontrak" name="tgl_selesai_kontrak" class="form-control @error('tgl_selesai_kontrak') is-invalid @enderror" placeholder="Masukkan Kontrak" value="@if($holding =='sp')CV. SUMBER PANGAN @elseif($holding =='sps') PT. SURYA PANGAN SEMESTA @elseif($holding =='sip') CV. SURYA INTI PANGAN  @endif" />
                                                <label for="tgl_selesai_kontrak">Tanggal Selesai Kontrak</label>
                                            </div>
                                            @error('tgl_selesai_kontrak')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="form_departemen_divisi" class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select name="departemen_id" id="id_departemen" class="form-control @error('departemen_id') is-invalid @enderror ">
                                                    <option value="">Pilih Departemen</option>
                                                    @foreach ($data_departemen as $dj)
                                                    @if(old('departemen_id') == $dj->id)
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
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select name="divisi_id" id="id_divisi" class="form-control  @error('divisi_id') is-invalid @enderror">
                                                    <option value=""> Pilih Divisi</option>
                                                    <?php
                                                    $divisi = App\Models\Divisi::where('dept_id', old('departemen_id'))->get();
                                                    ?>
                                                    @foreach($divisi as $divisi)
                                                    @if(old('divisi_id') == $divisi->id)
                                                    <option value="{{ $divisi->id }}" selected>{{ $divisi->nama_divisi }}</option>
                                                    @else
                                                    <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                                    <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for=" id_divisi">Divisi</label>
                                            </div>
                                            @error('divisi_id')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="form_bagian_jabatan" class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select name="bagian_id" id="id_bagian" class="form-control @error('addmore[0][bagian_id]') is-invalid @enderror">
                                                    <option value=""> Pilih Bagian</option>
                                                    <?php
                                                    $bagian = App\Models\Bagian::where('divisi_id', old('divisi_id'))->get();
                                                    ?>
                                                    @foreach($bagian as $bagian)
                                                    @if(old('bagian_id') == $bagian->id)
                                                    <option value="{{ $bagian->id }}" selected>{{ $bagian->nama_bagian }}</option>
                                                    @else
                                                    <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                                                    <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="id_bagian">Bagian</label>
                                            </div>
                                            @error('bagian_id')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select name="jabatan_id" id="id_jabatan" class="form-control @error('addmore[0][jabatan_id]') is-invalid @enderror">
                                                    <option value=""> Pilih Jabatan</option>
                                                    <?php
                                                    $jabatan = App\Models\Jabatan::where('bagian_id', old('bagian_id'))->get();
                                                    ?>
                                                    @foreach($jabatan as $jabatan)
                                                    @if(old('jabatan_id') == $jabatan->id)
                                                    <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama_jabatan }}</option>
                                                    @else
                                                    <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                                    <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="id_jabatan">Jabatan</label>
                                            </div>
                                            @error('jabatan_id')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="form_jabatan_more" class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="accordion mt-3" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                                            Jika Karyawan Memiliki Lebih Dari 1 Jabatan
                                                        </button>
                                                    </h2>

                                                    <div id="accordionOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row g-2 mt-2">
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="divisi1_id" id="id_divisi1" class="form-control">
                                                                            <option value=""> Pilih Divisi</option>
                                                                            <?php
                                                                            $divisi = App\Models\Divisi::where('dept_id', old('departemen_id'))->get();
                                                                            ?>
                                                                            @foreach($divisi as $divisi)
                                                                            @if(old('divisi1_id') == $divisi->id)
                                                                            <option value="{{ $divisi->id }}" selected>{{ $divisi->nama_divisi }}</option>
                                                                            @else
                                                                            <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for=" id_divisi1">Divisi 2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="bagian1_id" id="id_bagian1" class="form-control @error('bagian1_id') is-invalid @enderror">
                                                                            <option value=""> Pilih Bagian</option>
                                                                            <?php
                                                                            $bagian = App\Models\Bagian::where('divisi_id', old('divisi1_id'))->get();
                                                                            ?>
                                                                            @foreach($bagian as $bagian)
                                                                            @if(old('bagian1_id') == $bagian->id)
                                                                            <option value="{{ $bagian->id }}" selected>{{ $bagian->nama_bagian }}</option>
                                                                            @else
                                                                            <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="id_bagian1">Bagian 2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="jabatan1_id" id="id_jabatan1" class="form-control">
                                                                            <option value=""> Pilih Jabatan</option>
                                                                            <?php
                                                                            $jabatan = App\Models\Jabatan::where('bagian_id', old('bagian1_id'))->get();
                                                                            ?>
                                                                            @foreach($jabatan as $jabatan)
                                                                            @if(old('jabatan1_id') == $jabatan->id)
                                                                            <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama_jabatan }}</option>
                                                                            @else
                                                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
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
                                                                            <option value=""> Pilih Divisi</option>
                                                                            <?php
                                                                            $divisi = App\Models\Divisi::where('dept_id', old('departemen_id'))->get();
                                                                            ?>
                                                                            @foreach($divisi as $divisi)
                                                                            @if(old('divisi2_id') == $divisi->id)
                                                                            <option value="{{ $divisi->id }}" selected>{{ $divisi->nama_divisi }}</option>
                                                                            @else
                                                                            <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for=" id_divisi2">Divisi 3</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="bagian2_id" id="id_bagian2" class="form-control">
                                                                            <option value=""> Pilih Bagian</option>
                                                                            <?php
                                                                            $bagian = App\Models\Bagian::where('divisi_id', old('divisi2_id'))->get();
                                                                            ?>
                                                                            @foreach($bagian as $bagian)
                                                                            @if(old('bagian2_id') == $bagian->id)
                                                                            <option value="{{ $bagian->id }}" selected>{{ $bagian->nama_bagian }}</option>
                                                                            @else
                                                                            <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="id_bagian2">Bagian 3</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="jabatan2_id" id="id_jabatan2" class="form-control">
                                                                            <option value=""> Pilih Jabatan</option>
                                                                            <?php
                                                                            $jabatan = App\Models\Jabatan::where('bagian_id', old('bagian2_id'))->get();
                                                                            ?>
                                                                            @foreach($jabatan as $jabatan)
                                                                            @if(old('jabatan2_id') == $jabatan->id)
                                                                            <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama_jabatan }}</option>
                                                                            @else
                                                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
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
                                                                            <option value=""> Pilih Divisi</option>
                                                                            <?php
                                                                            $divisi = App\Models\Divisi::where('dept_id', old('departemen_id'))->get();
                                                                            ?>
                                                                            @foreach($divisi as $divisi)
                                                                            @if(old('divisi3_id') == $divisi->id)
                                                                            <option value="{{ $divisi->id }}" selected>{{ $divisi->nama_divisi }}</option>
                                                                            @else
                                                                            <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for=" id_divisi3">Divisi 4</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="bagian3_id" id="id_bagian3" class="form-control">
                                                                            <option value=""> Pilih Bagian</option>
                                                                            <?php
                                                                            $bagian = App\Models\Bagian::where('divisi_id', old('divisi3_id'))->get();
                                                                            ?>
                                                                            @foreach($bagian as $bagian)
                                                                            @if(old('bagian3_id') == $bagian->id)
                                                                            <option value="{{ $bagian->id }}" selected>{{ $bagian->nama_bagian }}</option>
                                                                            @else
                                                                            <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="id_bagian3">Bagian 4</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="jabatan3_id" id="id_jabatan3" class="form-control">
                                                                            <option value=""> Pilih Jabatan</option>
                                                                            <?php
                                                                            $jabatan = App\Models\Jabatan::where('bagian_id', old('bagian3_id'))->get();
                                                                            ?>
                                                                            @foreach($jabatan as $jabatan)
                                                                            @if(old('jabatan3_id') == $jabatan->id)
                                                                            <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama_jabatan }}</option>
                                                                            @else
                                                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
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
                                                                            <option value=""> Pilih Divisi</option>
                                                                            <?php
                                                                            $divisi = App\Models\Divisi::where('dept_id', old('departemen_id'))->get();
                                                                            ?>
                                                                            @foreach($divisi as $divisi)
                                                                            @if(old('divisi4_id') == $divisi->id)
                                                                            <option value="{{ $divisi->id }}" selected>{{ $divisi->nama_divisi }}</option>
                                                                            @else
                                                                            <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for=" id_divisi4">Divisi 5</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="bagian4_id" id="id_bagian4" class="form-control">
                                                                            <option value=""> Pilih Bagian</option>
                                                                            <?php
                                                                            $bagian = App\Models\Bagian::where('divisi_id', old('divisi4_id'))->get();
                                                                            ?>
                                                                            @foreach($bagian as $bagian)
                                                                            @if(old('bagian4_id') == $bagian->id)
                                                                            <option value="{{ $bagian->id }}" selected>{{ $bagian->nama_bagian }}</option>
                                                                            @else
                                                                            <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="id_bagian4">Bagian 5</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="jabatan4_id" id="id_jabatan4" class="form-control">
                                                                            <option value=""> Pilih Jabatan</option>
                                                                            <?php
                                                                            $jabatan = App\Models\Jabatan::where('bagian_id', old('bagian4_id'))->get();
                                                                            ?>
                                                                            @foreach($jabatan as $jabatan)
                                                                            @if(old('jabatan4_id') == $jabatan->id)
                                                                            <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama_jabatan }}</option>
                                                                            @else
                                                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                                                                            <!-- <option value="{{$divisi->id}}">{{$divisi->nama_divisi}}</option> -->
                                                                            @endif
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
                                    </div>
                                    <small class="text-light fw-medium mt-5">ALAMAT</small>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('provinsi') is-invalid @enderror" id="id_provinsi" name="provinsi">
                                                    <option value=""> Pilih Provinsi </option>
                                                    @foreach($data_provinsi as $data)
                                                    @if(old('provinsi') == $data->code)
                                                    <option value="{{$data->code}}" selected>{{$data->name}}</option>
                                                    @else
                                                    <option value="{{$data->code}}">{{$data->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="id_provinsi">Provinsi</label>
                                            </div>
                                            @error('provinsi')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('kabupaten') is-invalid @enderror" id="id_kabupaten" name="kabupaten">
                                                    <option value=""> Pilih Kabupaten / Kota</option>
                                                    <?php
                                                    $kabupaten = App\Models\Cities::where('province_code', old('provinsi'))->get();
                                                    ?>
                                                    @foreach($kabupaten as $kabupaten)
                                                    @if(old('kabupaten') == $kabupaten->code)
                                                    <option value="{{ $kabupaten->code }}" selected>{{ $kabupaten->name }}</option>
                                                    @else
                                                    <option value="{{$kabupaten->code}}">{{$kabupaten->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for=" id_kabupaten">Kabupaten</label>
                                            </div>
                                            @error('kabupaten')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('kecamatan') is-invalid @enderror" id="id_kecamatan" name="kecamatan">
                                                    <option value=""> Pilih kecamatan</option>
                                                    <?php
                                                    $kecamatan = App\Models\District::where('city_code', old('kabupaten'))->get();
                                                    ?>
                                                    @foreach($kecamatan as $kecamatan)
                                                    @if(old('kecamatan') == $kecamatan->code)
                                                    <option value="{{ $kecamatan->code }}" selected>{{ $kecamatan->name }}</option>
                                                    @else
                                                    <option value="{{$kecamatan->code}}">{{$kecamatan->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="id_kecamatan">kecamatan</label>
                                            </div>
                                            @error('kecamatan')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('desa') is-invalid @enderror" id="id_desa" name="desa">
                                                    <option value=""> Pilih Desa</option>
                                                    <?php
                                                    $desa = App\Models\Village::where('district_code', old('kecamatan'))->get();
                                                    ?>
                                                    @foreach($desa as $desa)
                                                    @if(old('desa') == $desa->code)
                                                    <option value="{{ $desa->code }}" selected>{{ $desa->name }}</option>
                                                    @else
                                                    <option value="{{$desa->code}}">{{$desa->name}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="id_desa">Desa</label>
                                            </div>
                                            @error('desa')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="rt" name="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="Masukkan RT" value="{{ old('rt') }}" />
                                                <label for="rt">RT</label>
                                            </div>
                                            @error('rt')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="rw" name="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="Masukkan RW" value="{{ old('rw') }}" />
                                                <label for="rw">RW</label>
                                            </div>
                                            @error('rw')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" value="{{ old('alamat') }}"></textarea>
                                                <label for="alamat">Keterangan Alamat(Jalan / Dusun)</label>
                                            </div>
                                            @error('alamat')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <small class="text-light fw-medium mt-5">CUTI</small>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="kuota_cuti" name="kuota_cuti" class="form-control @error('kuota_cuti') is-invalid @enderror" placeholder="Masukkan Cuti Tahunan" value="{{ old('kuota_cuti') }}" />
                                                <label for="kuota_cuti">Kuota Cuti Tahunan</label>
                                            </div>
                                            @error('kuota_cuti')
                                            <p class="alert alert-danger">{{$message}}</p>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_import_karyawan" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <form method="post" action="{{ url('/karyawan/ImportKaryawan/'.$holding) }}" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title" id="backDropModalTitle">Import Karyawan</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="file" id="file_excel" name="file_excel" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="form-control" placeholder="Masukkan File" />
                                                <label for="file_excel">File Excel</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <a href="{{asset('')}}" type="button" download="" class="btn btn-sm btn-primary"> Download Format Excel</a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="modal_export_karyawan" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <form method="post" action="{{ url('/karyawan/ImportKaryawan/'.$holding) }}" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title" id="backDropModalTitle">Export Excel Karyawan</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <h6>Download File Excel Data Karyawan</h6>
                                                <a href="{{url('karyawan/ExportKaryawan/'.$holding)}}" type="button" class="btn btn-sm btn-success"> Download Excel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="nav-align-top">
                        <div class="row">
                            <div class="col-6">
                                <ul class="nav nav-pills nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a type=" button" style="width: auto;" class="nav-link active" role="tab" data-bs-toggle="tab" href="#navs-pills-justified-home">
                                            <i class="tf-icons mdi mdi-account-tie me-1"></i><span class="d-none d-sm-block">Karyawan Bulanan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a type="button" style="width: auto;" class="nav-link" role="tab" data-bs-toggle="tab" href="#navs-pills-justified-profile">
                                            <i class="tf-icons mdi mdi-account me-1"></i><span class="d-none d-sm-block">Karyawan Harian</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                                <table class="table" id="table_karyawan_bulanan" style="width: 100%;">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nomor&nbsp;ID</th>
                                            <th>Nama&nbsp;Karyawan</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Penempatan&nbsp;Kerja</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                <table class="table" id="table_karyawan_harian" style="width: 100%;">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No.</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nomor&nbsp;ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Username&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telepon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>Tanggal&nbsp;Masuk</th>
                                            <th>Penempatan&nbsp;Kerja</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
        <!--/ Data Tables -->
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    let holding = window.location.pathname.split("/").pop();
    var table = $('#table_karyawan_bulanan').DataTable({
        pageLength: 50,
        "scrollY": true,
        "scrollX": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('karyawan_bulanan-datatable') }}" + '/' + holding,
        },
        columns: [{
                data: "id",

                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'nomor_identitas_karyawan',
                name: 'nomor_identitas_karyawan'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'telepon',
                name: 'telepon'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'nama_divisi',
                name: 'nama_divisi'
            },
            {
                data: 'nama_jabatan',
                name: 'nama_jabatan'
            },
            {
                data: 'penempatan_kerja',
                name: 'penempatan_kerja'
            },
            {
                data: 'option',
                name: 'option'
            },
        ],
        order: [
            [2, 'asc']
        ]
    });
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        table.columns.adjust().draw().responsive.recalc();
        // table.draw();
    })
    var table1 = $('#table_karyawan_harian').DataTable({
        pageLength: 50,
        "scrollY": true,
        "scrollX": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('karyawan_harian-datatable') }}" + '/' + holding,
        },
        columns: [{
                data: "id",

                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'nomor_identitas_karyawan',
                name: 'nomor_identitas_karyawan'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'telepon',
                name: 'telepon'
            },
            {
                data: 'detail_alamat',
                name: 'detail_alamat'
            },
            {
                data: 'tgl_join',
                name: 'tgl_join'
            },
            {
                data: 'penempatan_kerja',
                name: 'penempatan_kerja'
            },
            {
                data: 'option',
                name: 'option'
            },
        ],
        order: [
            [2, 'asc']
        ]
    });
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        table1.columns.adjust().draw().responsive.recalc();
        // table.draw();
    })
</script>
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
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_divisi')}}",
                data: {
                    holding: holding,
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
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_bagian')}}",
                data: {
                    holding: holding,
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
        $('#id_divisi1').on('change', function() {
            let id_divisi = $('#id_divisi1').val();
            // console.log(id_divisi);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_bagian')}}",
                data: {
                    holding: holding,
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_bagian1').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi2').on('change', function() {
            let id_divisi = $('#id_divisi2').val();
            // console.log(id_divisi);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_bagian')}}",
                data: {
                    holding: holding,
                    id_divisi: id_divisi,
                },
                cache: false,

                success: function(msg) {
                    $('#id_bagian2').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi3').on('change', function() {
            let id_divisi = $('#id_divisi3').val();
            // console.log(id_divisi);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_bagian')}}",
                data: {
                    holding: holding,
                    id_divisi: id_divisi,
                },
                cache: false,

                success: function(msg) {
                    $('#id_bagian3').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_divisi4').on('change', function() {
            let id_divisi = $('#id_divisi4').val();
            // console.log(id_divisi);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_bagian')}}",
                data: {
                    holding: holding,
                    id_divisi: id_divisi
                },
                cache: false,

                success: function(msg) {
                    $('#id_bagian4').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_bagian').on('change', function() {
            let id_bagian = $('#id_bagian').val();
            // console.log(id_bagian);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    holding: holding,
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
        $('#id_bagian1').on('change', function() {
            let id_bagian = $('#id_bagian1').val();
            // console.log(id_bagian);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    holding: holding,
                    id_bagian: id_bagian
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
        $('#id_bagian2').on('change', function() {
            let id_bagian = $('#id_bagian2').val();
            // console.log(id_bagian);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    holding: holding,
                    id_bagian: id_bagian
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
        $('#id_bagian3').on('change', function() {
            let id_bagian = $('#id_bagian3').val();
            // console.log(id_bagian);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    holding: holding,
                    id_bagian: id_bagian
                },
                cache: false,

                success: function(msg) {
                    $('#id_jabata3').html(msg);
                },
                error: function(data) {
                    console.log('error:', data)
                },

            })
        })
        $('#id_bagian4').on('change', function() {
            let id_bagian = $('#id_bagian4').val();
            // console.log(id_bagian);
            let holding = '{{$holding}}';
            $.ajax({
                type: 'GET',
                url: "{{url('karyawan/get_jabatan')}}",
                data: {
                    holding: holding,
                    id_bagian: id_bagian
                },
                cache: false,

                success: function(msg) {
                    $('#id_jabata4').html(msg);
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
    });
</script>
<script>
    let kategori = '{{old("kategori")}}';
    if (kategori == 'Karyawan Bulanan') {
        $('#form_departemen').show();
        $('#form_bagian_jabatan').show();
        $('#form_jabatan_more').show();
        $('#form_lama_kotrak').show();
        $('#form_kontrak_kerja').show();
        $('#form_level_site').show();
    } else {
        $('#form_departemen').hide();
        $('#form_bagian_jabatan').hide();
        $('#form_jabatan_more').hide();
        $('#form_lama_kotrak').hide();
        $('#form_kontrak_kerja').hide();
        $('#form_tgl_kontrak_kerja').hide();
        $('#form_level_site').hide();
    }
    $(document).on("click", "#btndetail_karyawan", function() {
        let id = $(this).data('id');
        let holding = $(this).data("holding");
        console.log(holding);
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
    $('#kategori').change(function() {
        var value = $(this).val();
        if (value == 'Karyawan Bulanan') {
            $('#form_departemen').show();
            $('#form_bagian_jabatan').show();
            $('#form_jabatan_more').show();
            $('#form_lama_kotrak').show();
            $('#form_kontrak_kerja').show();
            $('#form_level_site').show();
        } else if (value == 'Karyawan Harian') {
            $('#form_departemen').hide();
            $('#form_bagian_jabatan').hide();
            $('#form_jabatan_more').hide();
            $('#form_lama_kotrak').hide();
            $('#form_kontrak_kerja').hide();
            $('#form_level_site').hide();
        }

    });
    $('#lama_kontrak_kerja').change(function() {
        var value = $(this).val();
        console.log(value);
        if (value == 'Tetap') {
            $('#form_tgl_kontrak_kerja').hide();
        } else {
            $('#form_tgl_kontrak_kerja').show();
        }

    });
    $('#foto_karyawan').change(function() {

        let reader = new FileReader();
        console.log(reader);
        reader.onload = (e) => {

            $('#template_foto_karyawan').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

    });
    $(document).on("click", "#btn_mapping_shift", function() {
        // console.log('ok');
        let id = $(this).data('id');
        let holding = $(this).data("holding");
        let url = "{{ url('/karyawan/shift/')}}" + '/' + id + '/' + holding;
        $.ajax({
            url: url,
            method: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                window.location.assign(url);
            },
            error: function(data) {
                console.log('error:', data)
            },

        })
    });
    $(document).on("click", "#btn_edit_password", function() {
        let id = $(this).data('id');
        let holding = $(this).data("holding");
        // console.log(holding);
        let url = "{{ url('/karyawan/edit-password/')}}" + '/' + id + '/' + holding;
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
    $(document).on('click', '#btn_delete_karyawan', function() {
        var id = $(this).data('id');
        let holding = $(this).data("holding");
        console.log(id);
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu tidak dapat mengembalikan data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('/karyawan/delete/') }}" + '/' + id + '/' + holding,
                    type: "GET",
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data anda berhasil di hapus.',
                            icon: 'success',
                            timer: 1500
                        })
                        $('#table_karyawan_bulanan').DataTable().ajax.reload();
                        $('#table_karyawan_harian').DataTable().ajax.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Cancelled!',
                    text: 'Your data is safe :',
                    icon: 'error',
                    timer: 1500
                })
            }
        });

    });
</script>
@endsection