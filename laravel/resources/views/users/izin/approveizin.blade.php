@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<script type="text/javascript" src="{{ asset('assets_ttd/assets/signature.js') }}"></script>
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
    <form class="my-2" method="post" action="{{ url('/izin/approve/proses/'.$data->id) }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="input-group">
            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
            <input type="hidden" name="telp" value="{{ $user->telepon }}">
            <input type="hidden" name="email" value="{{ $user->email }}">
            <input type="hidden" name="departements" value="{{ $user->dept_id }}">
            <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}">
            <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id="">
            {{-- <input type="hidden" name="id_user_atasan" value="{{ $getUserAtasan->id }}"> --}}
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Nama Pemohon" readonly>
            <input type="text" class="form-control" name="fullname" value="{{ $data->fullname }}" style="font-weight: bold" readonly required>
        </div>
        <div class="modal fade" id="modal_ttd">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">TTD : {{ $data->fullname }}</h5>
                    </div>
                    <div class="modal-body">
                        @if($data->ttd_pengajuan=='')
                        <h6 class="text-center">kosong</h6>
                        @else
                        <img src="{{ url('https://karyawan.sumberpangan.store/laravel/public/signature/'.$data->ttd_pengajuan.'.png') }}" style="width: 50%;margin-left: 25%;margin-right: 25%" alt="">
                        @endif
                        {{-- <img width="100%" src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/"> --}}
                        {{-- <img src="{{ url('signature/'.$penugasan->ttd_id_diajukan_oleh.'.png') }}" alt=""> --}}
                        <p style="text-align: center;font-weight: bold">{{ $data->waktu_ttd_pengajuan }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" style="margin-top: -4%;margin-bottom: 2%;">
            <a href="javascript:void(0);" data-bs-target="#modal_ttd" data-bs-toggle="modal">
                <span class="badge light badge-sm badge-info me-1 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="15" viewBox="0 0 28 28" version="1.1">
                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                        <title>ic_fluent_signature_28_filled</title>
                        <desc>Created with Sketch.</desc>
                        <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="ic_fluent_signature_28_filled" fill="#212121" fill-rule="nonzero">
                                <path d="M16.4798956,21.0019578 L16.75,21 C17.9702352,21 18.6112441,21.5058032 19.4020627,22.7041662 L19.7958278,23.3124409 C20.1028266,23.766938 20.2944374,23.9573247 20.535784,24.0567929 C20.9684873,24.2351266 21.3271008,24.1474446 22.6440782,23.5133213 L23.0473273,23.3170319 C23.8709982,22.9126711 24.4330286,22.6811606 25.0680983,22.5223931 C25.4699445,22.4219316 25.8771453,22.6662521 25.9776069,23.0680983 C26.0780684,23.4699445 25.8337479,23.8771453 25.4319017,23.9776069 C25.0371606,24.0762922 24.6589465,24.2178819 24.1641364,24.4458997 L23.0054899,25.0032673 C21.4376302,25.7436944 20.9059009,25.8317321 19.964216,25.4436275 C19.3391237,25.1860028 18.9836765,24.813298 18.4635639,24.0180227 L18.2688903,23.7140849 C17.6669841,22.7656437 17.3640608,22.5 16.75,22.5 L16.5912946,22.5037584 C16.1581568,22.5299816 15.8777212,22.7284469 14.009281,24.1150241 C12.2670395,25.4079488 10.9383359,26.0254984 9.24864243,26.0254984 C7.18872869,26.0254984 5.24773367,25.647067 3.43145875,24.8905363 L6.31377803,24.2241784 C7.25769404,24.4250762 8.23567143,24.5254984 9.24864243,24.5254984 C10.5393035,24.5254984 11.609129,24.0282691 13.1153796,22.9104743 L14.275444,22.0545488 C15.5468065,21.1304903 15.8296113,21.016032 16.4798956,21.0019578 L16.4798956,21.0019578 Z M22.7770988,3.22208979 C24.4507223,4.8957133 24.4507566,7.60916079 22.7771889,9.28281324 L21.741655,10.3184475 C22.8936263,11.7199657 22.8521526,13.2053774 21.7811031,14.279556 L18.7800727,17.2805874 L18.7800727,17.2805874 C18.4870374,17.5733384 18.0121637,17.573108 17.7194126,17.2800727 C17.4266616,16.9870374 17.426892,16.5121637 17.7199273,16.2194126 L20.7188969,13.220444 C21.2039571,12.7339668 21.2600021,12.1299983 20.678941,11.3818945 L10.0845437,21.9761011 C9.78635459,22.2743053 9.41036117,22.482705 8.99944703,22.5775313 L2.91864463,23.9807934 C2.37859061,24.1054212 1.89457875,23.6214094 2.0192066,23.0813554 L3.42247794,17.0005129 C3.51729557,16.5896365 3.72566589,16.2136736 4.0238276,15.9154968 L16.7165019,3.22217992 C18.3900415,1.54855555 21.1034349,1.54851059 22.7770988,3.22208979 Z" id="🎨-Color">

                                </path>
                            </g>
                        </g>
                    </svg>
                    Lihat&nbsp;Tanda&nbsp;Tangan
                </span>
            </a>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Kategori Izin" readonly>
            <input type="text" class="form-control" style="font-weight: bold" value="{{ $data->izin }}" readonly>
        </div>
        <div class="input-group">
            <input type="date" name="tanggal" value="{{ $data->tanggal }}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
            <input type="time" name="jam" value="{{ $data->jam }}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
        </div>
        <div class="input-group">
            <textarea class="form-control" placeholder="Catatan" name="keterangan_izin" readonly style="font-weight: bold" required>{{ $data->keterangan_izin }}</textarea>
        </div>
        <div class="input-group">
            <textarea class="form-control" placeholder="Catatan" name="catatan" style="font-weight: bold"></textarea>
        </div>
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
    </form>
</div>
@endsection
@section('js')
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