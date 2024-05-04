@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<style>
    body {
        padding: 15px;
    }

    #note {
        position: absolute;
        left: 50px;
        top: 35px;
        padding: 0px;
        margin: 0px;
        cursor: default;
    }
</style>

<div class="container">
    @if($get_cuti->status_cuti == '0')
    @if($get_cuti->ttd_user != '')
    <div class="alert alert-primary light alert-lg alert-dismissible fade show">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">

            <defs>

                <style>
                    .cls-1 {
                        fill: #77acf1;
                    }

                    .cls-2 {
                        fill: #04009a;
                    }
                </style>

            </defs>

            <g data-name="20. Delivery" id="_20._Delivery">

                <path class="cls-1" d="M10,1h6a0,0,0,0,1,0,0V6.13a.87.87,0,0,1-.87.87H10.87A.87.87,0,0,1,10,6.13V1A0,0,0,0,1,10,1Z" />

                <path class="cls-2" d="M11,26H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H23a3,3,0,0,1,3,3v8a1,1,0,0,1-2,0V3a1,1,0,0,0-1-1H3A1,1,0,0,0,2,3V23a1,1,0,0,0,1,1h8a1,1,0,0,1,0,2Z" />

                <path class="cls-2" d="M7,22H5a1,1,0,0,1,0-2H7a1,1,0,0,1,0,2Z" />

                <path class="cls-2" d="M23,32a9,9,0,1,1,9-9A9,9,0,0,1,23,32Zm0-16a7,7,0,1,0,7,7A7,7,0,0,0,23,16Z" />

                <path class="cls-1" d="M20,27a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42L22,22.59V19a1,1,0,0,1,2,0v4a1,1,0,0,1-.29.71l-3,3A1,1,0,0,1,20,27Z" />

            </g>

        </svg>
        <strong>&nbsp;Tunggu!&nbsp;</strong> Dalam Proses Approve {{$get_cuti->approve_atasan}}
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @else
    @endif
    @elseif($get_cuti->status_cuti == '1')
    @if($get_cuti->ttd_user != '')
    <div class="alert alert-primary light alert-lg alert-dismissible fade show">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">

            <defs>

                <style>
                    .cls-1 {
                        fill: #77acf1;
                    }

                    .cls-2 {
                        fill: #04009a;
                    }
                </style>

            </defs>

            <g data-name="20. Delivery" id="_20._Delivery">

                <path class="cls-1" d="M10,1h6a0,0,0,0,1,0,0V6.13a.87.87,0,0,1-.87.87H10.87A.87.87,0,0,1,10,6.13V1A0,0,0,0,1,10,1Z" />

                <path class="cls-2" d="M11,26H3a3,3,0,0,1-3-3V3A3,3,0,0,1,3,0H23a3,3,0,0,1,3,3v8a1,1,0,0,1-2,0V3a1,1,0,0,0-1-1H3A1,1,0,0,0,2,3V23a1,1,0,0,0,1,1h8a1,1,0,0,1,0,2Z" />

                <path class="cls-2" d="M7,22H5a1,1,0,0,1,0-2H7a1,1,0,0,1,0,2Z" />

                <path class="cls-2" d="M23,32a9,9,0,1,1,9-9A9,9,0,0,1,23,32Zm0-16a7,7,0,1,0,7,7A7,7,0,0,0,23,16Z" />

                <path class="cls-1" d="M20,27a1,1,0,0,1-.71-.29,1,1,0,0,1,0-1.42L22,22.59V19a1,1,0,0,1,2,0v4a1,1,0,0,1-.29.71l-3,3A1,1,0,0,1,20,27Z" />

            </g>

        </svg>
        <strong>&nbsp;Tunggu!&nbsp;</strong> Dalam Proses Approve {{$get_cuti->approve_atasan2}}
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @else
    @endif
    @else
    <div class="alert alert-success light alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <polyline points="9 11 12 14 22 4"></polyline>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
        </svg>
        <strong>Sukses!</strong> Data Sudah Disetujui {{$get_cuti->approve_atasan2}}
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif
    <form class="my-2" method="post" action="{{ url('/cuti/edit-cuti-proses/') }}" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <input type="hidden" name="id" value="{{$get_cuti->id}}">
            <input type="hidden" name="id_user" value="{{Auth::user()->id }}">
            <input type="hidden" name="telp" value="{{$get_cuti->telp}}">
            <input type="hidden" name="email" value="{{$get_cuti->email}}">
            <input type="hidden" name="departements" value="{{$get_cuti->departements_id}}">
            <input type="hidden" name="jabatan" value="{{ $get_cuti->jabatan_id}}">
            <input type="hidden" name="level_jabatan" value="{{$user->level_jabatan}}">
            <input type="hidden" name="divisi" value="{{$get_cuti->divisi_id}}">
            <input type="hidden" name="id_user_atasan" value="{{$get_cuti->id_user_atasan}}">
            <input type="hidden" name="id_user_atasan2" value="{{$get_cuti->id_user_atasan2}}">
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Nama" readonly>
            <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Kuota Cuti Tahunan" readonly>
            <input type="text" class="form-control" name="kuota_cuti" value="{{ $user->kuota_cuti }} Hari" style="font-weight: bold" readonly required>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Kategori Cuti" readonly>
            <select class="form-control" name="cuti" required>
                <option value="">Pilih Cuti...</option>
                @foreach($get_kategori_cuti as $data)
                <option value="{{$data->id}}" {{($data->id == $get_cuti->kategori_cuti_id) ? 'selected' : ''}}>{{$data->nama_cuti}}
                </option>
                @endforeach
            </select>
        </div>
        <div class="input-group">
            @if($user->level_jabatan=='1')
            <input type="text" class="form-control" value="Pengganti" readonly>
            <select class="form-control" name="user_backup" required>
                <option selected value="-">-</option>
            </select>
            @else
            <input type="text" class="form-control" value="Pengganti" readonly>
            <select class="form-control" name="user_backup" required>
                <option value="">Pilih Pengganti...</option>
                @foreach($get_user_backup as $data)
                <option value="{{$data->id}}" {{($data->id == $get_cuti->user_id_backup) ? 'selected' : ''}}>{{$data->fullname}}
                </option>
                @endforeach
            </select>
            @endif
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Tanggal Mulai" readonly>
            <input type="date" name="tanggal_mulai" value="{{$get_cuti->tanggal_mulai}}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Tanggal Selesai" readonly>
            <input type="date" name="tanggal_selesai" value="{{$get_cuti->tanggal_selesai}}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
        </div>
        <div class="input-group">
            <textarea class="form-control" name="keterangan_cuti" style="font-weight: bold" required placeholder="Keterangan">{{$get_cuti->keterangan_cuti}}</textarea>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Approve By 1" readonly>
            <input type="text" class="form-control" name="approve_atasan" value="{{ $get_user_atasan->name }}" readonly>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Approve By 2" readonly>
            <input type="text" class="form-control" name="approve_atasan2" value="{{ $get_user_atasan2->name }}" readonly>
        </div>
        @if($get_cuti->ttd_user=='')
        <div class="input-group">
            <div id="signature-pad" style="border:solid 1px teal; width:100%;height:200px;">
                <div>
                    <div id="note" onmouseover="my_function();"></div>
                    <canvas id="the_canvas" width="auto" height="100px"></canvas>
                    <p class="text-primary" style="text-align: center">Ttd : {{ Auth::user()->fullname }} {{ date('Y-m-d') }}</p>
                    <hr>
                    <div class="text-center">
                        <input type="hidden" id="signature" name="signature">
                        <button type="button" id="clear_btn" class="btn btn-danger btn-rounded" data-action="clear"><i class="fa fa-refresh" aria-hidden="true"> </i> &nbsp; Clear</button>
                        <button type="submit" id="save_btn" class="btn btn-primary btn-rounded" data-action="save-png"><i class="fa fa-save" aria-hidden="true"> </i> &nbsp; Update</button>
                    </div>

                </div>
            </div>
        </div>
        @else
        <div class="text-center" style="margin: 0 auto;">
            <a href="{{ url('cuti/dashboard') }}" class="btn btn-sm btn-primary btn-rounded">
                <i class="fa fa-arrow-left" aria-hidden="true"> </i>
                &nbsp; Kembali
            </a>
        </div>
        @endif
    </form>
</div>
@endsection
@section('js')
{{-- <link rel="stylesheet" href="{{ asset('assets_ttd/libs/css/bootstrap.v3.3.6.css') }}"> --}}
<script type="text/javascript" src="{{ asset('assets_ttd/assets/signature.js') }}"></script>
<script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);

    clearButton.addEventListener("click", function(event) {
        // document.getElementById("note").innerHTML = "The signature should be inside box";
        signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function(event) {
        if (signaturePad.isEmpty()) {
            alert("Please provide signature first.");
            event.preventDefault();
        } else {
            var canvas = document.getElementById("the_canvas");
            var dataUrl = canvas.toDataURL();
            document.getElementById("signature").value = dataUrl;
        }
    });

    function my_function() {
        document.getElementById("note").innerHTML = "";
    }
</script>
@endsection