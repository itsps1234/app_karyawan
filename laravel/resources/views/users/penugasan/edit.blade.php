@extends('users.penugasan.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

<style>
    .kbw-signature {
        width: fit-content;
        height: 100%;
    }

    #sig canvas {
        margin-top: 5px;
        width: 100%;
        height: auto;
    }
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
    <form class="my-2">
        @method('put')
            @csrf
            <div class="input-group">
                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                {{-- <input type="hidden" name="telp" value="{{ $data_user->telepon }}"> --}}
                {{-- <input type="hidden" name="email" value="{{ $data_user->email }}"> --}}
                {{-- <input type="hidden" name="departements" value="{{ $user->dept_id }}"> --}}
                {{-- <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}"> --}}
                {{-- <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id=""> --}}
                <input type="hidden" name="id_user_atasan" value="{{ $penugasan->id_user_atasan }}">
                <input type="hidden" name="id_user_atasan2" value="{{ $penugasan->id_user_atasan2 }}">
                <input type="hidden" name="nik" value="{{ Auth::user()->id }}">
                <input type="hidden" name="id_jabatan" value="{{ $penugasan->id_jabatan }}">
                <input type="hidden" name="id_departemen" value="{{ $penugasan->id_departemen }}">
                <input type="hidden" name="id_divisi" value="{{ $penugasan->id_divisi }}">
                <input type="hidden" name="id_diajukan_oleh" value="{{ Auth::user()->id }}">
                <input type="hidden" name="id_diminta_oleh" value="{{ $penugasan->id_diminta_oleh }}">
                <input type="hidden" name="id_disahkan_oleh" value="{{ $penugasan->id_disahkan_oleh }}">
                <input type="hidden" name="proses_hrd" value="proses hrd">
                <input type="hidden" name="proses_finance" value="proses finance">
                <input type="hidden" name="tanggal_pengajuan" value="{{ date('Y-m-d') }}">
                <input type="hidden" name="jam_pengajuan" value="{{ date('h:i:s') }}">
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Nama" readonly>
                <input type="text" class="form-control" name="" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
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
                <input type="text" class="form-control" value="Divisi" readonly>
                <input type="text" class="form-control" name="" value="{{ $penugasan->nama_divisi }}" style="font-weight: bold" readonly required>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Asal Kerja" readonly>
                    <select class="form-control" name="cuti" required>
                        <option value="">Pilih Asal Kerja...</option>
                        <option value="CV. SP (PAGU)">CV. Sumber Pangan (Pagu)</option>
                        <option value="CV. SP (TUBAN)">CV. Sumber Pangan (Tuban)</option>
                        <option value="PT. SPS (GURAH)">PT. Surya Pangan Semesta (Gurah)</option>
                        <option value="PT. SPS (NGAWI)">PT. Surya Pangan Semesta (Ngawi)</option>
                        <option value="PT. SPS (SUBANG)">PT. Surya Pangan Semesta (Subang)</option>
                    </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Penugasan" readonly>
                <select class="form-control" name="penugasan" required>
                    <option value="">Pilih Penugasan...</option>
                    <option value="dalam kota">Dalam Kota</option>
                    <option value="luar kota">Luar Kota</option>
                </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Tanggal Kunjungan" readonly>
                <input type="date" name="tanggal_kunjungan" value="{{ $penugasan->tanggal_kunjungan }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Selesai Kunjungan" readonly>
                <input type="date" name="selesai_kunjungan" value="{{ $penugasan->selesai_kunjungan}}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
            </div>
            <div class="input-group">
                <textarea class="form-control" name="kegiatan_penugasan" style="font-weight: bold" required>{{ $penugasan->kegiatan_penugasan }}</textarea>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="PIC dikunjungi" readonly>
                <input type="text" class="form-control" name="pic_dikunjungi" value="{{ $penugasan->pic_dikunjungi }}" style="font-weight: bold" required>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Alamat" readonly>
                <input type="text" class="form-control" name="alamat_dikunjungi" value="{{ $penugasan->alamat }}" style="font-weight: bold" required>
            </div>
            <hr>
            <div class="input-group">
                <input type="text" class="form-control" value="Transportasi" readonly>
                <select class="form-control" name="transportasi" required>
                    <option value="">Pilih Transportasi...</option>
                        <option value="Pesawat">Pesawat</option>
                        <option value="Kereta Api">Kereta Api</option>
                        <option value="Bis">Bis</option>
                        <option value="Travel">Travel</option>
                        <option value="SPD Motor">SPD Motor</option>
                        <option value="Mobil Dinas">Mobil Dinas</option>
                </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Kelas" readonly>
                <select class="form-control" name="kelas" required>
                    <option value="">Pilih Kelas...</option>
                    <option value="Eksekutif">Eksekutif</option>
                    <option value="Bisnis">Bisnis</option>
                    <option value="Ekonomi">Ekonomi</option>
                </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Budget Hotel" readonly>
                <select class="form-control" name="budget_hotel" required>
                    <option value="">Pilih Budget...</option>
                    <option value="400.000 sd 500.000">Rp 400.000 sd 500.000</option>
                    <option value="300.000 sd 400.000">Rp 300.000 sd 400.000</option>
                    <option value="200.000 sd 300.000">Rp 200.000 sd 300.000</option>
                    <option value="Kost Harian < Rp 200.000">Kost Harian < Rp 200.000</option>
                </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Makan" readonly>
                <select class="form-control" name="makan" required>
                    <option value="">Pilih Makan...</option>
                    <option value="25.000">Rp 25.000</option>
                    <option value="15.000">Rp 15.000</option>
                </select>
            </div>
            <hr>
            <div class="input-group">
                <input type="text" class="form-control" value="Diajukan oleh" readonly>
                <input type="text" class="form-control" name="diajukan_oleh" value="{{ Auth::user()->fullname }}" readonly>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Diminta oleh" readonly>
                @php
                    $diminta = \App\Models\User::where(['id'=>$penugasan->id_diminta_oleh])->first();
                @endphp
                <input type="text" class="form-control" name="diminta_oleh" value="{{ $diminta->fullname }}" readonly>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Disahkan oleh" readonly>
                @php
                    $disahkan = \App\Models\User::where(['id'=>$penugasan->id_disahkan_oleh])->first();
                @endphp
                <input type="text" class="form-control" name="disahkan_oleh" value="{{ $disahkan->fullname }}" readonly>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Diproses HRD" readonly>
                <input type="text" class="form-control" name="proses_hrd" value="HRD" readonly>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Diproses Finance" readonly>
                <input type="text" class="form-control" name="proses_finance" value="ACC FINANCE" readonly>
            </div>
    </form>
    <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
        <i class="fa fa-refresh" aria-hidden="true"> </i>
        &nbsp; Update
    </button>
    <script>
        $('button').click(function() {
            $('#myModal').modal('show');
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="modal_pengajuan_cuti">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">From Penugasan</h5>
                    <button class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="my-2" method="post" action="{{ url('/penugasan/tambah-penugasan-proses/') }}" enctype="multipart/form-data">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>


<script type="text/javascript">
    var sig = $('#sig').signature({
        syncField: '#signature64',
        syncFormat: 'PNG'
    });
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
@endsection
