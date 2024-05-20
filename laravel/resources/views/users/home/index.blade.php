@extends('users.layouts.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<!-- {{Auth::user()->id}} -->
<!-- Features -->
@include('sweetalert::alert')
@if(Session::has('absenmasuksuccess'))
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
@elseif(Session::has('login_success'))
<div id="alert_login_success" class="alert alert-success light alert-lg alert-dismissible fade show">
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
@elseif(Session::has('absenmasukerror'))
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
@elseif(Session::has('absenmasukoutradius'))
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
@elseif(Session::has('absenpulangoutradius'))
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
@elseif(Session::has('absenpulangsuccess'))
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
@elseif(Session::has('absenkeluarerror'))
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
@elseif(Session::has('lokasikerjanull'))
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
@elseif(Session::has('approveperdinsukses'))
<div id="alert_approve_penugasan_sukses" class="alert alert-success light alert-lg alert-dismissible fade show">
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
@elseif(Session::has('approvecuti_not_approve'))
<div id="alert_approve_cuti_success" class="alert alert-danger light alert-lg alert-dismissible fade show">
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
@elseif(Session::has('approvecuti_success'))
<div id="alert_approve_cuti_success" class="alert alert-success light alert-lg alert-dismissible fade show">
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
@elseif(Session::has('kontrakkerjaNULL'))
<div id="alert_kontrak_kerja_null" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Kontrak Kerja Anda Kosong. Hubungi HRD
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('penugasan_wilayah_kantor'))
<div id="alert_kontrak_kerja_null" class="alert alert-danger light alert-lg alert-dismissible fade show">
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
@endif
<div class="features-box">
    <div class="row m-b20 g-3">
        @if($status_absen_skrg=='[]')
        <div class="alert alert-warning light alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            <strong>Warning!</strong> User Belum Mapping Shift. Harap Hubungi HRD.
            <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
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
                    <p class="pwa-text">Hubungi HRD atau Admin</p>
                </div>
            </div>
        </div>
        <div class="offcanvas-backdrop pwa-backdrop"></div>
        @else
        @endif
        @foreach ($status_absen_skrg as $data)
        @if ($data->keterangan_absensi == 'ABSENSI PENUGASAN DILUAR WILAYAH KANTOR')
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
        @elseif($data->keterangan_absensi == 'ABSENSI PENUGASAN WILAYAH KANTOR')
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
        @endif
        @if ($data->jam_absen == null && $data->jam_pulang==null)
        <div class="col">
            <a href="{{ url('/home/absen') }}">
                <div class="card card-bx card-content bg-primary">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                            </g>
                        </svg>
                        <div class="info">
                            <p>Absen Masuk <br> <span class="title" style="font-size: 25px" id="jam_masuk"></span></p>
                            <script>
                                setInterval(customClock, 500);

                                function customClock() {
                                    var time = new Date();
                                    var hrs = time.getHours();
                                    var min = time.getMinutes();
                                    var sec = time.getSeconds();
                                    document.getElementById('jam_masuk').innerHTML = hrs + ":" + min + ":" + sec;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                <div class="card card-bx card-content bg-secondary">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M13 12l-.688-4h-.609l-.703 4c-.596.347-1 .984-1 1.723 0 1.104.896 2 2 2s2-.896 2-2c0-.739-.404-1.376-1-1.723zm-1-8c-5.522 0-10 4.477-10 10s4.478 10 10 10 10-4.477 10-10-4.478-10-10-10zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-2-19.819v-2.181h4v2.181c-1.438-.243-2.592-.238-4 0zm9.179 2.226l1.407-1.407 1.414 1.414-1.321 1.321c-.462-.484-.964-.926-1.5-1.328zm-12.679 9.593c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm12 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-6 6c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-4-2c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-8-9c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                            </g>
                        </svg>
                        <div class="info">
                            <p>Absen Pulang <br> <span class="title" style="font-size: 25px">-</span></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @elseif ($data->jam_absen != null && $data->jam_pulang==null)
        <div class="col">
            <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                <div class="card card-bx card-content bg-primary">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                            </g>
                        </svg>
                        <div class="info">
                            <p>Sudah Absen <br> <span class="title" style="font-size: 25px">{{ $data->jam_absen }}</span></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ url('/home/absen') }}">
                <div class="card card-bx card-content bg-secondary">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M13 12l-.688-4h-.609l-.703 4c-.596.347-1 .984-1 1.723 0 1.104.896 2 2 2s2-.896 2-2c0-.739-.404-1.376-1-1.723zm-1-8c-5.522 0-10 4.477-10 10s4.478 10 10 10 10-4.477 10-10-4.478-10-10-10zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-2-19.819v-2.181h4v2.181c-1.438-.243-2.592-.238-4 0zm9.179 2.226l1.407-1.407 1.414 1.414-1.321 1.321c-.462-.484-.964-.926-1.5-1.328zm-12.679 9.593c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm12 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-6 6c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-4-2c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-8-9c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                            </g>
                        </svg>
                        <div class="info">
                            <p>Absen Pulang <br> <span class="title" style="font-size: 25px" id="jam_pulang"></span></p>
                            <script>
                                setInterval(customClock, 500);

                                function customClock() {
                                    var time = new Date();
                                    var hrs = time.getHours();
                                    var min = time.getMinutes();
                                    var sec = time.getSeconds();
                                    document.getElementById('jam_pulang').innerHTML = hrs + ":" + min + ":" + sec;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @elseif ($data->jam_absen != null && $data->jam_pulang != null)
        <div class="col">
            <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                <div class="card card-bx card-content bg-primary">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.848 12.459c.202.038.202.333.001.372-1.907.361-6.045 1.111-6.547 1.111-.719 0-1.301-.582-1.301-1.301 0-.512.77-5.447 1.125-7.445.034-.192.312-.181.343.014l.985 6.238 5.394 1.011z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                            </g>
                        </svg>
                        <div class="info">
                            <p>Sudah Absen <br> <span class="title" style="font-size: 25px">{{ $data->jam_absen }}</span></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{ url('/home/absen') }}" style="pointer-events: none">
                <div class="card card-bx card-content bg-secondary">
                    <div class="card-body">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M13 12l-.688-4h-.609l-.703 4c-.596.347-1 .984-1 1.723 0 1.104.896 2 2 2s2-.896 2-2c0-.739-.404-1.376-1-1.723zm-1-8c-5.522 0-10 4.477-10 10s4.478 10 10 10 10-4.477 10-10-4.478-10-10-10zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-2-19.819v-2.181h4v2.181c-1.438-.243-2.592-.238-4 0zm9.179 2.226l1.407-1.407 1.414 1.414-1.321 1.321c-.462-.484-.964-.926-1.5-1.328zm-12.679 9.593c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm12 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-6 6c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-4-2c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm-8-9c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5zm8 0c0 .276-.224.5-.5.5s-.5-.224-.5-.5.224-.5.5-.5.5.224.5.5z" fill="#fff" fill-rule="nonzero" opacity="0.3" />
                            </g>
                        </svg>
                        <div class="info">
                            <p>Sudah Absen <br> <span class="title" style="font-size: 25px">{{ $data->jam_pulang }}</span></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
        @endforeach
    </div>
