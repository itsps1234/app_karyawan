@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css"> --}}

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>

<div class="container">
    <!-- Modal -->
    <div class="container">
        <form class="my-2" method="post" action="{{ url('/cuti/approve/proses/'.$data->id) }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="input-group">
                {{-- <input type="hidden" name="id_user" value="{{ Auth::user()->id }}"> --}}
                {{-- <input type="hidden" name="telp" value="{{ $user->telepon }}"> --}}
                {{-- <input type="hidden" name="email" value="{{ $user->email }}"> --}}
                {{-- <input type="hidden" name="departements" value="{{ $user->dept_id }}"> --}}
                {{-- <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}"> --}}
                {{-- <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id=""> --}}
                {{-- <input type="hidden" name="id_user_atasan" value="{{ $getUserAtasan->id }}"> --}}
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Nama" readonly>
                <input type="text" class="form-control" name="fullname" value="{{ $data->fullname }}" style="font-weight: bold" readonly required>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" value="Kategori Cuti" readonly>
                <input type="text" class="form-control" style="font-weight: bold" value="{{ $data->nama_cuti }}" readonly>
            </div>
            <div class="input-group">
                <input type="text" name="jam" value="Tanggal Mulai" readonly required placeholder="Phone number" class="form-control">
                <input type="date" name="tanggal" value="{{ $data->tanggal_mulai }}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
            </div>
            <div class="input-group">
                <input type="text" name="jam" value="Tanggal Selesai" readonly required placeholder="Phone number" class="form-control">
                <input type="date" name="tanggal" value="{{ $data->tanggal_selesai }}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
            </div>
            <div class="input-group">
                <input type="text" name="jam" value="Total Pengajuan" readonly required placeholder="Phone number" class="form-control">
                <input type="text" name="tanggal" value="{{ $data->total_cuti }} Dari {{ $data->kuota_cuti }} Kuota Cuti" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
            </div>
            <div class="input-group">
                <textarea class="form-control" placeholder="Catatan" name="keterangan_izin" readonly style="font-weight: bold" required>{{ $data->keterangan_cuti }}</textarea>
            </div>
            <div class="input-group">
                <input class="form-control" placeholder="Catatan Atasan" name="catatan" style="font-weight: bold"/>
            </div>
            <div class="input-group">
                <div id="sig" ></div>
                <button id="clear" class="btn btn-danger btn-sm">Clear</button>
                <textarea id="signature64" name="ttd" style="display: none"></textarea>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary float-right btn-sm">Submit</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
@endsection
