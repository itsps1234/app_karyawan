@extends('users.layouts.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('alert')
@if(Session::has('absenmasuksuccess'))
<div id="alert_absen_masuk_success" class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Absen Masuk.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('login_success'))
<div id="alert_login_success" class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Login.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('absenmasukerror'))
<div id="alert_absen_masuk_error" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>error!</strong> Anda Gagal Absen Masuk.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('absenmasukoutradius'))
<div id="alert_absenmasukoutradius" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>Error!</strong> Anda Berada Diluar Radius Absen.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="alert alert-info light alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        <strong>Info!</strong> Lokasi Kantor Anda di {{$lokasi_kantor}}
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('absenpulangoutradius'))
<div id="alert_absenpulangoutradius" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>error!</strong> Anda Berada Diluar Radius Absen.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('absen_tidak_masuk'))
<div id="alert_absen_tidak_masuk" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>Maaf!</strong> Anda Dianggap Tidak Masuk.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div id="alert_absen_tidak_masuk1" class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        Dikarenakan Anda Absen Melebihi Ketentuan Jam Masuk.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('absenpulangsuccess'))
<div id="alert_absenpulangsuccess" class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Absen Pulang.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('absenkeluarerror'))
<div id="alert_absenkeluarerror" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>error!</strong> Anda Gagal Absen Pulang.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('lokasikerjanull'))
<div id="alert_lokasikerjanull" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>error!</strong>&nbsp;Lokasi Kerja Anda Kosong. Hubungi HRD
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('latlongnull'))
<div id="alert_latlongnull" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>error!</strong>&nbsp;Lokasi Anda Tidak Teridentifikasi
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('approveperdinsukses'))
<div id="alert_approve_penugasan_sukses" class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Approve Penugasan.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('approvecuti_not_approve'))
<div id="alert_approve_cuti_not_approve" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Tolak Approve Cuti.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('approvecuti_success'))
<div id="alert_approve_cuti_success" class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Approve Cuti.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('approveizin_not_approve'))
<div id="alert_approve_izin_not_approve" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Tolak Approve Izin.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('approveizin_success'))
<div id="alert_approve_izin_success" class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
            <line x1="9" y1="9" x2="9.01" y2="9"></line>
            <line x1="15" y1="9" x2="15.01" y2="9"></line>
        </svg>
        <strong>Success!</strong> Anda Berhasil Approve Izin.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('kontrakkerjaNULL'))
<div id="alert_kontrak_kerja_null" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        &nbsp; Kontrak Kerja Anda Kosong. Hubungi HRD
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('jabatanNULL'))
<div id="alert_jabatan_null" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        &nbsp; Jabatan Anda Kosong. Hubungi HRD
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('penugasan_wilayah_kantor'))
<div class="container" style="margin-top:-5%">
    <div class="alert alert-warning light alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg>
        &nbsp;User Belum Mapping Shift. Harap Hubungi HRD.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif(Session::has('penugasan_wilayah_kantor'))
<div id="alert_kontrak_kerja_null" class="container" style="margin-top:-5%">
    <div class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <strong>Gagal!</strong> Anda Berada Diluar Wilayah Radius Penugasan
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@endif
@if($status_absen_skrg==NULL)
<div class="container" style="margin-top:-5%">
    <div class="alert alert-warning light alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg>
        &nbsp;User Belum Mapping Shift. Harap Hubungi HRD.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@else
@endif
@if($status_absen_skrg==NULL)
@else
@if ($status_absen_skrg->keterangan_absensi == 'ABSENSI PENUGASAN DILUAR WILAYAH KANTOR')
<div class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve">
            <g id="car_x2C__transport_x2C__navigation_x2C__pin_x2C__vehicle">
                <g id="XMLID_268_">
                    <path d="    M29.5,27.5v2c0,0.55-0.45,1-1,1h-1c-0.55,0-1-0.45-1-1v-2" fill="none" id="XMLID_3822_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <line fill="none" id="XMLID_281_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="30.5" x2="16.5" y1="27.5" y2="27.5" />
                    <path d="    M19.5,20.5c8.5,0,11,0.583,11,3v1.188" fill="none" id="XMLID_280_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <path d="    M26.5,25.5v-1c0-0.55,0.45-1,1-1h3v2H26.5z" fill="none" id="XMLID_279_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <path d="    M18.5,23.5h4c1.104,0,2,0.896,2,2l0,0" fill="none" id="XMLID_277_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <path d="    M28.569,21.206L26.82,15.95c-0.181-0.53-0.761-1.02-1.311-1.09c-0.775-0.098-1.973-0.221-3.444-0.295" fill="none" id="XMLID_276_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <g id="XMLID_804_">
                        <path d="     M8.439,1.85C9.254,1.621,10.113,1.5,11,1.5c5.245,0,9.5,4.254,9.5,9.5c0,8.063-9.5,19.5-9.5,19.5S1.5,19.063,1.5,11     c0-2.697,1.125-5.133,2.931-6.861" fill="none" id="XMLID_805_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    </g>
                    <circle cx="11" cy="11" fill="none" id="XMLID_3807_" r="5.5" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <line fill="none" id="XMLID_1915_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="3.5" x2="11" y1="30.5" y2="30.5" />
                    <line fill="none" id="XMLID_2107_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="1.6" x2="1.5" y1="30.5" y2="30.5" />
                    <line fill="none" id="XMLID_732_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="16.5" x2="27.5" y1="30.5" y2="30.5" />
                    <line fill="none" id="XMLID_2200_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="1.6" x2="1.5" y1="30.5" y2="30.5" />
                </g>
                <line fill="none" id="XMLID_171_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="6.577" x2="6.493" y1="2.508" y2="2.563" />
                <line fill="none" id="XMLID_170_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="6.577" x2="6.493" y1="2.508" y2="2.563" />
            </g>
        </svg>
        &nbsp;&nbsp; Hari Ini Anda Sudah Absensi (Dalam Penugasan).
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@elseif($status_absen_skrg->keterangan_absensi == 'ABSENSI PENUGASAN WILAYAH KANTOR')
<div class="container" style="margin-top:-5%">
    <div class="alert alert-success light alert-lg alert-dismissible fade show">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="_x3C_Layer_x3E_" version="1.1" xml:space="preserve">
            <g id="car_x2C__transport_x2C__navigation_x2C__pin_x2C__vehicle">
                <g id="XMLID_268_">
                    <path d="    M29.5,27.5v2c0,0.55-0.45,1-1,1h-1c-0.55,0-1-0.45-1-1v-2" fill="none" id="XMLID_3822_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <line fill="none" id="XMLID_281_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="30.5" x2="16.5" y1="27.5" y2="27.5" />
                    <path d="    M19.5,20.5c8.5,0,11,0.583,11,3v1.188" fill="none" id="XMLID_280_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <path d="    M26.5,25.5v-1c0-0.55,0.45-1,1-1h3v2H26.5z" fill="none" id="XMLID_279_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <path d="    M18.5,23.5h4c1.104,0,2,0.896,2,2l0,0" fill="none" id="XMLID_277_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <path d="    M28.569,21.206L26.82,15.95c-0.181-0.53-0.761-1.02-1.311-1.09c-0.775-0.098-1.973-0.221-3.444-0.295" fill="none" id="XMLID_276_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <g id="XMLID_804_">
                        <path d="     M8.439,1.85C9.254,1.621,10.113,1.5,11,1.5c5.245,0,9.5,4.254,9.5,9.5c0,8.063-9.5,19.5-9.5,19.5S1.5,19.063,1.5,11     c0-2.697,1.125-5.133,2.931-6.861" fill="none" id="XMLID_805_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    </g>
                    <circle cx="11" cy="11" fill="none" id="XMLID_3807_" r="5.5" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" />
                    <line fill="none" id="XMLID_1915_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="3.5" x2="11" y1="30.5" y2="30.5" />
                    <line fill="none" id="XMLID_2107_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="1.6" x2="1.5" y1="30.5" y2="30.5" />
                    <line fill="none" id="XMLID_732_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="16.5" x2="27.5" y1="30.5" y2="30.5" />
                    <line fill="none" id="XMLID_2200_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="1.6" x2="1.5" y1="30.5" y2="30.5" />
                </g>
                <line fill="none" id="XMLID_171_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="6.577" x2="6.493" y1="2.508" y2="2.563" />
                <line fill="none" id="XMLID_170_" stroke="#263238" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" x1="6.577" x2="6.493" y1="2.508" y2="2.563" />
            </g>
        </svg>
        &nbsp;&nbsp;Hari Ini Anda Sedang Penugasan Dikantor Wilayah {{$kantor_penugasan}}.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
