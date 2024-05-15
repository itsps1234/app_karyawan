@extends('users.layouts.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')

@if($shift_karyawan->count() > 0)
@foreach ($shift_karyawan as $sk)
<?php $skid = $sk->id ?>
<?php $sktanggal = $sk->tanggal ?>
<?php $sknamas = $sk->Shift->nama_shift  ?>
<?php $skjamas = $sk->Shift->jam_masuk ?>
<?php $skjamkel = $sk->Shift->jam_keluar ?>
<?php $skjamab = $sk->jam_absen ?>
<?php $skjampul = $sk->jam_pulang ?>
<?php $skstatus = $sk->status_absen ?>
@endforeach
@else
<?php $skid = "-" ?>
<?php $sktanggal = "-" ?>
<?php $sknamas = "-"  ?>
<?php $skjamas = "-" ?>
<?php $skjamkel = "-" ?>
<?php $skjamab = "-" ?>
<?php $skjampul = "-" ?>
<?php $skstatus = "-" ?>
@endif
<!-- Features -->
<div class="">
    <div class="row m-b20 g-3">
        <div class="col-12">
            <div class="card card-bx card-content bg-primary">
                <div class="card-body">
                    <div class="info">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <form action="{{ url('/home/my-location') }}" method="get">
                                        @csrf
                                        <input type="hidden" name="lat" id="lat2">
                                        <input type="hidden" name="long" id="long2">
                                        <button type="submit" class="btn btn-sm btn-secondary" style="height:10px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FFFFFF" version="1.1" id="Capa_1" width="18" height="18" class="svg-main-icon" viewBox="0 0 395.71 395.71" xml:space="preserve">
                                                <g>
                                                    <path d="M197.849,0C122.131,0,60.531,61.609,60.531,137.329c0,72.887,124.591,243.177,129.896,250.388l4.951,6.738   c0.579,0.792,1.501,1.255,2.471,1.255c0.985,0,1.901-0.463,2.486-1.255l4.948-6.738c5.308-7.211,129.896-177.501,129.896-250.388   C335.179,61.609,273.569,0,197.849,0z M197.849,88.138c27.13,0,49.191,22.062,49.191,49.191c0,27.115-22.062,49.191-49.191,49.191   c-27.114,0-49.191-22.076-49.191-49.191C148.658,110.2,170.734,88.138,197.849,88.138z" />
                                                </g>
                                            </svg>
                                            &nbsp;Lokasi&nbsp;Saya
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <a href="{{url('/absen/data-absensi')}}" class="btn btn-sm btn-secondary" style="height:10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 10C16.4183 10 20 8.20914 20 6C20 3.79086 16.4183 2 12 2C7.58172 2 4 3.79086 4 6C4 8.20914 7.58172 10 12 10Z" fill="#1C274C" />
                                            <path opacity="0.5" d="M4 12V18C4 20.2091 7.58172 22 12 22C16.4183 22 20 20.2091 20 18V12C20 14.2091 16.4183 16 12 16C7.58172 16 4 14.2091 4 12Z" fill="#1C274C" />
                                            <path opacity="0.7" d="M4 6V12C4 14.2091 7.58172 16 12 16C16.4183 16 20 14.2091 20 12V6C20 8.20914 16.4183 10 12 10C7.58172 10 4 8.20914 4 6Z" fill="#1C274C" />
                                        </svg>
                                        &nbsp;Data&nbsp;Absensi
                                    </a>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            @if($shift_karyawan->count() == 0)
                            <div class="card col-lg-12">
                                <div class="mt-5">
                                    <div class="mb-5">
                                        <center>
                                            <h2>Hubungi Admin Untuk Mapping Shift Anda</h2>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            @elseif($skstatus == "Libur")
                            <div class="card col-lg-12">
                                <div class="mt-5">
                                    <div class="mb-5">
                                        <center>
                                            <h2>Hari Ini Anda Libur</h2>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            @elseif($skstatus == "Cuti")
                            <div class="card col-lg-12">
                                <div class="mt-5">
                                    <div class="mb-5">
                                        <center>
                                            <h2>Hari Ini Anda Cuti</h2>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            @else
                            @if($skjamab == null)
                            <form method="post" action="{{ url('/home/absen/masuk/'.$skid) }}">
                                @method('put')
                                @csrf
                                <div class="form">
                                    <center>
                                        <h2 style="color: white">Absen Masuk: </h2>
                                        <div style="margin-top:-60px" class="webcam" id="results"></div>
                                    </center>
                                    <input type="hidden" name="jam_absen" value="{{ date('H:i:s') }}">
                                    <input type="hidden" name="foto_jam_absen" class="image-tag">
                                    <input type="hidden" name="lat_absen" id="lat">
                                    <input type="hidden" name="long_absen" id="long">
                                    <input type="hidden" name="telat">
                                    <input type="hidden" name="jarak_masuk">
                                    <input type="hidden" name="status_absen">
                                    <input type="hidden" name="keterangan_absensi">
                                    <center>
                                        <button style="background-color: white" type="submit" class="btn btn-lokasisaya" value="Ambil Foto" onClick="take_snapshot()">Masuk</button>
                                    </center>
                                </div>
                            </form>
                            <script type="text/javascript" src="{{ asset('webcamjs/webcam.min.js') }}"></script>
                            <script language="JavaScript">
                                Webcam.set({
                                    width: 240,
                                    height: 320,
                                    image_format: 'jpeg',
                                    jpeg_quality: 50
                                });
                                Webcam.attach('.webcam');
                            </script>
                            <script language="JavaScript">
                                function take_snapshot() {
                                    // take snapshot and get image data
                                    Webcam.snap(function(data_uri) {
                                        $(".image-tag").val(data_uri);
                                        // display results in page
                                        document.getElementById('results').innerHTML =
                                            '<img src="' + data_uri + '"/>';
                                    });
                                }
                            </script>
                            @elseif($skjampul == null)
                            <form method="post" action="{{ url('/home/absen/pulang/'.$skid) }}">
                                @method('put')
                                @csrf
                                <div class="form">
                                    <center>
                                        <h2 style="color: white">Absen Pulang: </h2>
                                        <div style="margin-top:-60px" class="webcam" id="results"></div>
                                    </center>
                                    <input type="hidden" name="jam_pulang" value="{{ date('H:i') }}">
                                    <input type="hidden" name="foto_jam_pulang" class="image-tag">
                                    <input type="hidden" name="lat_pulang" id="lat">
                                    <input type="hidden" name="long_pulang" id="long">
                                    <input type="hidden" name="pulang_cepat">
                                    <input type="hidden" name="jarak_pulang">
                                    <input type="hidden" name="keterangan_absensi">
                                    <center>
                                        <button type="submit" class="btn btn-lokasisaya" style="background-color: white" value="Ambil Foto" onClick="take_snapshot()">Pulang</button>
                                    </center>
                                </div>
                            </form>
                            <script type="text/javascript" src="{{ asset('webcamjs/webcam.min.js') }}"></script>
                            <script language="JavaScript">
                                Webcam.set({
                                    width: 240,
                                    height: 320,
                                    image_format: 'jpeg',
                                    jpeg_quality: 50
                                });
                                Webcam.attach('.webcam');
                            </script>
                            <script language="JavaScript">
                                function take_snapshot() {
                                    // take snapshot and get image data
                                    Webcam.snap(function(data_uri) {
                                        $(".image-tag").val(data_uri);
                                        // display results in page
                                        document.getElementById('results').innerHTML =
                                            '<img src="' + data_uri + '"/>';
                                    });
                                }
                            </script>
                            @else
                            <div class="card col-lg-12">
                                <div class="mt-5">
                                    <div class="mb-5">
                                        <center>
                                            <h2>Anda Sudah Selesai Absen</h2>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection