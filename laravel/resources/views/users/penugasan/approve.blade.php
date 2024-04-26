@extends('users.penugasan.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<script type="text/javascript" src="{{ asset('assets_ttd/assets/signature.js') }}"></script>
<style>
    body{
    padding: 15px;
    }
    #note{position:absolute;left:50px;top:35px;padding:0px;margin:0px;cursor:default;}
</style>
@if(Session::has('penugasansukses'))
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Pengajuan Perdin
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('penugasangagal'))
<div class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Anda Gagal Pengajuan Perdin.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@endif
    <div class="container">
            <form class="my-2"method="post" action="{{ url('/penugasan/approve/diminta/ttd/'.$id_penugasan->id) }}" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="status_penugasan" value="2">
                    <div class="input-group">
                        <input type="text" class="form-control" value="Nama" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->fullname }}" style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="NIK" readonly>
                        <input type="text" class="form-control" name="" value="{{ Auth::user()->id }}" style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Jabatan" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->nama_jabatan }}" style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Divisi" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->nama_departemen }}" style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Departemen" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->nama_divisi }}" style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Asal Kerja" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->kontrak_kerja }}" style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Penugasan" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->penugasan }}" readonly style="font-weight: bold" readonly required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Tanggal Kunjungan" readonly>
                        <input type="date" name="" value="{{ $penugasan->tanggal_kunjungan }}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Selesai Kunjungan" readonly>
                        <input type="date" name="" value="{{ $penugasan->selesai_kunjungan}}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
                    </div>
                    <div class="input-group">
                        <textarea class="form-control" name="" readonly style="font-weight: bold" required>{{ $penugasan->kegiatan_penugasan }}</textarea>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="PIC dikunjungi" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->pic_dikunjungi }}" readonly style="font-weight: bold" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Alamat" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->alamat }}" readonly style="font-weight: bold" required>
                    </div>
                    <hr>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Transportasi" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->transportasi }}" readonly style="font-weight: bold" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Kelas" readonly>
                        <input type="text" class="form-control" name="kelas" value="{{ $penugasan->kelas }}" readonly style="font-weight: bold" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Budget Hotel" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->budget_hotel }}" readonly style="font-weight: bold" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Makan" readonly>
                        <input type="text" class="form-control" name="" value="{{ $penugasan->makan }} {{ $penugasan->id_diminta_oleh }}" readonly style="font-weight: bold" required>
                    </div>
                    <hr>
                    @php
                        $diminta = \App\Models\User::where(['id'=>$penugasan->id_diminta_oleh])->first();
                        $disahkan = \App\Models\User::where(['id'=>$penugasan->id_disahkan_oleh])->first();
                        $diproseshrd = \App\Models\User::where(['id'=>'e30d4a42-5562-415c-b1b6-f6b9ccc379a1'])->first();
                        $diprosesfin = \App\Models\User::where(['id'=>'436da676-5782-4f4e-ad50-52b45060430c'])->first();
                    @endphp
                    @if($penugasan->status_penugasan == 1)
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diajukan oleh" readonly>
                            <input type="text" class="form-control" name="" readonly value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Cek Signature</button>
                            <div class="modal fade" id="exampleModalCenter">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Signature : {{ $penugasan->fullname }}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ url('https://karyawan.sumberpangan.store/laravel/public/signature/'.$penugasan->ttd_id_diajukan_oleh.'.png') }}" style="width: 50%;margin-left: 25%;margin-right: 25%" alt="">
                                            {{-- <img width="40px" src="{{ asset('assets/assets_users/images/users/user_icon.jpg') }}" alt="/"> --}}
                                            {{-- <img src="{{ url('signature/'.$penugasan->ttd_id_diajukan_oleh.'.png') }}" alt=""> --}}
                                            <p style="text-align: center;font-weight: bold">{{ $penugasan->waktu_ttd_id_diajukan_oleh }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-danger light" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diminta->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $disahkan->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <div id="signature-pad">
                                <div style="border:solid 1px teal; width:100%;height:200px;">
                                    <div id="note" onmouseover="my_function();"></div>
                                    <canvas id="the_canvas" width="auto" height="100px"></canvas>
                                    <p class="text-primary" style="text-align: center">Ttd : {{ Auth::user()->fullname }} {{ date('Y-m-d') }}</p>
                                    <hr>
                                    <div style="margin:10px;">
                                        <input type="hidden" id="signature" name="signature">
                                        <button type="button" id="clear_btn" class="btn btn-danger btn-rounded" style="margin-left:5%" data-action="clear"><i class="fa fa-refresh" aria-hidden="true"> </i> &nbsp; Clear</button>
                                        <button type="submit" id="save_btn" class="btn btn-primary btn-rounded" style="margin-right:5%" data-action="save-png"><i class="fa fa-save" aria-hidden="true"> </i> &nbsp; Update</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @elseif($penugasan->status_penugasan == 2)
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diajukan oleh" readonly>
                            <input type="text" class="form-control" name="" readonly value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $disahkan->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
                            <i class="fa fa-refresh" aria-hidden="true"> </i>
                            &nbsp; Setujui
                        </button>
                    @elseif($penugasan->status_penugasan == 3)
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diajukan oleh" readonly>
                            <input type="text" class="form-control" name="" readonly value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
                            <i class="fa fa-refresh" aria-hidden="true"> </i>
                            &nbsp; Setujui
                        </button>
                    @elseif($penugasan->status_penugasan == 4)
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diajukan oleh" readonly>
                            <input type="text" class="form-control" name="" readonly value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diproseshrd->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
                            <i class="fa fa-refresh" aria-hidden="true"> </i>
                            &nbsp; Setujui
                        </button>
                    @elseif($penugasan->status_penugasan == 5)
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diajukan oleh" readonly>
                            <input type="text" class="form-control" name="" readonly value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="" value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diproseshrd->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" name="" value="{{ $diprosesfin->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                        </div>
                        <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
                            <i class="fa fa-refresh" aria-hidden="true"> </i>
                            &nbsp; Setujui
                        </button>
                    @endif
            </form>
    </div>
</div>

<script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var canvas = wrapper.querySelector("canvas");
    var el_note = document.getElementById("note");
    var signaturePad;
    signaturePad = new SignaturePad(canvas);

    clearButton.addEventListener("click", function (event) {
        document.getElementById("note").innerHTML="The signature should be inside box";
        signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function (event){
        if (signaturePad.isEmpty()){
            alert("Please provide signature first.");
            event.preventDefault();
        }else{
            var canvas  = document.getElementById("the_canvas");
            var dataUrl = canvas.toDataURL();
            document.getElementById("signature").value = dataUrl;
        }
    });
    function my_function(){
        document.getElementById("note").innerHTML="";
    }
    </script>
@endsection