@endif
@endif
@endsection
@section('content_top')
<div class="container">
    <div class="row" style="margin-top: -2%;">
        <div class="col-7">
            <div class="main-content">
                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top: -5%;" width="20" height="20" viewBox="0 0 1024 1024" class="icon" version="1.1">
                    <path d="M309.2 584.776h105.5l-49 153.2H225.8c-7.3 0-13.3-6-13.3-13.3 0-2.6 0.8-5.1 2.2-7.3l83.4-126.7c2.5-3.6 6.7-5.9 11.1-5.9z" fill="#FFFFFF" />
                    <path d="M404.5 791.276H225.8c-36.7 0-66.5-29.8-66.5-66.5 0-13 3.8-25.7 11-36.6l83.4-126.7c12.3-18.7 33.1-29.9 55.5-29.9h178.4l-83.1 259.7z m-95.3-206.5c-4.5 0-8.6 2.2-11.1 6l-83.4 126.7c-1.4 2.2-2.2 4.7-2.2 7.3 0 7.3 6 13.3 13.3 13.3h139.9l49-153.2H309.2z" fill="#333333" />
                    <path d="M454.6 584.776h109.6l25.3 153.3H429.3z" fill="#FFFFFF" />
                    <path d="M652.2 791.276H366.6l42.8-259.6h200l42.8 259.6z m-222.9-53.2h160.2l-25.3-153.3H454.6l-25.3 153.3z" fill="#333333" />
                    <path d="M618.6 584.776h105.5c4.5 0 8.6 2.2 11.1 6l83.5 126.7c4 6.1 2.3 14.4-3.8 18.4-2.2 1.4-4.7 2.2-7.3 2.2H667.7l-49.1-153.3z" fill="#FFFFFF" />
                    <path d="M807.6 791.276H628.9l-83.1-259.7h178.4c22.4 0 43.2 11.2 55.5 29.9l83.4 126.7c9.8 14.8 13.2 32.6 9.6 50s-13.7 32.3-28.6 42.1c-10.8 7.2-23.5 11-36.5 11z m-139.9-53.2h139.9c2.6 0 5.1-0.8 7.3-2.2 4-2.6 5.3-6.4 5.7-8.4 0.4-2 0.7-6-1.9-10l-83.4-126.6c-2.5-3.8-6.6-6-11.1-6H618.6l49.1 153.2z" fill="#333333" />
                    <path d="M534.1 639.7C652.5 537.4 711.7 445.8 711.7 365c0-127-102.7-212.1-195-212.1s-195 85.1-195 212.1c0 80.8 59.2 172.3 177.7 274.7 9.9 8.6 24.7 8.6 34.7 0z" fill="#8CAAFF" />
                    <path d="M516.7 672.7c-12.5 0-24.9-4.3-34.8-12.9C356.2 551.2 295.1 454.7 295.1 365c0-142.8 114.6-238.7 221.6-238.7S738.3 222.2 738.3 365c0 89.7-61.1 186.2-186.9 294.8-9.8 8.6-22.3 12.9-34.7 12.9z m0-493.2c-79.7 0-168.4 76.2-168.4 185.5 0 72.3 56.7 158 168.4 254.6C628.5 523 685.1 437.3 685.1 365c0-109.3-88.7-185.5-168.4-185.5z" fill="#333333" />
                    <path d="M516.7 348m-97.5 0a97.5 97.5 0 1 0 195 0 97.5 97.5 0 1 0-195 0Z" fill="#FFFFFF" />
                    <path d="M516.7 472.1c-68.4 0-124.1-55.7-124.1-124.1s55.7-124.1 124.1-124.1S640.8 279.5 640.8 348 585.1 472.1 516.7 472.1z m0-195.1c-39.1 0-70.9 31.8-70.9 70.9 0 39.1 31.8 70.9 70.9 70.9s70.9-31.8 70.9-70.9c0-39.1-31.8-70.9-70.9-70.9z" fill="#333333" />
                </svg>
                <p style="font-size: 8pt; font-weight: bold;">{{Auth::user()->penempatan_kerja}}</p>
            </div>
        </div>
        <div class="col-1">
            <div class="vl" style="border-left: 0.1px solid gray;  height: 80%;"></div>
        </div>
        <div class="col-4">
            <p style="font-size: 8pt; font-weight: bold; text-align: right;">Jam Kerja : </p>
            <div class="main-content" style="margin-top: -22%; float: right;">
                <p style="font-size: 8pt; font-weight:bold;" style="margin-top: -50%;">@if($jam_kerja=='')__-__ @else {{$jam_kerja->shift->jam_masuk}}-{{$jam_kerja->shift->jam_keluar}}@endif&nbsp;</p>
                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top: -20%;" width="17" height="17" viewBox="-4.52 0 69.472 69.472">
                    <g id="Group_4" data-name="Group 4" transform="translate(-651.45 -155.8)">
                        <circle id="Ellipse_4" data-name="Ellipse 4" cx="28.716" cy="28.716" r="28.716" transform="translate(652.95 157.3)" fill="none" stroke="#000000" stroke-miterlimit="10" stroke-width="3" />
                        <path id="Path_11" data-name="Path 11" d="M697.51,186.016H681.667V163.846" fill="none" stroke="#814dff" stroke-miterlimit="10" stroke-width="3" />
                        <circle id="Ellipse_5" data-name="Ellipse 5" cx="28.716" cy="28.716" r="28.716" transform="translate(652.95 166.34)" fill="none" stroke="#000000" stroke-linecap="round" stroke-miterlimit="10" stroke-width="3" opacity="0.15" />
                    </g>
                </svg>
            </div>
        </div>

    </div>
