@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@if(Session::has('atasankosong'))
<div class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>error!</strong> Atasan Anda Kosong. Hubungi HRD.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@else
@endif
<div class="container">
    <form class="my-2">
        <div class="input-group">
            <input type="date" value="{{ date('Y-m-d') }}" style="font-weight: bold" placeholder="Phone number" class="form-control">
            <input type="time" value="{{ date('H:i:s') }}" style="font-weight: bold" placeholder="Phone number" class="form-control">
        </div>
    </form>
    <button id="addForm" class="btn btn-sm btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#myModal">
        <i class="fa fa-plus" aria-hidden="true"> </i>
        &nbsp; Add
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Permohonan Izin</h4>
                    <button class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="my-2" method="post" action="{{ url('/izin/tambah-izin-proses/') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @method('post')
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="telp" value="{{ $data_user->telepon }}">
                            <input type="hidden" name="email" value="{{ $data_user->email }}">
                            <input type="hidden" name="departements" value="{{ $user->dept_id }}">
                            <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}">
                            <input type="hidden" name="level_jabatan" value="{{ $user->level_jabatan }}">
                            <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id="">
                            @if($getUserAtasan==NULL)
                            <input type="hidden" name="id_user_atasan" value="">
                            @else
                            <input type="hidden" name="id_user_atasan" value="{{ $getUserAtasan->id }}">
                            @endif
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Name" readonly>
                            <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Permission Category" readonly>
                            <select name="izin" id="" style="font-weight: bold" class="form-control" required>
                                <option value="">--Pilih Izin--</option>
                                <option value="Pulang Cepat">Pulang Cepat</option>
                                <option value="Telat Masuk">Telat Masuk</option>
                                <option value="Keluar Kantor">Keluar Kantor</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                            <input type="time" name="jam" value="{{ date('H:i:s') }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <textarea class="form-control" name="keterangan_izin" style="font-weight: bold" required placeholder="Description"></textarea>
                        </div>
                        <div class="input-group">
                            @if($getUserAtasan==NULL)
                            @if($user->level_jabatan=='1')
                            <input type="text" class="form-control" value="Diproses" readonly>
                            <input type="text" class="form-control" name="approve_atasan1" value="HRD" readonly>
                            <input type="hidden" class="form-control" name="approve_atasan" value="" readonly>
                            @else
                            <input type="text" class="form-control" value="Approve By" readonly>
                            <input type="text" class="form-control" name="approve_atasan" value="" readonly>
                            @endif
                            @else
                            <input type="text" class="form-control" value="Approve By" readonly>
                            <input type="text" class="form-control" name="approve_atasan" value="{{ $getUserAtasan->name }}" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary float-right">Simpan</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<hr width="90%" style="margin-left: 5%;margin-right: 5%">
<div class="container">
    <div class="detail-content">
        <div class="flex-1">
            <h4>History.</h4>
        </div>
    </div>
    @foreach ($record_data as $record_data)
    <div class="notification-content" style="background-color: white">
        <a href="{{url('/izin/detail/edit/'.$record_data->id)}}">
            <div class="notification">
                <h6>{{ $record_data->izin }}</h6>
                <p>{{ $record_data->keterangan_izin}}</p>
                <div class="notification-footer">
                    <span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6 3V6L8 7" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        {{ $record_data->tanggal}}
                    </span>
                    @if ($record_data->status_izin == 0)
                    @if($record_data->ttd_pengajuan == NULL || $record_data->ttd_pengajuan == '')
                    <small class="badge badge-danger"><i class="far fa-edit"></i> Tambahkan TTD</small>
                    @else
                    <small class="badge badge-info"><i class="fa fa-spinner"></i> Menunggu Approve</small>
                    @endif
                    @else
                    <small class="badge badge-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none">
                            <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Disetujui</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>
@endsection