</div>
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
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title">{{ $dataizin->fullname }}</h6>
                                    <span class="">{{ $dataizin->izin }}</span>
                                    <div class="d-flex align-items-center">
                                        @if ($dataizin->status_izin == 0)
                                        <small class="badge badge-danger">Pending</small>
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
        <h5 class="title"> Absen&nbsp;Bulan&nbsp;
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
        </h5>
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                </g>
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none">
                                <path d="M20 8.25V18C20 21 18.21 22 16 22H8C5.79 22 4 21 4 18V8.25C4 5 5.79 4.25 8 4.25C8 4.87 8.24997 5.43 8.65997 5.84C9.06997 6.25 9.63 6.5 10.25 6.5H13.75C14.99 6.5 16 5.49 16 4.25C18.21 4.25 20 5 20 8.25Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 4.25C16 5.49 14.99 6.5 13.75 6.5H10.25C9.63 6.5 9.06997 6.25 8.65997 5.84C8.24997 5.43 8 4.87 8 4.25C8 3.01 9.01 2 10.25 2H13.75C14.37 2 14.93 2.25 15.34 2.66C15.75 3.07 16 3.63 16 4.25Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path opacity="0.4" d="M8 13H12" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path opacity="0.4" d="M8 17H16" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none">
                                <g opacity="0.4">
                                    <path d="M9.56055 18V13" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M12 15.5H7" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <path d="M8 2V5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 2V5" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15.8098 3.41992C19.1498 3.53992 20.8398 4.76992 20.9398 9.46992L21.0698 15.6399C21.1498 19.7599 20.1998 21.8299 15.1998 21.9399L9.19983 22.0599C4.19983 22.1599 3.15983 20.1199 3.07983 16.0099L2.93983 9.82992C2.83983 5.12992 4.48983 3.82992 7.80983 3.57992L15.8098 3.41992Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none">
                                <g id="style=doutone">
                                    <g id="clock">
                                        <path id="vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M12 4.75C7.44621 4.75 3.75 8.44621 3.75 13C3.75 17.5538 7.44621 21.25 12 21.25C16.5538 21.25 20.25 17.5538 20.25 13C20.25 8.44621 16.5538 4.75 12 4.75ZM2.25 13C2.25 7.61779 6.61779 3.25 12 3.25C17.3822 3.25 21.75 7.61779 21.75 13C21.75 18.3822 17.3822 22.75 12 22.75C6.61779 22.75 2.25 18.3822 2.25 13Z" fill="#000000" />
                                        <path id="vector (Stroke)_2" fill-rule="evenodd" clip-rule="evenodd" d="M11.667 8.20898C12.0812 8.20898 12.417 8.54477 12.417 8.95898V12.649C12.417 12.771 12.4646 12.9586 12.5772 13.1561C12.6899 13.3536 12.827 13.4899 12.9313 13.5518L12.9333 13.5529L15.7233 15.2179C16.079 15.4302 16.1953 15.8906 15.983 16.2463C15.7708 16.602 15.3103 16.7183 14.9546 16.506L12.1666 14.8422C12.1663 14.842 12.1659 14.8418 12.1656 14.8416C11.7844 14.6154 11.4809 14.2615 11.2742 13.8991C11.0674 13.5364 10.917 13.0939 10.917 12.649V8.95898C10.917 8.54477 11.2528 8.20898 11.667 8.20898Z" fill="#BFBFBF" />
                                        <path id="line (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M17.4379 1.50345C17.7121 1.19304 18.1861 1.16374 18.4965 1.438L22.2434 4.74864C22.5539 5.0229 22.5832 5.49687 22.3089 5.80728C22.0346 6.11769 21.5607 6.14699 21.2503 5.87273L17.5033 2.56209C17.1929 2.28783 17.1636 1.81386 17.4379 1.50345Z" fill="#BFBFBF" />
                                        <path id="line (Stroke)_2" fill-rule="evenodd" clip-rule="evenodd" d="M6.56203 1.50345C6.28776 1.19304 5.81379 1.16374 5.50339 1.438L1.75643 4.74864C1.44602 5.0229 1.41672 5.49687 1.69098 5.80728C1.96524 6.11769 2.43921 6.14699 2.74962 5.87273L6.49658 2.56209C6.80699 2.28783 6.83629 1.81386 6.56203 1.50345Z" fill="#BFBFBF" />
                                    </g>
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
        <table id="datatableHome" class="table table-striped table-hover" style="width: 100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam&nbsp;Masuk</th>
                    <th scope="col">Jam&nbsp;Pulang</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<!-- Categorie End -->
@endsection
@section('js')
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
            $("#alert_approve_cuti_success").remove();
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
</script>
@endsection