</div>
@endsection
@section('absensi')
@if($status_absen_skrg==NULL)
@else
@if ($status_absen_skrg->jam_absen == null && $status_absen_skrg->jam_pulang==null)
<div class=" container" style="margin-top: -5%;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-6" style="height: 80px;">
                <a href="{{ url('/home/absen') }}">
                    <div class="card card-bx card-content bg-primary" style="height: 100%; width: 100%;">
                        <div class="card-body" style="padding: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: 0; bottom: 0;  margin-left: auto;  margin-right: 0;" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <div class="info" style="color: white;">
                                <p>Absen Masuk <br> <span class="title" style="font-size: 23pt; text-align: center;" id="jam_masuk"></span></p>
                                <script>
                                    setInterval(customClock, 500);

                                    function customClock() {
                                        var time = new Date();
                                        var hrs = (time.getHours() < 10 ? '0' : '') + time.getHours();
                                        var min = (time.getMinutes() < 10 ? '0' : '') + time.getMinutes();
                                        var sec = (time.getSeconds() < 10 ? '0' : '') + time.getSeconds();
                                        document.getElementById('jam_masuk').innerHTML = hrs + ":" + min + ":" + sec;
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6" style="height: 80px;">
                <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                    <div class="card card-bx card-content bg-secondary" style="height: 100%; width: 100%;">
                        <div class="card-body" style="padding: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: 0; bottom: 0;  margin-left: auto;  margin-right: 0;" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M13 12l-.688-4h-.609l-.703 4c-.596.347-1 .984-1 1.723 0 1.104.896 2 2 2s2-.896 2-2c0-.739-.404-1.376-1-1.723zm-1-8c-5.522 0-10 4.477-10 10s4.478 10 10 10 10-4.477 10-10-4.478-10-10-10zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-2-19.819v-2.181h4v2.181c-1.438-.243-2.592-.238-4 0zm9.179 2.226l1.407-1.407 1.414 1.414-1.321 1.321c-.462-.484-.964-.926-1.5-1.328zm-12.679 9.593c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm12 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-6 6c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-4-2c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-8-9c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <div class="info" style="color: white;">
                                <p>Absen Pulang <br> <span class="title" style="font-size: 23pt; text-align: center;">-</span></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@elseif ($status_absen_skrg->jam_absen != null && $status_absen_skrg->jam_pulang==null)
<div class="container" style="margin-top: -5%;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-6" style="height: 80px;">
                <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                    <div class="card card-bx card-content bg-primary" style="height: 100%; width: 100%;">
                        <div class="card-body" style="padding: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: 0; bottom: 0;  margin-left: auto;  margin-right: 0;" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <div class="info" style="color: white;">
                                <p>Sudah Absen <br> <span class="title" style="font-size: 23pt; text-align: center;">{{ $status_absen_skrg->jam_absen }}</span></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6" style="height: 80px;">
                <a href="{{ url('/home/absen') }}">
                    <div class="card card-bx card-content bg-secondary" style="height: 100%; width: 100%;">
                        <div class="card-body" style="padding: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: 0; bottom: 0;  margin-left: auto;  margin-right: 0;" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M13 12l-.688-4h-.609l-.703 4c-.596.347-1 .984-1 1.723 0 1.104.896 2 2 2s2-.896 2-2c0-.739-.404-1.376-1-1.723zm-1-8c-5.522 0-10 4.477-10 10s4.478 10 10 10 10-4.477 10-10-4.478-10-10-10zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-2-19.819v-2.181h4v2.181c-1.438-.243-2.592-.238-4 0zm9.179 2.226l1.407-1.407 1.414 1.414-1.321 1.321c-.462-.484-.964-.926-1.5-1.328zm-12.679 9.593c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm12 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-6 6c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-4-2c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-8-9c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <div class="info" style="color: white;">
                                <p>Absen Pulang <br> <span class="title" style="font-size: 23pt;text-align: center;" id="jam_pulang"></span></p>
                                <script>
                                    setInterval(customClock, 500);

                                    function customClock() {
                                        var time = new Date();
                                        var hrs = (time.getHours() < 10 ? '0' : '') + time.getHours();
                                        var min = (time.getMinutes() < 10 ? '0' : '') + time.getMinutes();
                                        var sec = (time.getSeconds() < 10 ? '0' : '') + time.getSeconds();
                                        document.getElementById('jam_pulang').innerHTML = hrs + ":" + min + ":" + sec;
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@elseif ($status_absen_skrg->jam_absen != null && $status_absen_skrg->jam_pulang != null)
<div class="container" style="margin-top: -5%;">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-6" style="height: 80px;">
                <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                    <div class="card card-bx card-content bg-primary" style="height: 100%; width: 100%;">
                        <div class="card-body" style="padding: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: 0; bottom: 0;  margin-left: auto;  margin-right: 0;" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <div class="info" style="color: white;">
                                <p>Sudah Absen <br> <span class="title" style="font-size: 23pt; text-align: center;">{{ $status_absen_skrg->jam_absen }}</span></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6" style="height: 80px;">
                <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                    <div class="card card-bx card-content bg-secondary" style="height: 100%; width: 100%;">
                        <div class="card-body" style="padding: 4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="position: absolute; right: 0; bottom: 0;  margin-left: auto;  margin-right: 0;" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M13 12l-.688-4h-.609l-.703 4c-.596.347-1 .984-1 1.723 0 1.104.896 2 2 2s2-.896 2-2c0-.739-.404-1.376-1-1.723zm-1-8c-5.522 0-10 4.477-10 10s4.478 10 10 10 10-4.477 10-10-4.478-10-10-10zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-2-19.819v-2.181h4v2.181c-1.438-.243-2.592-.238-4 0zm9.179 2.226l1.407-1.407 1.414 1.414-1.321 1.321c-.462-.484-.964-.926-1.5-1.328zm-12.679 9.593c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm12 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-6 6c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-4-2c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-8-9c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                                </g>
                            </svg>
                            <div class="info" style="color: white;">
                                <p>Sudah Absen <br> <span class="title" style="font-size: 23pt; text-align: center;">{{ $status_absen_skrg->jam_pulang }}</span></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endif

@endsection
@section('content')
@if($status_absen_skrg==NULL)
<div class="offcanvas offcanvas-bottom pwa-offcanvas">
    <div class="container">
        <div class="offcanvas-body small text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 100 100" version="1.1">

                <path style="fill:none;stroke:#444444;stroke-width:2" d="M 1.7,8.5 6.2,6.6 54,1.5 60,50 17,61 11,60 z" />
                <path style="fill:#287293;stroke:#888888" d="M 1.7,8.5 6.2,6.6 54,1.5 56,18 9.7,24 5.3,25 z" />
                <path style="fill:none;stroke:#dddddd" d="M 6.2,7.5 C 7.1,12 8.5,20 9.7,23" />
                <path style="fill:#cccccc;stroke:#888888" d="m 9.7,23 -4.4,1 5.7,36 6,1 c 0,0 43,-10 43,-11 0,0 -4,-33 -4,-33 z" />
                <path style="fill:#eeeeee;stroke:#aaaaaa;" d="m 56,17 c 0,0 2,16 7,23 -2,4 -9,10 -13,10 -4,1 -31,10 -31,10 0,0 -2,-2 -4,-8 L 9.7,23 z" />
                <path style="fill:#dddddd;stroke:#aaaaaa;" d="m 63,40 c -1,0 -2,-2 -2,-2 l -9,12 c 0,0 8,-4 11,-10" />
                <path style="fill:#4444444" d="m 35,25 15,-2 1,3 c 0,0 -6,9 -3,21 l -5,1 c 0,0 -2,-8 3,-21 l -10,2 z m -17,9 c 5,-1 6,-5 6,-8 l 4,0 6,24 -5,2 -5,-18 c 0,0 -1,3 -4,4 z" />

                <circle style="fill:none;stroke:#eeeeee;stroke-width:3" cx="65" cy="65" r="34" />
                <circle style="fill:#444444;fill-opacity:0.7" cx="65" cy="65" r="32" />
                <circle style=";stroke-width:5pt;stroke:#222222;fill:none;" cx="65" cy="65" r="30" />
                <g style="fill:#aaaaaa;">
                    <circle cx="65" cy="35" r="2.5" />
                    <circle cx="95" cy="65" r="2.5" />
                    <circle cx="65" cy="95" r="2.5" />
                    <circle cx="35" cy="65" r="2.5" />
                </g>
                <path style="stroke:#ffffff;stroke-width:4;fill:none;" d="M 65,65 60,42" />
                <path style="stroke:#ffffff;stroke-width:3;fill:none;" d="M 65,65 44,87" />
                <circle style="fill:#ffffff;" cx="65" cy="65" r="3.5" />

            </svg>
            <h5 class="title">MAPPING SHIFT BELUM TERSEDIA</h5>
            <p class="text">Hubungi HRD atau Admin</p>
        </div>
    </div>
</div>
<div class="offcanvas-backdrop pwa-backdrop"></div>
@endif
<!-- {{Auth::user()->id}} -->
<!-- Features -->
@include('sweetalert::alert')
<!-- <div class="features-box">

</div> -->
<!-- Categorie -->
<div class="categorie-section">
    <div class="title-bar">
        <h6 class="dz-title">Layanan</h6>
    </div>
    <ul class="d-flex align-items-center">
        <li class="text-center">
            <a class="nav-link " href="{{ url('/home/absen') }}">
                <span class="dz-icon bg-green light" style="height: 50px; width: 50px; box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 30px; width: 30px;" viewBox="0 0 24 24" fill="none">
                        <path d="M7 3H5C3.89543 3 3 3.89543 3 5V7M3 17V19C3 20.1046 3.89543 21 5 21H7M17 21H19C20.1046 21 21 20.1046 21 19V17M21 7V5C21 3.89543 20.1046 3 19 3H17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <circle cx="12" cy="9" r="3" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        <path d="M17 16C17 13.7909 14.7614 12 12 12C9.23858 12 7 13.7909 7 16" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </span>
            </a>
            <span>Absen</span>
        </li>
        <li class="text-center">
            <a class="nav-link" href="{{ url('/izin/dashboard/') }}">
                <span class="dz-icon bg-skyblue light" style="height: 50px; width: 50px; box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 30px; width: 30px;" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" viewBox="0 0 392.598 392.598" xml:space="preserve">
                        <path style="fill:#56ACE0;" d="M367.62,150.174l-19.265,19.265l-21.463-21.398l19.265-19.265c4.073-4.073,11.249-4.073,15.451,0  l6.012,6.012C371.887,138.99,371.887,145.972,367.62,150.174z" />
                        <path style="fill:#FFFFFF;" d="M242.141,66.586c0-6.012-4.848-10.925-10.925-10.925H32.752c-6.012,0-10.925,4.848-10.925,10.925  v293.301c0,6.012,4.848,10.925,10.925,10.925h198.465c6.012,0,10.925-4.848,10.925-10.925" />
                        <rect x="43.677" y="100.978" style="fill:#FFC10D;" width="176.614" height="248.048" />
                        <g>
                            <path style="fill:#194F82;" d="M194.626,148.17H69.341c-6.012,0-10.925-4.848-10.925-10.925c0-6.012,4.848-10.925,10.925-10.925   h125.285c6.012,0,10.925,4.848,10.925,10.925C205.487,143.321,200.638,148.17,194.626,148.17z" />
                            <path style="fill:#194F82;" d="M194.626,207.257H69.341c-6.012,0-10.925-4.848-10.925-10.925s4.848-10.925,10.925-10.925h125.285   c6.012,0,10.925,4.848,10.925,10.925C205.487,202.343,200.638,207.257,194.626,207.257z" />
                            <path style="fill:#194F82;" d="M383.006,119.337l-6.012-6.012c-6.206-6.206-14.352-9.568-23.079-9.568s-16.937,3.426-23.079,9.568   l-66.909,66.844V66.586c0-18.036-14.675-32.711-32.711-32.711h-7.499V10.925C223.717,4.913,218.869,0,212.792,0   c-6.012,0-10.925,4.848-10.925,10.925V33.81h-32.065V10.925C169.802,4.913,164.954,0,158.877,0   c-6.012,0-10.925,4.848-10.925,10.925V33.81h-32.129V10.925C115.822,4.913,110.974,0,104.897,0C98.82,0,94.166,4.913,94.166,10.925   V33.81H62.036V10.925C62.036,4.913,57.188,0,51.111,0S40.186,4.848,40.186,10.925V33.81h-7.434   C14.715,33.875,0.04,48.485,0.04,66.586v293.301c0,18.036,14.675,32.711,32.711,32.711h198.465   c18.036,0,32.711-14.675,32.711-32.711v-75.184l119.079-119.079C395.741,152.824,395.741,132.137,383.006,119.337z    M242.141,359.887c0,6.012-4.848,10.925-10.925,10.925H32.752c-6.012,0-10.925-4.848-10.925-10.925V66.586   c0-6.012,4.848-10.925,10.925-10.925h7.499v22.885c0,6.012,4.848,10.925,10.925,10.925s10.925-4.848,10.925-10.925V55.661h32.065   v22.885c0,6.012,4.848,10.925,10.925,10.925s10.925-4.848,10.925-10.925V55.661h32.065v22.885c0,6.012,4.848,10.925,10.925,10.925   s10.925-4.848,10.925-10.925V55.661h32.065v22.885c0,6.012,4.848,10.925,10.925,10.925c6.012,0,10.925-4.848,10.925-10.925V55.661   h7.499c6.012,0,10.925,4.848,10.925,10.925v135.37l-42.473,42.473H69.341c-6.012,0-10.925,4.848-10.925,10.925   c0,6.012,4.848,10.925,10.925,10.925h108.477l-6.335,6.335c-1.616,1.616-2.715,3.814-3.103,6.077l-3.685,24.76H69.341   c-6.012,0-10.925,4.848-10.925,10.925c0,6.012,4.848,10.925,10.925,10.925h92.574c0.323,2.327,1.293,4.461,3.038,6.206   c3.168,2.715,6.335,3.685,9.374,3.103l43.378-6.594c2.327-0.323,4.396-1.422,6.077-3.103l18.36-18.36V359.887z M210.853,307.006   l-25.277,3.814l3.814-25.277l122.117-122.117l21.398,21.398L210.853,307.006z M367.62,150.174l-19.265,19.265l-21.463-21.398   l19.265-19.265c4.073-4.073,11.313-4.073,15.451,0l6.012,6.012C371.887,138.99,371.887,145.972,367.62,150.174z" />
                        </g>
                        <polygon style="fill:#56ACE0;" points="332.905,184.824 311.507,163.426 189.325,285.479 185.576,310.756 210.853,307.006 " />
                    </svg>
                </span>
            </a>
            <span>Izin</span>
        </li>
        <li class="text-center">
            <a class="nav-link" href="{{ url('/cuti/dashboard/') }}">
                <span class="dz-icon bg-orange light" style="height: 50px; width: 50px;box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 30px; width: 30px;" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" viewBox="0 0 393.568 393.568" xml:space="preserve">
                        <circle style="fill:#FBD303;" cx="196.784" cy="196.784" r="196.784" />
                        <rect x="80.743" y="52.428" style="fill:#FCFCFD;" width="232.404" height="293.689" />
                        <g>
                            <path style="fill:#4F5565;" d="M105.051,36.978c-3.168,0-5.754,2.651-5.754,5.754v17.842c0,3.168,2.651,5.754,5.754,5.754   c3.168,0,5.754-2.651,5.754-5.754V42.731C110.869,39.564,108.218,36.978,105.051,36.978z" />
                            <path style="fill:#4F5565;" d="M141.77,36.978c-3.168,0-5.754,2.651-5.754,5.754v17.842c0,3.168,2.651,5.754,5.754,5.754   c3.168,0,5.754-2.651,5.754-5.754V42.731C147.523,39.564,144.937,36.978,141.77,36.978z" />
                            <path style="fill:#4F5565;" d="M178.424,36.978c-3.168,0-5.754,2.651-5.754,5.754v17.842c0,3.168,2.65,5.754,5.754,5.754   s5.754-2.651,5.754-5.754V42.731C184.178,39.564,181.592,36.978,178.424,36.978z" />
                            <path style="fill:#4F5565;" d="M215.143,36.978c-3.168,0-5.754,2.651-5.754,5.754v17.842c0,3.168,2.651,5.754,5.754,5.754   c3.103,0,5.754-2.651,5.754-5.754V42.731C220.897,39.564,218.246,36.978,215.143,36.978z" />
                            <path style="fill:#4F5565;" d="M251.798,36.978c-3.168,0-5.754,2.651-5.754,5.754v17.842c0,3.168,2.651,5.754,5.754,5.754   c3.168,0,5.754-2.651,5.754-5.754V42.731C257.552,39.564,254.966,36.978,251.798,36.978z" />
                            <path style="fill:#4F5565;" d="M288.517,36.978c-3.168,0-5.754,2.651-5.754,5.754v17.842c0,3.168,2.651,5.754,5.754,5.754   c3.103,0,5.754-2.651,5.754-5.754V42.731C294.271,39.564,291.62,36.978,288.517,36.978z" />
                        </g>
                        <g>
                            <rect x="99.297" y="96.97" style="fill:#DEDEDF;" width="195.168" height="7.628" />
                            <rect x="99.297" y="118.691" style="fill:#DEDEDF;" width="195.168" height="7.628" />
                            <rect x="168.986" y="176.356" style="fill:#DEDEDF;" width="125.479" height="7.628" />
                            <rect x="168.986" y="195.749" style="fill:#DEDEDF;" width="125.479" height="7.628" />
                            <rect x="168.986" y="215.143" style="fill:#DEDEDF;" width="125.479" height="7.628" />
                            <rect x="99.297" y="241.325" style="fill:#DEDEDF;" width="195.168" height="7.628" />
                            <rect x="99.297" y="260.719" style="fill:#DEDEDF;" width="195.168" height="7.628" />
                            <rect x="99.297" y="280.113" style="fill:#DEDEDF;" width="195.168" height="7.628" />
                            <rect x="99.297" y="300.283" style="fill:#DEDEDF;" width="195.168" height="7.628" />
                        </g>
                        <g>
                            <path style="fill:#BDBDBE;" d="M221.931,164.525h-25.923v-25.923h25.923V164.525z M197.56,162.715h22.562v-22.303H197.56V162.715z" />
                            <path style="fill:#BDBDBE;" d="M257.293,164.525H231.37v-25.923h25.923V164.525z M233.18,162.715h22.562v-22.303H233.18V162.715z" />
                            <path style="fill:#BDBDBE;" d="M292.913,164.525H266.99v-25.923h25.923V164.525z M268.865,162.715h22.562v-22.303h-22.562V162.715z   " />
                        </g>
                        <polygon style="fill:#646B79;" points="217.471,145.713 214.885,143.063 208.808,149.075 203.055,143.063 200.469,145.713   206.222,151.725 200.469,157.479 203.055,160.129 208.808,154.311 214.885,160.129 217.471,157.479 211.459,151.725 " />
                        <g>
                            <polygon style="fill:#F0582F;" points="278.562,159.289 270.675,150.691 273.261,148.299 278.82,154.053 292.913,140.477    295.564,143.063  " />
                            <rect x="99.297" y="175.321" style="fill:#F0582F;" width="47.709" height="47.709" />
                        </g>
                    </svg>
                </span>
            </a>
            <span>Cuti</span>
        </li>
        <li class="text-center">
            <a class="nav-link " href="{{ url('/penugasan/dashboard/') }}">
                <span class="dz-icon bg-red light" style="height: 50px; width: 50px; box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                    <svg fill="#000000" style="height: 30px; width: 30px;" viewBox="0 0 512 512" id="_x30_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g>
                            <path d="M344.969,211.875H167.031c-10.096,0-18.281,8.185-18.281,18.281s8.185,18.281,18.281,18.281v12.188   c0,10.096,8.185,18.281,18.281,18.281l0,0c10.096,0,18.281-8.185,18.281-18.281v-12.188h104.812v12.188   c0,10.096,8.185,18.281,18.281,18.281l0,0c10.096,0,18.281-8.185,18.281-18.281v-12.188c10.096,0,18.281-8.185,18.281-18.281   S355.065,211.875,344.969,211.875z" />
                            <path d="M256,126.562c-20.193,0-36.562,16.37-36.562,36.562h73.125C292.562,142.932,276.193,126.562,256,126.562z" />
                            <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M412,365.438   C412,385.63,395.63,402,375.438,402H136.562C116.37,402,100,385.63,100,365.438v-165.75c0-20.193,16.37-36.562,36.562-36.562   h46.312C182.875,122.739,215.614,90,256,90l0,0c40.386,0,73.125,32.739,73.125,73.125h46.312c20.193,0,36.562,16.37,36.562,36.562   V365.438z" />
                        </g>
                    </svg>
                </span>
            </a>
            <span>Penugasan</span>
        </li>
    </ul>
</div>
<!-- Categorie End -->
@if ($datacuti_tingkat1->count() > 0 || $datacuti_tingkat2->count() > 0|| $dataizin->count() > 0 || $datapenugasan->count() > 0)
<div class="m-b10">
    <div class="title-bar">
        <h5 class="dz-title">List Pengajuan</h5>
        <div class="swiper-default-pagination pagination-dots style-1 p-0">
            @foreach($datapenugasan as $countpenugasan)
            <span class="swiper-pagination-bullet  @if($loop->iteration == 1) swiper-pagination-bullet-active @endif" tabindex="0" role="button" aria-label="Go to slide 2"></span>
            @endforeach
            <!-- <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span>
            <span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span> -->
        </div>
    </div>
    <div class="swiper-btn-center-lr">
        <div class="swiper-container tag-group mt-4 dz-swiper recomand-swiper">
            <div class="swiper-wrapper">
                @foreach ($dataizin as $dataizin)
                <a href="{{ url('/izin/approve/'.$dataizin->id) }}">
                    <div class="swiper-slide">
                        <div class="card job-post" style="box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <div class="media media-80">
                                    @if($dataizin->User->foto_karyawan != '')
                                    <img src="https://karyawan.sumberpangan.store/laravel/storage/app/public/foto_karyawan/{{$dataizin->User->foto_karyawan}}" alt="/">
                                    @else
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                    @endif
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $dataizin->fullname }}</h6>
                                    <span class="">{{ $dataizin->izin }}</span>
                                    <div class="d-flex align-items-center">
                                        @if ($dataizin->status_izin == 1)
                                        <small class="badge badge-danger"><i class="fa fa-spinner"></i>&nbsp;Pending</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @foreach ($datacuti_tingkat1 as $datacuti)
                <a href="{{ url('/cuti/approve/'.$datacuti->id) }}">
                    <div class="swiper-slide">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    @if($datacuti->foto_karyawan!='')
                                    <img src="https://karyawan.sumberpangan.store/laravel/storage/app/public/foto_karyawan/{{$datacuti->foto_karyawan}}" alt="/">
                                    @else
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                    @endif
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $datacuti->name }}</h6>
                                    @if($datacuti->nama_cuti=='Diluar Cuti Tahunan')
                                    <span class="">{{ $datacuti->KategoriCuti->nama_cuti }}</span>
                                    @else
                                    <span class="">{{ $datacuti->nama_cuti }}</span>
                                    @endif
                                    <div class="d-flex align-items-center">
                                        @if ($datacuti->status_cuti == 1)
                                        <small class="badge badge-danger"><i class="fa fa-spinner"></i>&nbsp;Pending</small>
                                        @elseif ($datacuti->status_cuti == 0)
                                        <small class="badge badge-danger"><i class="fa fa-spinner"></i>&nbsp;Pending</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @foreach ($datacuti_tingkat2 as $datacuti)
                <a href="{{ url('/cuti/approve/'.$datacuti->id) }}">
                    <div class="swiper-slide">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    @if($datacuti->foto_karyawan!='')
                                    <img src="https://karyawan.sumberpangan.store/laravel/storage/app/public/foto_karyawan/{{$datacuti->foto_karyawan}}" alt="/">
                                    @else
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                    @endif
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $datacuti->name }}</h6>
                                    @if($datacuti->nama_cuti=='Diluar Cuti Tahunan')
                                    <span class="">{{ $datacuti->KategoriCuti->nama_cuti }}</span>
                                    @else
                                    <span class="">{{ $datacuti->nama_cuti }}</span>
                                    @endif
                                    <div class="d-flex align-items-center">
                                        @if ($datacuti->status_cuti == 2)
                                        <small class="badge badge-danger"><i class="fa fa-spinner"></i>&nbsp;Pending</small>
                                        @elseif ($datacuti->status_cuti == 3)
                                        <small class="badge badge-success"><i class="fa fa-spinner"></i>&nbsp;Selesai</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a @endforeach @foreach ($datapenugasan as $datapenugasan) @if($datapenugasan->status_penugasan == 1)
                @if($datapenugasan->id_user_atasan == auth::user()->id)
                @if($datapenugasan->ttd_id_diminta_oleh == NULL)
                <a href="{{ url('/penugasan/approve/diminta/show/'.$datapenugasan->id) }}">
                    <div class="swiper-slide swiper-slide-active">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $datapenugasan->fullname }}</h6>
                                    <span class="" style="font-size: 12px">Penugasan {{ $datapenugasan->penugasan }}</span>
                                    <div class="d-flex align-items-center">
                                        {{-- @if ($datapenugasan->status_penugasan = 1) --}}
                                        <small class="badge badge-danger">Pending</small>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
                @endif
                @elseif($datapenugasan->status_penugasan == 2)
                @if($datapenugasan->id_user_atasan2 == auth::user()->id)
                @if($datapenugasan->ttd_id_disahkan_oleh == NULL)
                <a href="{{ url('/penugasan/approve/diminta/show/'.$datapenugasan->id) }}">
                    <div class="swiper-slide  swiper-slide-active">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $datapenugasan->fullname }}</h6>
                                    <span class="" style="font-size: 12px">Penugasan {{ $datapenugasan->penugasan }}</span>
                                    <div class="d-flex align-items-center">
                                        {{-- @if ($datapenugasan->status_penugasan = 1) --}}
                                        <small class="badge badge-danger">Pending</small>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
                @endif
                @elseif($datapenugasan->status_penugasan == 3)
                @if($datapenugasan->id_user_hrd==Auth::user()->id)
                @if($datapenugasan->ttd_proses_hrd == NULL)
                <a href="{{ url('/penugasan/approve/diminta/show/'.$datapenugasan->id) }}">
                    <div class="swiper-slide  swiper-slide-active">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $datapenugasan->fullname }}</h6>
                                    <span class="" style="font-size: 12px">Penugasan {{ $datapenugasan->penugasan }}</span>
                                    <div class="d-flex align-items-center">
                                        {{-- @if ($datapenugasan->status_penugasan = 1) --}}
                                        <small class="badge badge-danger">Pending</small>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
                @endif
                @elseif($datapenugasan->status_penugasan == 4)
                @if($datapenugasan->id_user_finance==Auth::user()->id)
                @if($datapenugasan->ttd_proses_finance == NULL)
                <a href="{{ url('/penugasan/approve/diminta/show/'.$datapenugasan->id) }}">
                    <div class="swiper-slide  swiper-slide-active">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $datapenugasan->fullname }}</h6>
                                    <span class="" style="font-size: 12px">Penugasan {{ $datapenugasan->penugasan }}</span>
                                    <div class="d-flex align-items-center">
                                        {{-- @if ($datapenugasan->status_penugasan = 1) --}}
                                        <small class="badge badge-danger">Pending</small>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endif
                @endif
                @endif
                @endforeach
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
</div>
@else
@endif


