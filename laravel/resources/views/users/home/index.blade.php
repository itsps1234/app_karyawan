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
@elseif(Session::has('lokaikerjanull'))
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
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Approve.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@endif
<div class="features-box">
    <div class="row m-b20 g-3">
        @foreach ($status_absen_skrg as $data)
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

@if ($dataizin->count() > 0 || $datacuti->count() > 0 || $datapenugasan->count() > 0)
<div class="m-b10">
    <div class="title-bar">
        <h5 class="title">List Pengajuan</h5>
        <div class="swiper-defult-pagination pagination-dots style-1 p-0 swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span></div>
    </div>
    <div class="swiper-btn-center-lr">
        <div class="swiper-container tag-group mt-4 dz-swiper recomand-swiper swiper-container-initialized swiper-container-horizontal swiper-container-ios">
            <div class="swiper-wrapper" id="swiper-wrapper-f27986ff6c88d8d9" aria-live="polite" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 3" style="margin-right: 10px;">
                    @foreach ($dataizin as $dataizin)
                    <a href="{{ url('/izin/approve/'.$dataizin->id) }}">
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
                    </a>
                    @endforeach
                </div>
                @foreach ($datacuti as $datacuti)
                <a href="{{ url('/cuti/approve/'.$datacuti->id) }}">
                    <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 3" style="margin-right: 10px;">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title"><a href="javascript:void(0);">{{ $datacuti->fullname }}</a></h6>
                                    <span class="">{{ $datacuti->nama_cuti }}</span>
                                    <div class="d-flex align-items-center">
                                        @if ($datacuti->status_cuti == 0)
                                        <small class="badge badge-danger">Pending</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
                @foreach ($datapenugasan as $datapenugasan)
                @if($datapenugasan->ttd_id_diminta_oleh == NULL && $datapenugasan->waktu_ttd_id_diminta_oleh == NULL)
                <a href="{{ url('/penugasan/approve/diminta/show/'.$datapenugasan->id) }}">
                    <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 3" style="margin-right: 15px;">
                        <div class="card job-post">
                            <div class="card-body">
                                <div class="media media-80">
                                    <img src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/">
                                </div>
                                <div class="card-info">
                                    <h6 class="title"><a href="javascript:void(0);">{{ $datapenugasan->fullname }}</a></h6>
                                    <span class="" style="font-size: 12px">Penugasan {{ $datapenugasan->penugasan }}</span>
                                    <div class="d-flex align-items-center">
                                        @if ($datapenugasan->status_penugasan == 1)
                                        <small class="badge badge-danger">Pending</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
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
                                    4
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
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
                                    5
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.5" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="#1C274C" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 7.25C12.4142 7.25 12.75 7.58579 12.75 8V11.6893L15.0303 13.9697C15.3232 14.2626 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2626 15.3232 13.9697 15.0303L11.4697 12.5303C11.329 12.3897 11.25 12.1989 11.25 12V8C11.25 7.58579 11.5858 7.25 12 7.25Z" fill="#1C274C" />
                            </svg>
                        </div>
                        <div class="col">
                            <h6 class="title"><a href="javascript:void(0);">Telat</a></h6>
                            <span class="">
                                <h5>
                                    10
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