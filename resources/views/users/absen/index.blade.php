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
            <a href="">
                <div class="card card-bx card-content bg-primary">
                    <div class="card-body">
                        <div class="info">
                            <div class="row">
                                <form action="{{ url('/home/my-location') }}" method="get">
                                    @csrf
                                    <input type="hidden" name="lat" id="lat2">
                                    <input type="hidden" name="long" id="long2">
                                    <button type="submit" class="btn btn-lokasisaya" style="height:10px;width:100%;">Lihat Lokasi Saya</button>
                                </form>
                                <br><br>
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
                                                    <input type="hidden" name="jam_absen" value="{{ date('H:i') }}">
                                                    <input type="hidden" name="foto_jam_absen" class="image-tag">
                                                    <input type="hidden" name="lat_absen" id="lat">
                                                    <input type="hidden" name="long_absen" id="long">
                                                    <input type="hidden" name="telat">
                                                    <input type="hidden" name="jarak_masuk">
                                                    <input type="hidden" name="status_absen">
                                                    <center>
                                                        <button type="submit" class="btn btn-lokasisaya" value="Ambil Foto" onClick="take_snapshot()">Masuk</button>
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
                                            Webcam.attach( '.webcam' );
                                        </script>
                                        <script language="JavaScript">
                                            function take_snapshot() {
                                                // take snapshot and get image data
                                                Webcam.snap( function(data_uri) {
                                                        $(".image-tag").val(data_uri);
                                                // display results in page
                                                document.getElementById('results').innerHTML =
                                                    '<img src="'+data_uri+'"/>';
                                                } );
                                            }
                                        </script>
                                    @elseif($skjampul == null)
                                        <form method="post" action="{{ url('/absen/pulang/'.$skid) }}">
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
                                                <center>
                                                    <button type="submit" class="btn btn-lokasisaya" value="Ambil Foto" onClick="take_snapshot()">Pulang</button>
                                                </center>
                                            </div>
                                        </form>
                                        <script type="text/javascript" src="{{ url('webcamjs/webcam.min.js') }}"></script>
                                        <script language="JavaScript">
                                            Webcam.set({
                                                width: 240,
                                                height: 320,
                                                image_format: 'jpeg',
                                                jpeg_quality: 50
                                            });
                                            Webcam.attach( '.webcam' );
                                        </script>
                                        <script language="JavaScript">
                                            function take_snapshot() {
                                                // take snapshot and get image data
                                                Webcam.snap( function(data_uri) {
                                                        $(".image-tag").val(data_uri);
                                                // display results in page
                                                document.getElementById('results').innerHTML =
                                                    '<img src="'+data_uri+'"/>';
                                                } );
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
            </a>
        </div>
    </div>
</div>
@endsection