<!-- Features End -->
<div class="categorie-section">
    <div class="title-bar">
        <h6 class="title"> Absen&nbsp;Bulan&nbsp;
            <select class="month" style="width: max-content;border-radius: 0px; background-color:transparent; color: var(--primary); border: none;outline: none;" name="" id="month">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            &nbsp;{{$thnskrg}}
        </h6>
        <!-- <div class="dropdown d-inline-flex">
            <span class="dropdown-toggle" data-bs-toggle="dropdown">
                Maret
            </span>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Link 1</a>
                <a class="dropdown-item" href="#">Link 2</a>
                <a class="dropdown-item" href="#">Link 3</a>
            </div>
        </div> -->
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card" style="box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 64 64" data-name="Layer 1" id="Layer_1">
                                <defs>
                                    <style>
                                        .cls-1 {
                                            fill: #e7ecef;
                                        }

                                        .cls-2 {
                                            fill: #ffbc0a;
                                        }

                                        .cls-3 {
                                            fill: #8b8c89;
                                        }

                                        .cls-4 {
                                            fill: #bc6c25;
                                        }

                                        .cls-5 {
                                            fill: #a3cef1;
                                        }

                                        .cls-6 {
                                            fill: #dda15e;
                                        }

                                        .cls-7 {
                                            fill: #6096ba;
                                        }

                                        .cls-8 {
                                            fill: #274c77;
                                        }
                                    </style>
                                </defs>
                                <circle class="cls-5" cx="47" cy="17" r="13" />
                                <circle class="cls-2" cx="47" cy="17" r="9" />
                                <path class="cls-6" d="M26.58,38.04l-3,1.29c-1.01,.43-2.15,.43-3.15,0l-3-1.29c-1.47-.63-2.42-2.08-2.42-3.68v-5.36c0-3.31,2.69-6,6-6h2c3.31,0,6,2.69,6,6v5.36c0,1.6-.95,3.05-2.42,3.68Z" />
                                <path class="cls-8" d="M35.14,44c-1.82-1.85-4.35-3-7.14-3h-3c0,1.66-1.34,3-3,3s-3-1.34-3-3h-3c-5.52,0-10,4.48-10,10v7H28l4-14h3.14Z" />
                                <path class="cls-6" d="M17,54h2c1.1,0,2,.9,2,2v2h-4v-4h0Z" />
                                <path class="cls-8" d="M12,30.73c-.29,.17-.64,.27-1,.27-1.1,0-2-.9-2-2s.9-2,2-2c.42,0,.81,.13,1.14,.36" />
                                <path class="cls-8" d="M32,30.73c.29,.17,.64,.27,1,.27,1.1,0,2-.9,2-2s-.9-2-2-2c-.42,0-.81,.13-1.14,.36" />
                                <path class="cls-4" d="M19,38.71l1.42,.61c1.01,.44,2.15,.44,3.16,0l1.42-.61v2.29c0,1.66-1.34,3-3,3s-3-1.34-3-3v-2.29Z" />
                                <polyline class="cls-3" points="28 58 32 44 54 44 50 58" />
                                <path class="cls-8" d="M28.4,26.38h-.01c-.57-.23-1.23-.38-2.06-.38-4.33,0-4.33,4-8.67,4-1.13,0-1.97-.27-2.66-.67v-.33c0-3.31,2.69-6,6-6h2c2.37,0,4.42,1.38,5.39,3.38h.01Z" />
                                <path class="cls-1" d="M29,33.6v-4.6c0-3.31-2.69-6-6-6h-2c-3.31,0-6,2.69-6,6v4h-2c-.55,0-1-.45-1-1v-3c0-5.52,4.48-10,10-10,2.76,0,5.26,1.12,7.07,2.93s2.93,4.31,2.93,7.07v3.18c0,.48-.34,.89-.8,.98l-2.2,.44Z" />
                                <path class="cls-5" d="M41,50c.55,0,1,.45,1,1s-.45,1-1,1v-2Z" />
                                <path class="cls-7" d="M22,35h0c-.11-.54,.24-1.07,.78-1.18l8.22-1.64v-2.86c0-4.79-3.61-8.98-8.38-9.3-5.24-.35-9.62,3.81-9.62,8.98v3h2v2h-2c-1.1,0-2-.9-2-2v-2.68c0-5.72,4.24-10.74,9.94-11.27,6.54-.62,12.06,4.53,12.06,10.95v3.18c0,.95-.67,1.77-1.61,1.96l-8.22,1.64c-.54,.11-1.07-.24-1.18-.78Z" />
                                <path class="cls-7" d="M22,58h-2v-2c0-.55-.45-1-1-1h-7c-.55,0-1-.45-1-1v-4c0-.27,.11-.52,.29-.71l1.29-1.29c.39-.39,1.02-.39,1.41,0h0c.39,.39,.39,1.02,0,1.41l-1,1v2.59h6c1.66,0,3,1.34,3,3v2Z" />
                                <rect class="cls-5" height="2" width="50" x="4" y="58" />
                                <path class="cls-7" d="M47,16c-.55,0-1-.45-1-1s.45-1,1-1,1,.45,1,1h2c0-1.3-.84-2.4-2-2.82v-1.18h-2v1.18c-1.16,.41-2,1.51-2,2.82,0,1.65,1.35,3,3,3,.55,0,1,.45,1,1s-.45,1-1,1-1-.45-1-1h-2c0,1.3,.84,2.4,2,2.82v1.18h2v-1.18c1.16-.41,2-1.51,2-2.82,0-1.65-1.35-3-3-3Z" />
                                <path class="cls-7" d="M44.02,29.66c-.01,.11-.02,.23-.02,.34,0,1.66,1.34,3,3,3s3-1.34,3-3c0-.11-.01-.23-.02-.34-.96,.22-1.95,.34-2.98,.34s-2.02-.12-2.98-.34Z" />
                                <circle class="cls-7" cx="43" cy="36" r="2" />
                                <circle class="cls-7" cx="38" cy="40" r="2" />
                            </svg>
                        </div>
                        <div class="col">
                            <h6 class="title"><a href="javascript:void(0);">Hadir</a></h6>
                            <span class="">
                                <h5 id="count_absen_hadir">
                                    {{$count_absen_hadir}}
                                </h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card" style="box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="50" width="50" version="1.1" id="Capa_1" viewBox="0 0 512 512" xml:space="preserve">
                                <path style="fill:#F5CDB3;" d="M65.782,447.977c-26.082,0.131-47.724-20.174-49.271-46.224L0.089,125.22  C-0.69,112.118,3.68,99.498,12.394,89.682c8.714-9.815,20.729-15.649,33.832-16.426l197.075-11.705  c27.292-1.634,50.364,19.195,51.964,46.14l16.424,276.531c1.608,27.046-19.092,50.358-46.137,51.965L68.477,447.889  C67.576,447.943,66.674,447.973,65.782,447.977z" />
                                <path style="fill:#F0A479;" d="M295.266,107.69c-1.6-26.944-24.672-47.774-51.964-46.14l-96.81,5.75l21.531,374.677l97.531-5.793  c27.046-1.607,47.744-24.918,46.137-51.965L295.266,107.69z" />
                                <path style="fill:#707070;" d="M101.305,139.914c-18.99,0-34.673-14.861-35.705-33.832l-1.902-35.013  C62.63,51.372,77.783,34.477,97.477,33.406l92.497-5.026c19.821-1.088,36.597,14.159,37.663,33.78l1.902,35.012  c1.07,19.695-14.083,36.59-33.78,37.661l-92.497,5.026C102.608,139.896,101.954,139.914,101.305,139.914z" />
                                <path style="fill:#FF8546;" d="M169.37,477.637c-6.666,0-12.984-3.967-15.663-10.518L87.734,305.73  c-3.535-8.647,0.61-18.522,9.257-22.057c8.647-3.533,18.521,0.61,22.057,9.257l65.974,161.388  c3.535,8.647-0.609,18.522-9.257,22.057C173.67,477.232,171.502,477.637,169.37,477.637z" />
                                <path style="fill:#CCF7F5;" d="M481.427,483.674H238.523c-16.858,0-30.573-13.715-30.573-30.574V223.803  c0-4.487,1.783-8.789,4.955-11.959l98.892-98.892c3.172-3.172,7.474-4.955,11.961-4.955h157.669  c16.858,0,30.573,13.715,30.573,30.574V453.1C512,469.958,498.285,483.674,481.427,483.674z" />
                                <g>
                                    <path style="fill:#74D6D0;" d="M481.427,106.913H357.978v375.676h123.449c16.858,0,30.573-13.715,30.573-30.574V137.488   C512,120.629,498.285,106.913,481.427,106.913z" />
                                    <path style="fill:#74D6D0;" d="M481.427,106.913H371.144v375.676h110.283c16.858,0,30.573-13.715,30.573-30.574V137.488   C512,120.629,498.285,106.913,481.427,106.913z" />
                                </g>
                                <path style="fill:#F4F4F4;" d="M334.673,110.29c-2.9-2.952-6.935-4.788-11.399-4.788c-0.024,0-0.344,0.017-0.344,0.017  c-4.178,0.09-7.958,1.776-10.755,4.48l-0.005-0.006L211.646,210.605l0.001,0.001c-2.307,2.771-3.696,6.332-3.696,10.22  c0,8.828,7.157,15.986,15.985,15.986c0.198,0,0.39-0.023,0.586-0.029c0.196,0.008,0.388,0.029,0.586,0.029h97.847  c9.242,0,16.735-7.493,16.735-16.735v-97.847C339.689,117.551,337.766,113.328,334.673,110.29z" />
                                <path style="fill:#E0E0E0;" d="M334.673,110.29c-2.9-2.952-6.935-4.788-11.399-4.788c-0.024,0-0.344,0.017-0.344,0.017  c-4.178,0.09-7.958,1.776-10.755,4.48l-0.005-0.006l-55.835,55.883v70.934h66.619c9.242,0,16.735-7.493,16.735-16.735v-97.847  C339.689,117.551,337.766,113.328,334.673,110.29z" />
                                <g>
                                    <path style="fill:#575757;" d="M451.012,300.21H303.723c-9.341,0-16.914-7.573-16.914-16.914c0-9.341,7.573-16.914,16.914-16.914   h147.289c9.341,0,16.914,7.573,16.914,16.914C467.926,292.637,460.353,300.21,451.012,300.21z" />
                                    <path style="fill:#575757;" d="M451.012,350.529H303.723c-9.341,0-16.914-7.573-16.914-16.914c0-9.341,7.573-16.914,16.914-16.914   h147.289c9.341,0,16.914,7.573,16.914,16.914C467.926,342.956,460.353,350.529,451.012,350.529z" />
                                    <path style="fill:#575757;" d="M451.012,400.848H303.723c-9.341,0-16.914-7.573-16.914-16.914c0-9.341,7.573-16.914,16.914-16.914   h147.289c9.341,0,16.914,7.573,16.914,16.914C467.926,393.275,460.353,400.848,451.012,400.848z" />
                                </g>
                            </svg>
                        </div>
                        <div class="col">
                            <h6 class="title"><a href="javascript:void(0);">Izin</a></h6>
                            <span class="">
                                <h5>
                                    {{$count_absen_izin}}
                                </h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card" style="box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" viewBox="0 0 496 496" xml:space="preserve" width="50" height="50">
                                <path style="fill:#50BB75;" d="M416,462.4c0,19.2-12.8,33.6-32.8,33.6H112.8c-20,0-32.8-14.4-32.8-33.6V52.8  C80,33.6,92.8,16,112.8,16h269.6c20.8,0,33.6,17.6,33.6,36.8V462.4z" />
                                <path style="fill:#0AA06E;" d="M80,52.8C80,33.6,92.8,16,112.8,16h269.6c20.8,0,33.6,17.6,33.6,36.8v409.6  c0,19.2-14.4,33.6-35.2,33.6" />
                                <path style="fill:#40406B;" d="M320,36c0,3.2-4.8,4-8,4H184c-3.2,0-8-0.8-8-4V4.8c0-2.4,4.8-4.8,8-4.8h128c3.2,0,8,2.4,8,4.8V36z" />
                                <rect x="128" y="72" style="fill:#EAEAEA;" width="240" height="376" />
                                <polyline style="fill:#DDDDDD;" points="128,72 368,72 368,448 " />
                                <rect x="160" y="104" style="fill:#A8A8A8;" width="56" height="56" />
                                <g>
                                    <rect x="152" y="184" style="fill:#C4C4C4;" width="192" height="16" />
                                    <rect x="152" y="232" style="fill:#C4C4C4;" width="192" height="16" />
                                    <rect x="152" y="280" style="fill:#C4C4C4;" width="192" height="16" />
                                    <rect x="152" y="328" style="fill:#C4C4C4;" width="192" height="16" />
                                    <rect x="152" y="376" style="fill:#C4C4C4;" width="88" height="16" />
                                </g>
                                <polygon style="fill:#F15249;" points="344,376 320,376 320,360 296,360 296,376 272,376 272,400 296,400 296,424 320,424 320,400   344,400 " />
                                <rect x="248" y="112" style="fill:#E88610;" width="96" height="32" />
                            </svg>
                        </div>
                        <div class="col">
                            <h6 class="title"><a href="javascript:void(0);">Sakit</a></h6>
                            <span class="">
                                <h5>
                                    {{$count_absen_sakit}}
                                </h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card" style="box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.1);">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="-10.98 0 84.878 84.878">
                                <g id="time_cronometer" data-name="time cronometer" transform="translate(-873.556 -236.194)">
                                    <path id="Path_120" data-name="Path 120" d="M905.016,262.253a27.362,27.362,0,1,0,27.358,27.358A27.357,27.357,0,0,0,905.016,262.253Z" fill="#f4f4f4" />
                                    <path id="Path_121" data-name="Path 121" d="M905.016,236.194a10.863,10.863,0,1,0,10.859,10.862A10.869,10.869,0,0,0,905.016,236.194Zm0,19.774a8.912,8.912,0,1,1,8.91-8.912A8.91,8.91,0,0,1,905.016,255.968Z" fill="#163844" />
                                    <path id="Path_122" data-name="Path 122" d="M930.582,289.611a25.571,25.571,0,1,1-25.566-25.566A25.564,25.564,0,0,1,930.582,289.611Z" fill="#27b7ff" />
                                    <path id="Path_123" data-name="Path 123" d="M905.016,258.151a31.46,31.46,0,1,0,31.461,31.46A31.455,31.455,0,0,0,905.016,258.151Zm0,58.826a27.362,27.362,0,1,1,27.358-27.366A27.36,27.36,0,0,1,905.016,316.977Z" fill="#163844" />
                                    <path id="Path_124" data-name="Path 124" d="M879.871,257.257l-3.808,3.8a1.841,1.841,0,0,0,0,2.605l5.26,5.261a31.625,31.625,0,0,1,6.9-5.917l-5.751-5.752A1.841,1.841,0,0,0,879.871,257.257Zm54.093,3.8-3.8-3.8a1.846,1.846,0,0,0-2.609,0l-5.752,5.752a31.718,31.718,0,0,1,6.9,5.917l5.26-5.257A1.849,1.849,0,0,0,933.964,261.06Z" fill="#576d78" />
                                    <path id="Path_125" data-name="Path 125" d="M887.755,274.2,902.1,288.652l3.706,1.891.482.434,2.3,4.731,1.314-1.462h0l1.909-2.13-5.255-1.767-2.573-3.774Z" fill="#163844" />
                                    <path id="Path_126" data-name="Path 126" d="M909.315,289.611a4.3,4.3,0,1,1-4.3-4.3A4.306,4.306,0,0,1,909.315,289.611Z" fill="#f4f4f4" />
                                    <path id="Path_127" data-name="Path 127" d="M908.809,251.808h-7.585a1.841,1.841,0,0,0-1.843,1.845v5.031a30.054,30.054,0,0,1,11.27,0v-5.031A1.848,1.848,0,0,0,908.809,251.808Z" fill="#576d78" />
                                </g>
                            </svg>
                        </div>
                        <div class="col">
                            <h6 class="title"><a href="javascript:void(0);">Telat</a></h6>
                            <span class="">
                                <h5>
                                    {{$count_absen_telat}}
                                </h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Categorie -->
