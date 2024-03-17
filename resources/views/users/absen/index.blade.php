@extends('users.layouts.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<!-- Features -->
<div class="features-box">
    <div class="row m-b20 g-3">
        <div class="col-12">
            <a href="">
                <div class="card card-bx card-content bg-primary">
                    <div class="card-body">
                        <div class="info">
                            <div class="row">
                                <div class="col-6">
                                    <span>Selamat Pagi</span><br>
                                    <span>Dev</span>
                                </div>
                                <div class="col-6">
                                    <span>16 Mar 2024</span><br>
                                    <span>3:38:06 PM</span>
                                </div>
                                <hr>
                                <form method="post" action="{{ url('/absen/masuk/'.$skid) }}">
                                    @method('put')
                                    @csrf
                                    <div class="form-row">
                                        <div class="col"></div>
                                        <div class="col">
                                            <h2>Absen Masuk: </h2>
                                            <div class="webcam" id="results"></div>
                                        </div>
                                        <div class="col">
                                            <input type="hidden" name="jam_absen" value="{{ date('H:i') }}">
                                            <input type="hidden" name="foto_jam_absen" class="image-tag">
                                            <input type="hidden" name="lat_absen" id="lat">
                                            <input type="hidden" name="long_absen" id="long">
                                            <input type="text" name="telat">
                                            <input type="text" name="jarak_masuk">
                                            <input type="text" name="status_absen">
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary" value="Ambil Foto" onClick="take_snapshot()">Masuk</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
