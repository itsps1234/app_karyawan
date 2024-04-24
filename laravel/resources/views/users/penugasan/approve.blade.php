@extends('users.penugasan.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')

<div class="container">
    <!-- Modal -->
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
                    <input type="text" class="form-control" name="" value="{{ $user->penempatan_kerja }}" style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Penugasan" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->penugasan }}" style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Tanggal Kunjungan" readonly>
                    <input type="date" name="tanggal_kunjungan" value="{{ $penugasan->tanggal_kunjungan }}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Selesai Kunjungan" readonly>
                    <input type="date" name="selesai_kunjungan" value="{{ $penugasan->selesai_kunjungan}}" readonly style="font-weight: bold" required placeholder="Phone number" class="form-control">
                </div>
                <div class="input-group">
                    <textarea class="form-control" name="kegiatan_penugasan" style="font-weight: bold" readonly required>{{ $penugasan->kegiatan_penugasan }}</textarea>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="PIC dikunjungi" readonly>
                    <input type="text" class="form-control" name="pic_dikunjungi" value="{{ $penugasan->pic_dikunjungi }}" readonly style="font-weight: bold" required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Alamat" readonly>
                    {{-- <input type="text" class="form-control" name="alamat_dikunjungi" readonly value="{{ $penugasan->alamat }}" style="font-weight: bold" required> --}}
                </div>
                <hr>
                <div class="input-group">
                    <input type="text" class="form-control" value="Transportasi" readonly>
                    <input type="text" class="form-control" name="transportasi" readonly value="{{ $penugasan->transportasi }}" style="font-weight: bold" required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Kelas" readonly>
                    <input type="text" class="form-control" name="kelas" readonly value="{{ $penugasan->kelas }}" style="font-weight: bold" required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Budget Hotel" readonly>
                    <input type="text" class="form-control" value="{{ $penugasan->budget_hotel }}" readonly style="font-weight: bold">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Makan" readonly>
                    <input type="text" class="form-control" value="{{ $penugasan->makan }}" readonly style="font-weight: bold">
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
                    <input type="text" class="form-control" name="diminta_oleh" value="{{ $diminta->fullname }} (DISETUJUI)" readonly>
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
                <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal" data-bs-target="#modal_pengajuan_cuti">
                    <i class="fa fa-refresh" aria-hidden="true"> </i>
                    &nbsp; Update
                </button>
        </form>
    </div>
</div>

@endsection