<div class="categorie-section">
    <div class="title-bar">
        <h5 class="dz-title">1 Minggu Terakhir</h5>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table" id="datatableHome" style="width:100%;">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Masuk</th>
                        <th scope="col">Pulang</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Categorie End -->
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        load_data();

        function load_data(filter_month = '') {
            console.log(filter_month);
            var table1 = $('#datatableHome').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                "bPaginate": false,
                searching: false,
                ajax: {
                    url: "{{ route('datatableHome') }}",
                    data: {
                        filter_month: filter_month,
                    }
                },
                columns: [{
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk'
                    },
                    {
                        data: 'jam_absen',
                        name: 'jam_absen'
                    },
                    {
                        data: 'jam_pulang',
                        name: 'jam_pulang'
                    },
                    {
                        data: 'status_absen',
                        name: 'status_absen'
                    },
                ],
                order: [
                    [0, 'DESC']
                ]
            });
        }

        function load_absensi(filter_month = '') {
            $.ajax({
                url: "{{route('get_count_absensi_home')}}",
                data: {
                    filter_month: filter_month,
                },
                type: "GET",
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    $('#count_absen_hadir').html(data);
                    console.log(data)
                }
            });
        }
        $('#month').change(function() {
            filter_month = $(this).val();
            console.log(filter_month);
            $('#datatableHome').DataTable().destroy();
            load_data(filter_month);
            load_absensi(filter_month);


        })
    });
</script>
<script>
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_kontrak_kerja_null").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_jabatan_null").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absen_tidak_masuk").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absen_tidak_masuk1").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absenpulangsuccess").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_approve_cuti_success").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_approve_cuti_not_approve").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_approve_izin_success").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_approve_izin_not_approve").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_login_success").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_approve_penugasan_sukses").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_lokasikerjanull").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_latlongnull").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absenkeluarerror").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absen_masuk_success").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absen_masuk_error").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absenpulangoutradius").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_absenmasukoutradius").remove();
        }, 7000); // 7 secs

    });
</script>
@endsection