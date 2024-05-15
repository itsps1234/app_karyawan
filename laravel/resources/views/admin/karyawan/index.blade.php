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
                                    <div class="small mb-1">Karyawan Office</div>
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
                                    <div class="small mb-1">Karyawan Shift</div>
                                    <h5 class="mb-0">{{$karyawan_shift}}&nbsp;Orang</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-5">
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#modal_tambah_karyawan"><i class="menu-icon tf-icons mdi mdi-plus"></i>Tambah</button>
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
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK" value="{{ old('nik') }}" />
                                                <label for="nik">NIK</label>
                                            </div>
                                            @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama" value="{{ old('name') }}" />
                                                <label for="name">Nama</label>
                                            </div>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="fullname" name="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Masukkan Fullname" value="{{ old('fullname') }}" />
                                                <label for="fullname">Fullname</label>
                                            </div>
                                            @error('fullname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="motto" name="motto" class="form-control @error('motto') is-invalid @enderror" placeholder="Masukkan motto" value="{{ old('motto') }}" />
                                                <label for="motto">Motto</label>
                                            </div>
                                            @error('motto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email" value="{{ old('email') }}" />
                                                <label for="email">Email</label>
                                            </div>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="telepon" name="telepon" class="form-control @error('telepon') is-invalid @enderror" placeholder="Masukkan Telepon" value="{{ old('telepon') }}" />
                                                <label for="telepon">Telepon</label>
                                            </div>
                                            @error('telepon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" placeholder="Masukkan Tempat Lahir" value="{{ old('tempat_lahir') }}" />
                                                <label for="tempat_lahir">Tempat Lahir</label>
                                            </div>
                                            @error('tempat_lahir')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror" value="{{ old('tgl_lahir') }}" />
                                                <label for="tgl_lahir">Tanggal Lahir</label>
                                            </div>
                                            @error('tgl_lahir')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="date" id="tgl_join" name="tgl_join" class="form-control @error('tgl_join') is-invalid @enderror" value="{{ old('tgl_join') }}" />
                                                <label for="tgl_join">Tanggal Join Perusahaan</label>
                                            </div>
                                            @error('tgl_join')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
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
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password" value="{{ old('password') }}" />
                                                <label for="password">Password</label>
                                            </div>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
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
                                                <label for="gender">gender</label>
                                            </div>
                                            @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
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
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
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
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="nomor_rekening" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror" placeholder="Masukkan Nomor Rekening" value="{{ old('nomor_rekening') }}" />
                                                <label for="nomor_rekening">Nomor Rekening</label>
                                            </div>
                                            @error('nomor_rekening')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="npwp" name="npwp" class="form-control @error('npwp') is-invalid @enderror" placeholder="Masukkan NPWP" value="{{ old('npwp') }}" />
                                                <label for="npwp">NPWP</label>
                                            </div>
                                            @error('npwp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
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
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select name="addmore[0][divisi_id]" id="id_divisi" class="form-control  @error('addmore[0][divisi_id]') is-invalid @enderror">
                                                </select>
                                                <label for=" id_divisi">Divisi</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select name="addmore[0][jabatan_id]" id="id_jabatan" class="form-control @error('addmore[0][jabatan_id]') is-invalid @enderror">
                                                </select>
                                                <label for=" id_jabatan">Jabatan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
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
                                                                        <select name="addmore[1][divisi_id]" id="id_divisi1" class="form-control">
                                                                        </select>
                                                                        <label for=" id_divisi1">Divisi 2</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[1][jabatan_id]" id="id_jabatan1" class="form-control">
                                                                        </select>
                                                                        <label for=" id_jabatan1">Jabatan 2</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2 mt-2">
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[2][divisi_id]" id="id_divisi2" class="form-control">
                                                                        </select>
                                                                        <label for=" id_divisi2">Divisi 3</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[2][jabatan_id]" id="id_jabatan2" class="form-control">
                                                                        </select>
                                                                        <label for=" id_jabatan2">Jabatan 3</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2 mt-2">
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[3][divisi_id]" id="id_divisi3" class="form-control">
                                                                        </select>
                                                                        <label for=" id_divisi3">Divisi 4</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[3][jabatan_id]" id="id_jabatan3" class="form-control">
                                                                        </select>
                                                                        <label for=" id_jabatan3">Jabatan 4</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-2 mt-2">
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[4][divisi_id]" id="id_divisi4" class="form-control">
                                                                        </select>
                                                                        <label for=" id_divisi4">Divisi 5</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="addmore[4][jabatan_id]" id="id_jabatan4" class="form-control">
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
                                        </div>
                                        <div class="col mb-2">
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
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" readonly id="kontrak_kerja" name="kontrak_kerja" class="form-control @error('kontrak_kerja') is-invalid @enderror" placeholder="Masukkan Kontrak" value="@if($holding =='sp')CV. SUMBER PANGAN @elseif($holding =='sps') PT. SURYA PANGAN SEMESTA @elseif($holding =='sip') CV. SURYA INTI PANGAN  @endif" />
                                                <label for="kontrak_kerja">Kontrak Kerja</label>
                                            </div>
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
                                        </div>
                                    </div>
                                    <small class="text-light fw-medium mt-5">ALAMAT</small>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('provinsi') is-invalid @enderror" id="id_provinsi" name="provinsi">
                                                    <option value=""> Pilih Provinsi </option>
                                                    @foreach($data_provinsi as $data)
                                                    <option value="{{$data->code}}">{{$data->name}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="id_provinsi">Provinsi</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('kabupaten') is-invalid @enderror" id="id_kabupaten" name="kabupaten">
                                                    <option value=""> Pilih Kabupaten / Kota</option>
                                                </select>
                                                <label for="id_kabupaten">Kabupaten</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('kecamatan') is-invalid @enderror" id="id_kecamatan" name="kecamatan">
                                                    <option value=""> Pilih kecamatan</option>
                                                </select>
                                                <label for="id_kecamatan">kecamatan</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('desa') is-invalid @enderror" id="id_desa" name="desa">
                                                    <option value=""> Pilih Desa</option>
                                                </select>
                                                <label for="id_desa">Desa</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="rt" name="rt" class="form-control @error('rt') is-invalid @enderror" placeholder="Masukkan RT" value="{{ old('rt') }}" />
                                                <label for="rt">RT</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="rw" name="rw" class="form-control @error('rw') is-invalid @enderror" placeholder="Masukkan RW" value="{{ old('rw') }}" />
                                                <label for="rw">RW</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan Alamat" value="{{ old('alamat') }}" />
                                                <label for="alamat">Keterangan Alamat(Jalan / Dusun)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-light fw-medium mt-5">CUTI</small>
                                    <div class="row g-2 mt-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number" id="kuota_cuti" name="kuota_cuti" class="form-control @error('kuota_cuti') is-invalid @enderror" placeholder="Masukkan Cuti Tahunan" value="{{ old('kuota_cuti') }}" />
                                                <label for="kuota_cuti">Kuota Cuti Tahunan</label>
                                            </div>
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
                    <table class="table" id="table_karyawan">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>NPWP</th>
                                <th>Alamat</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                    </table>
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
    var table = $('#table_karyawan').DataTable({
        "scrollY": true,
        "scrollX": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('karyawan-datatable') }}" + '/' + holding,
        },
        columns: [{
                data: "id",

                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'telepon',
                name: 'telepon'
            },
            {
                data: 'npwp',
                name: 'npwp'
            },
            {
                data: 'detail_alamat',
                name: 'detail_alamat'
            },
            {
                data: 'option',
                name: 'option'
            },
        ]
    });
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
    });
</script>
<script>
    $(document).on("click", "#btndetail_karyawan", function() {
        let id = $(this).data('id');
        // console.log(id);
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
                        $('#table_karyawan').DataTable().ajax.reload();
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