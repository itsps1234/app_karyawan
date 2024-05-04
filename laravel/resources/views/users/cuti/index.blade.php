@extends('users.cuti.layout.main')
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

@if(Session::has('addcutisuccess'))
<div id="alert_addcutisuccess" class="alert alert-success light alert-lg alert-dismissible fade show">
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
@elseif(Session::has('addcutierror1'))
<div id="alert_addcutierror1" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Anda Tidak Memiliki Kuota Cuti.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('addcutierror2'))
<div id="alert_addcutierror2" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Pengajuan Harus H-14 untuk cuti
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('statuscutieditsuccess'))
<div id="alert_statuscutieditsuccess" class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Menyimpan Data Cuti
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('statuscutiediterror'))
<div id="alert_statuscutiediterror" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Anda Tidak Memiliki Kuota Cuti.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('statuscutiediterror2'))
<div id="alert_statuscutiediterror2" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Pengajuan Harus H-14 untuk cuti
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('atasan1NULL'))
<div id="alert_atasan1_null" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Atasan 1 Kosong
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('atasan2NULL'))
<div id="alert_atasan2_null" class="alert alert-danger light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg>
    <strong>Warning!</strong> Atasan 2 Kosong
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
                    <h5 class="modal-title">From Permission</h5>
                    <button class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="my-2" method="post" action="{{ url('/cuti/tambah-cuti-proses/') }}" enctype="multipart/form-data">
                    <div class="modal-body">
                        @method('put')
                        @csrf
                        @if($user->kuota_cuti=='' || $user->kuota_cuti=='0')
                        <div class="alert alert-danger light alert-lg alert-dismissible fade show">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <strong>Warning!</strong> Anda Tidak Memiliki Kuota Cuti.
                            <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        @else
                        @endif
                        <div class="input-group">
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            {{-- <input type="hidden" name="telp" value="{{ $data_user->telepon }}"> --}}
                            {{-- <input type="hidden" name="email" value="{{ $data_user->email }}"> --}}
                            {{-- <input type="hidden" name="departements" value="{{ $user->dept_id }}"> --}}
                            {{-- <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}"> --}}
                            {{-- <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id=""> --}}
                            @if($getUserAtasan==null)
                            <input type="hidden" name="id_user_atasan" value="">
                            @else
                            <input type="hidden" name="id_user_atasan" value="{{ $getUserAtasan->id }}">
                            @endif
                            @if($getUserAtasan2==null)
                            <input type="hidden" name="id_user_atasan2" value="">
                            @else
                            <input type="hidden" name="id_user_atasan2" value="{{ $getUserAtasan2->id }}">
                            @endif
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Nama" readonly>
                            <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Kuota Cuti Tahunan" readonly>
                            <input type="text" class="form-control" name="kuota_cuti" value="@if($user->kuota_cuti=='' || $user->kuota_cuti=='0')0 @else{{ $user->kuota_cuti }}@endif Hari" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Kategori Cuti" readonly>
                            <select class="form-control" name="cuti" required>
                                <option value="">Pilih Cuti...</option>
                                @foreach($get_kategori_cuti as $data)
                                <option value="{{$data->id}}">{{$data->nama_cuti}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            @if($data_user->level_jabatan=='1')
                            <input type="text" class="form-control" value="Pengganti" readonly>
                            <select class="form-control" name="user_backup" required>
                                <option selected value="-">-</option>
                            </select>
                            @else
                            <input type="text" class="form-control" value="Pengganti" readonly>
                            <select class="form-control" name="user_backup" required>
                                <option value="">Pilih Pengganti...</option>
                                @foreach($get_user_backup as $data)
                                <option value="{{$data->id}}">{{$data->fullname}}
                                </option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Tanggal Mulai" readonly>
                            <input type="date" name="tanggal_mulai" value="{{ date('Y-m-d') }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Tanggal Selesai" readonly>
                            <input type="date" name="tanggal_selesai" value="{{ date('Y-m-d') }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
                        </div>
                        <div class="input-group">
                            <textarea class="form-control" name="keterangan_cuti" style="font-weight: bold" required placeholder="Keterangan"></textarea>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Approve By 1" readonly>
                            <input type="text" class="form-control" name="approve_atasan" value="@if($getUserAtasan==null) @else {{ $getUserAtasan->name }} @endif" readonly>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Approve By 2" readonly>
                            <input type="text" class="form-control" name="approve_atasan2" value="@if($getUserAtasan2==null) @else {{ $getUserAtasan2->name }} @endif" readonly>
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
            <h4>History.</h4>
        </div>
    </div>
    @foreach ($record_data as $record_data)
    <div class="notification-content" style="background-color: white">
        <a href="{{url('/cuti/detail/edit/'.$record_data->id)}}">
            <div class="notification">
                <h6>{{ $record_data->nama_cuti }}</h6>
                <p>{{ $record_data->keterangan_cuti}}</p>
                <div class="notification-footer mt--5">
                    <span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6 3V6L8 7" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        {{ $record_data->tanggal}}
                    </span>
                    @if ($record_data->status_cuti == 0)
                    @if($record_data->ttd_user == NULL || $record_data->ttd_user == '')
                    <small class="badge badge-danger"><i class="far fa-edit"></i>&nbsp;Tambahkan TTD</small>
                    @else
                    <small style="display: inline-flex;" class="badge badge-info"><i class="fa fa-spinner"></i>&nbsp;Menunggu Approve Atasan1</small>
                    @endif
                    @elseif ($record_data->status_cuti == 1)
                    @if($record_data->ttd_atasan2 == NULL || $record_data->ttd_atasan2 == '')
                    <small style="display: inline-flex;" class="badge badge-info"><i class="fa fa-spinner"></i>&nbsp;Menunggu Approve Atasan2</small>
                    @else
                    <small class="badge badge-success"><i class="fa fa-check"></i>&nbsp;Disetujui</small>
                    @endif
                    @else
                    <small class="badge badge-success"><i class="fa fa-check"></i>&nbsp;Disetujui</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    @endforeach

</div>
@endsection
@section('js')
<script>
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_atasan1_null").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_atasan2_null").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_addcutisuccess").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_addcutierror1").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_addcutierror2").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_statuscutieditsuccess").remove();
        }, 7000); // 7 secs

    });
    $("document").ready(function() {
        // console.log('ok');
        setTimeout(function() {
            // console.log('ok1');
            $("#alert_statuscutiediterror").remove();
        }, 7000); // 7 secs

    });
</script>
@endsection