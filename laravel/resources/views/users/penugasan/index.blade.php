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

@if(Session::has('statuscutisuccess'))
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Pengajuan Cuti
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('statuscutiwarning'))
<div class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Anda Gagal Pengajuan Cuti.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@endif
<div class="container">
    <form class="my-2">
        <div class="input-group">
            <input type="date" value="{{ date('Y-m-d') }}" readonly style="font-weight: bold" placeholder="Phone number" class="form-control">
            <input type="time" value="{{ date('H:i:s') }}" readonly style="font-weight: bold" placeholder="Phone number" class="form-control">
        </div>
    </form>
    <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
        <i class="fa fa-plus" aria-hidden="true"> </i>
        &nbsp; Add
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
                <form class="my-2" method="post" action="{{ url('/cuti/tambah-cuti-proses/') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @method('put')
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            {{-- <input type="hidden" name="telp" value="{{ $data_user->telepon }}"> --}}
                            {{-- <input type="hidden" name="email" value="{{ $data_user->email }}"> --}}
                            {{-- <input type="hidden" name="departements" value="{{ $user->dept_id }}"> --}}
                            {{-- <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}"> --}}
                            {{-- <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id=""> --}}
                            <input type="hidden" name="id_user_atasan" value="{{ $getUserAtasan->id }}">
                            <input type="hidden" name="id_user_atasan2" value="{{ $getUseratasan2->id }}">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Nama" readonly>
                            <input type="text" class="form-control" name="" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="NIK" readonly>
                            <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->id }}" style="font-weight: bold" readonly required>
                            <input type="hidden" name="nik" value="{{ Auth::user()->id }}">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Jabatan" readonly>
                            <input type="text" class="form-control" name="" value="{{ $user->nama_jabatan }}" style="font-weight: bold" readonly required>
                            <input type="hidden" name="id_jabatan" value="{{ $user->jabatan_id }}">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Divisi" readonly>
                            <input type="text" class="form-control" name="fullname" value="{{ $user->nama_departemen }}" style="font-weight: bold" readonly required>
                            <input type="hidden" name="id_departemen" value="{{ $user->dept_id }}">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Divisi" readonly>
                            <input type="text" class="form-control" name="fullname" value="{{ $user->nama_divisi }}" style="font-weight: bold" readonly required>
                            <input type="hidden" name="id_divisi" value="{{ $user->divisi_id }}">
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
                            <select class="form-control" name="cuti" required>
                                <option value="">Pilih Penugasan...</option>
                                <option value="dalam kota">Dalam Kota</option>
                                <option value="luar kota">Luar Kota</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Tanggal Kunjungan" readonly>
                            <input type="date" name="tanggal_kunjungan" value="{{ date('Y-m-d') }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Selesai Kunjungan" readonly>
                            <input type="date" name="selesai_kunjungan" value="{{ date('Y-m-d') }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <textarea class="form-control" name="kegiatan_penugasan" style="font-weight: bold" required placeholder="Kegiatan penugasan"></textarea>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="PIC dikunjungi" readonly>
                            <input type="text" class="form-control" name="pic_dikunjungi" style="font-weight: bold" required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Alamat" readonly>
                            <input type="text" class="form-control" name="alamat_dikunjungi" style="font-weight: bold" required>
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
                                <option value="Eksekutif">Rp 400.000 sd 500.000</option>
                                <option value="Bisnis">Rp 300.000 sd 400.000</option>
                                <option value="Ekonomi">Rp 200.000 sd 300.000</option>
                                <option value="Ekonomi">Kost Harian < Rp 200.000</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Makan" readonly>
                            <select class="form-control" name="makan" required>
                                <option value="">Pilih Makan...</option>
                                <option value="Eksekutif">Rp 25.000</option>
                                <option value="Bisnis">Rp 15.000</option>
                            </select>
                        </div>
                        <hr>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diajukan oleh" readonly>
                            <input type="text" class="form-control" name="diajukan_oleh" value="{{ Auth::user()->fullname }}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="approve_atasan" value="{{ $getUserAtasan->fullname }}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="approve_atasan2" value="{{ $getUserAtasan->fullname }}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" name="approve_atasan2" value="FITRI" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" name="approve_atasan2" value="NIKEN" readonly>
                        </div>
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

<hr width="90%" style="margin-left: 5%;margin-right: 5%">
<div class="container">
    <div class="detail-content">
        <div class="flex-1">
            <h4>Riwayat</h4>
        </div>
    </div>
    @foreach ($record_data as $record_data)
    <div class="notification-content" style="background-color: white">
        <a href="#" onclick="return false;">
            <div class="notification">
                <h6>{{ $record_data->nama_cuti }}</h6>
                <p>{{ $record_data->keterangan_cuti}}</p>
                <div class="notification-footer">
                    <span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6 3V6L8 7" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        {{ $record_data->tanggal}}
                    </span>
                    @if ($record_data->status_cuti == 0)
                    <small class="badge badge-danger"><i class="far fa-clock"></i> Menunggu</small>
                    @else
                    <small class="badge badge-success"><i class="far fa-clock"></i> Disetujui</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


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
