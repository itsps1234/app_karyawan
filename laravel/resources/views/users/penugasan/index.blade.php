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
<div class="fixed-content p-0">
    <div class="container">
        <div class="main-content">
            <div class="left-content">
                <a href="{{url('home')}}" class="">
                    <svg width="18" height="18" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.03033 0.46967C9.2966 0.735936 9.3208 1.1526 9.10295 1.44621L9.03033 1.53033L2.561 8L9.03033 14.4697C9.2966 14.7359 9.3208 15.1526 9.10295 15.4462L9.03033 15.5303C8.76406 15.7966 8.3474 15.8208 8.05379 15.6029L7.96967 15.5303L0.96967 8.53033C0.703403 8.26406 0.679197 7.8474 0.897052 7.55379L0.96967 7.46967L7.96967 0.46967C8.26256 0.176777 8.73744 0.176777 9.03033 0.46967Z" fill="#a19fa8" />
                    </svg>
                </a>
            </div>
            <div class="mid-content">
                <h5 class="mb-0">Back</h5>
            </div>
        </div>
    </div>
</div>
@if(Session::has('penugasansukses'))
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Pengajuan Perjalanan Dinas
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('updatesukses'))
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Update Perjalanan Dinas
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('hapussukses'))
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Hapus Perjalanan Dinas
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('penugasangagal1'))
<div class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Gagal!</strong> Tanggal Pengajuan Anda Sudah Terlewat.
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
    <button id="addForm" class="btn btn-sm btn-primary btn-rounded" style="width: 30%;margin-left: 35%;margin-right: 35%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
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
                    <h5 class="modal-title">Form Penugasan</h5>
                    <button class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="my-2" method="post" action="{{ url('/penugasan/tambah-penugasan-proses/') }}" enctype="multipart/form-data">
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
                            <input type="hidden" name="nik" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="id_jabatan" value="{{ $user->jabatan_id }}">
                            <input type="hidden" name="id_departemen" value="{{ $user->dept_id }}">
                            <input type="hidden" name="id_divisi" value="{{ $user->divisi_id }}">
                            <input type="hidden" name="id_diajukan_oleh" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="id_diminta_oleh" value="{{ $getUserAtasan->id }}">
                            <input type="hidden" name="id_disahkan_oleh" value="{{ $getUseratasan2->id }}">
                            <input type="hidden" name="proses_hrd" value="proses hrd">
                            <input type="hidden" name="proses_finance" value="proses finance">
                            <input type="hidden" name="tanggal_pengajuan" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Nama" readonly>
                            <input type="text" class="form-control" name="" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="NIK" readonly>
                            <input type="text" class="form-control" name="" value="{{ Auth::user()->nik }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Jabatan" readonly>
                            <input type="text" class="form-control" name="" value="{{ $user->nama_jabatan }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Divisi" readonly>
                            <input type="text" class="form-control" name="" value="{{ $user->nama_departemen }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Divisi" readonly>
                            <input type="text" class="form-control" name="" value="{{ $user->nama_divisi }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Asal Kerja" readonly>
                            <input type="text" name="asal_kerja" class="form-control" value="{{$user->penempatan_kerja}}" readonly>
                            <!-- <select class="form-control" name="asal_kerja" required>
                                <option value="">Pilih Asal Kerja...</option>
                                <option value="CV. SUMBER PANGAN - KEDIRI">CV. Sumber Pangan (Kediri)</option>
                                <option value="CV. SUMBER PANGAN - TUBAN">CV. Sumber Pangan (Tuban)</option>
                                <option value="PT. SURYA PANGAN SEMESTA - KEDIRI">PT. Surya Pangan Semesta (Kediri)</option>
                                <option value="PT. SURYA PANGAN SEMESTA - NGAWI">PT. Surya Pangan Semesta (Ngawi)</option>
                                <option value="PT. SURYA PANGAN SEMESTA - SUBANG">PT. Surya Pangan Semesta (Subang)</option>
                            </select> -->
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Lokasi Penugasan" readonly>
                            <select class="form-control" name="penugasan" required>
                                <option value="">Pilih Penugasan...</option>
                                <option value="Dalam Kota">Dalam Kota</option>
                                <option value="Luar Kota">Luar Kota</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Wilayah Penugasan" readonly>
                            <select class="form-control" id="wilayah_penugasan" name="wilayah_penugasan" required>
                                <option value="">Wilayah Penugasan...</option>
                                <option value="Wilayah Kantor">Wilayah Kantor</option>
                                <option value="Diluar Kantor">Diluar Kantor</option>
                            </select>
                        </div>
                        <div id="alamat_dikunjungi" class="input-group">
                            <input type="text" class="form-control" value="Lokasi Kantor" readonly>
                            <select class="form-control" name="alamat_dikunjungi" style="font-weight: bold">
                                <option selected disabled value="">-- Pilih Kantor --</option>
                                @foreach($lokasi_kantor as $lokasi)
                                <option value="{{$lokasi->lokasi_kantor}}">{{$lokasi->lokasi_kantor}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="alamat_dikunjungi1" class="input-group">
                            <input type="text" class="form-control" value="Alamat" readonly>
                            <input type="text" class="form-control" name="alamat_dikunjungi1" style="font-weight: bold">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="PIC dikunjungi" readonly>
                            <input type="text" class="form-control" name="pic_dikunjungi" style="font-weight: bold" required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Tanggal Kunjungan" readonly>
                            <input type="date" name="tanggal_kunjungan" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Selesai Kunjungan" readonly>
                            <input type="date" name="selesai_kunjungan" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <textarea class="form-control" name="kegiatan_penugasan" style="font-weight: bold" required placeholder="Kegiatan penugasan"></textarea>
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
                            <input type="text" class="form-control" name="diajukan_oleh" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diminta oleh" readonly>
                            <input type="text" class="form-control" name="diminta_oleh" value="{{ $getUserAtasan->name }}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Disahkan oleh" readonly>
                            <input type="text" class="form-control" name="disahkan_oleh" value="{{ $getUseratasan2->name }}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses HRD" readonly>
                            <input type="text" class="form-control" value="{{$hrd->name}}" readonly>
                            <input type="hidden" class="form-control" name="proses_hrd" value="{{$hrd->id}}" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Diproses Finance" readonly>
                            <input type="text" class="form-control" value="{{$finance->name}}" readonly>
                            <input type="hidden" class="form-control" name="proses_finance" value="{{$finance->id}}" readonly>
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

{{-- <hr width="90%" style="margin-left: 5%;margin-right: 5%"> --}}
<div class="container">
    <div class="detail-content">
        <div class="flex-1">
            <h4>Riwayat</h4>
        </div>
    </div>
    @foreach ($record_data as $record_data)
    <div class="notification-content" style="background-color: white">
        @if ($record_data->status_penugasan != 0)
        <a href="{{ url('/penugasan/detail/delete/'.$record_data->id) }}">
            <small class="badge badge-success" style="float: right;padding-right:10px "><i class="fa fa-save"></i> </small>
        </a>
        @else
        <small class="badge badge-danger" style="float: right;padding-right:10px "><i class="fa fa-trash"></i> </small>
        @endif
        <a href="{{ url('penugasan/detail/edit/'.$record_data->id) }}">
            <div class="notification">
                <h6>{{ $record_data->fullname }}</h6>
                <p>{{ $record_data->kegiatan_penugasan}}</p>
                <div class="notification-footer">
                    <span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6 3V6L8 7" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        {{ $record_data->tanggal_pengajuan}}
                    </span>
                    @if ($record_data->status_penugasan == 0 )
                    <small class="badge light badge-danger"><i class="fa fa-pencil"> </i> Tambahkan TTD</small>
                    @elseif($record_data->status_penugasan == 1)
                    <small class="badge light badge-warning"><i class="fa fa-pencil"> </i> Proses TTD Diminta</small>
                    @elseif($record_data->status_penugasan == 2)
                    <small class="badge light badge-secondary"><i class="fa fa-pencil"> </i> Proses TTD Disahkan</small>
                    @elseif($record_data->status_penugasan == 3)
                    <small class="badge light badge-info"><i class="fa fa-pencil"> </i> Proses TTD HRD</small>
                    @elseif($record_data->status_penugasan == 4)
                    <small class="badge light badge-primary"><i class="fa fa-pencil"> </i> Proses TTD FINANCE</small>
                    @elseif($record_data->status_penugasan == 5)
                    <small class="badge light badge-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none">
                            <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Penugasan Telah Disetujui</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>

@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#alamat_dikunjungi').hide();
        $('#alamat_dikunjungi1').hide();
        $('body').on("change", "#wilayah_penugasan", function() {
            var id = $(this).val();
            if (id == 'Wilayah Kantor') {
                $('#alamat_dikunjungi').show();
                $('#alamat_dikunjungi1').hide();
            } else {
                $('#alamat_dikunjungi1').show();
                $('#alamat_dikunjungi').hide();
            }
        });
    });
</script>
@endsection