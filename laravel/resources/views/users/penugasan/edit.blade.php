@extends('users.penugasan.layout.main')
@section('title')
    APPS | KARYAWAN - SP
@endsection
@section('content')
{{-- <link rel="stylesheet" href="{{ asset('assets_ttd/libs/css/bootstrap.v3.3.6.css') }}"> --}}
<script type="text/javascript" src="{{ asset('assets_ttd/assets/signature.js') }}"></script>
<style>
    body{
    padding: 15px;
    }
    #note{position:absolute;left:50px;top:35px;padding:0px;margin:0px;cursor:default;}
</style>

    @if (Session::has('penugasansukses'))
        <div class="alert alert-success light alert-lg alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
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
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
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
        @php
            $diminta = \App\Models\User::where(['id' => $penugasan->id_diminta_oleh])->first();
            $disahkan = \App\Models\User::where(['id' => $penugasan->id_disahkan_oleh])->first();
            $diproseshrd = \App\Models\User::where(['id' => 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1'])->first();
            $diprosesfin = \App\Models\User::where(['id' => '436da676-5782-4f4e-ad50-52b45060430c'])->first();
        @endphp
        @if ($penugasan->status_penugasan == 0)
            <form class="my-2"method="post" action="{{ url('/penugasan/detail/update/'.$id_penugasan) }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                    {{-- <input type="hidden" name="telp" value="{{ $data_user->telepon }}"> --}}
                    {{-- <input type="hidden" name="email" value="{{ $data_user->email }}"> --}}
                    {{-- <input type="hidden" name="departements" value="{{ $user->dept_id }}"> --}}
                    {{-- <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}"> --}}
                    {{-- <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id=""> --}}
                    <input type="hidden" name="status_penugasan" id="" value="1">
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
                    <input type="text" class="form-control" name="" value="{{ Auth::user()->fullname }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="NIK" readonly>
                    <input type="text" class="form-control" name="" value="{{ Auth::user()->id }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Jabatan" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->nama_jabatan }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Divisi" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->nama_departemen }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Divisi" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->nama_divisi }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Asal Kerja" readonly>
                    <select class="form-control" name="asal_kerja" required>
                        <option value="">Pilih Asal Kerja...</option>
                        <option value="CV. SUMBER PANGAN - KEDIRI">CV. Sumber Pangan (Pagu)</option>
                        <option value="CV. SUMBER PANGAN - TUBAN">CV. Sumber Pangan (Tuban)</option>
                        <option value="PT. SURYA PANGAN SEMESTA - KEDIRI">PT. Surya Pangan Semesta (Kediri)</option>
                        <option value="PT. SURYA PANGAN SEMESTA - NGAWI">PT. Surya Pangan Semesta (Ngawi)</option>
                        <option value="PT. SURYA PANGAN SEMESTA - SUBANG">PT. Surya Pangan Semesta (Subang)</option>
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
                    <input type="date" name="selesai_kunjungan" value="{{ $penugasan->selesai_kunjungan }}" style="font-weight: bold" required placeholder="Phone number" class="form-control">
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
                @php
                    $diminta = \App\Models\User::where(['id' => $penugasan->id_diminta_oleh])->first();
                    $disahkan = \App\Models\User::where(['id' => $penugasan->id_disahkan_oleh])->first();
                    $diproseshrd = \App\Models\User::where(['id' => 'e30d4a42-5562-415c-b1b6-f6b9ccc379a1'])->first();
                    $diprosesfin = \App\Models\User::where(['id' => '436da676-5782-4f4e-ad50-52b45060430c'])->first();
                @endphp
                @if ($penugasan->status_penugasan == 0)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ Auth::user()->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
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
                    {{-- <button type="submit" id="save_btn" class="btn btn-primary btn-rounded" data-action="save-png"><i class="fa fa-save" aria-hidden="true"> </i>Update</button> --}}
                    {{-- <div id="signature-pad">
                        <div style="border:solid 1px teal; width:360px;height:110px;padding:3px;position:relative;">
                            <div id="note" onmouseover="my_function();">The signature should be inside box</div>
                            <canvas id="the_canvas" width="350px" height="100px"></canvas>
                        </div>
                        <div style="margin:10px;">
                            <input type="hidden" id="signature" name="signature">
                            <button type="button" id="clear_btn" class="btn btn-danger" data-action="clear"><i class="fa fa-refresh" aria-hidden="true"> </i> Clear</button>
                            <button type="submit" id="save_btn" class="btn btn-primary btn-rounded" data-action="save-png"><i class="fa fa-save" aria-hidden="true"> </i>Update</button>
                        </div>
                    </div> --}}
                @elseif($penugasan->status_penugasan == 1)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <button id="addForm" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal"
                        data-bs-target="#modal_pengajuan_cuti">
                        <i class="fa fa-refresh" aria-hidden="true"> </i>
                        &nbsp; Setujui
                    </button>
                @elseif($penugasan->status_penugasan == 2)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <button id="addForm" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal"
                        data-bs-target="#modal_pengajuan_cuti">
                        <i class="fa fa-refresh" aria-hidden="true"> </i>
                        &nbsp; Setujui
                    </button>
                @elseif($penugasan->status_penugasan == 3)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <button id="addForm" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal"
                        data-bs-target="#modal_pengajuan_cuti">
                        <i class="fa fa-refresh" aria-hidden="true"> </i>
                        &nbsp; Setujui
                    </button>
                @elseif($penugasan->status_penugasan == 4)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <button id="addForm" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%" data-bs-toggle="modal"
                        data-bs-target="#modal_pengajuan_cuti">
                        <i class="fa fa-refresh" aria-hidden="true"> </i>
                        &nbsp; Setujui
                    </button>
                @endif
            </form>
        @else
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
                    <input type="text" class="form-control" name="" value="{{ Auth::user()->fullname }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="NIK" readonly>
                    <input type="text" class="form-control" name="" value="{{ Auth::user()->id }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Jabatan" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->nama_jabatan }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Divisi" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->nama_departemen }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Divisi" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->nama_divisi }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Asal Kerja" readonly>
                    <input type="text" class="form-control" name="" value="{{ $user->penempatan_kerja }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Penugasan" readonly>
                    <input type="text" class="form-control" name="" value="{{ $penugasan->penugasan }}"
                        style="font-weight: bold" readonly required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Tanggal Kunjungan" readonly>
                    <input type="date" name="tanggal_kunjungan" value="{{ $penugasan->tanggal_kunjungan }}" readonly
                        style="font-weight: bold" required placeholder="Phone number" class="form-control">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Selesai Kunjungan" readonly>
                    <input type="date" name="selesai_kunjungan" value="{{ $penugasan->selesai_kunjungan }}" readonly
                        style="font-weight: bold" required placeholder="Phone number" class="form-control">
                </div>
                <div class="input-group">
                    <textarea class="form-control" name="kegiatan_penugasan" style="font-weight: bold" readonly required>{{ $penugasan->kegiatan_penugasan }}</textarea>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="PIC dikunjungi" readonly>
                    <input type="text" class="form-control" name="pic_dikunjungi"
                        value="{{ $penugasan->pic_dikunjungi }}" readonly style="font-weight: bold" required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Alamat" readonly>
                    <input type="text" class="form-control" name="alamat_dikunjungi" readonly
                        value="{{ $penugasan->alamat }}" style="font-weight: bold" required>
                </div>
                <hr>
                <div class="input-group">
                    <input type="text" class="form-control" value="Transportasi" readonly>
                    <input type="text" class="form-control" name="transportasi" readonly
                        value="{{ $penugasan->transportasi }}" style="font-weight: bold" required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Kelas" readonly>
                    <input type="text" class="form-control" name="kelas" readonly value="{{ $penugasan->kelas }}"
                        style="font-weight: bold" required>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Budget Hotel" readonly>
                    <input type="text" class="form-control" value="{{ $penugasan->budget_hotel }}" readonly
                        style="font-weight: bold">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control" value="Makan" readonly>
                    <input type="text" class="form-control" value="{{ $penugasan->makan }}" readonly
                        style="font-weight: bold">
                </div>
                <hr>
                @if ($penugasan->status_penugasan == 0)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ Auth::user()->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <a href="{{ url('penugasan/dashboard') }}" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%">
                        <i class="fa fa-arrow-left" aria-hidden="true"> </i>
                        &nbsp; Kembali
                    </a>
                @elseif($penugasan->status_penugasan == 1)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <a href="{{ url('penugasan/dashboard') }}" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%">
                        <i class="fa fa-arrow-left" aria-hidden="true"> </i>
                        &nbsp; Kembali
                    </a>
                @elseif($penugasan->status_penugasan == 2)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <a href="{{ url('penugasan/dashboard') }}" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%">
                        <i class="fa fa-arrow-left" aria-hidden="true"> </i>
                        &nbsp; Kembali
                    </a>
                @elseif($penugasan->status_penugasan == 3)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Belum Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <a href="{{ url('penugasan/dashboard') }}" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%">
                        <i class="fa fa-arrow-left" aria-hidden="true"> </i>
                        &nbsp; Kembali
                    </a>
                @elseif($penugasan->status_penugasan == 4)
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diajukan oleh" readonly>
                        <input type="text" class="form-control" name="" readonly
                            value="{{ $penugasan->fullname }}" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diminta oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diminta->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Disahkan oleh" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $disahkan->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses HRD" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diproseshrd->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" value="Diproses Finance" readonly>
                        <input type="text" class="form-control" name=""
                            value="{{ $diprosesfin->fullname }} (Sudah Disetujui)" readonly style="font-weight: bold">
                    </div>
                    <a href="{{ url('penugasan/dashboard') }}" class="btn btn-primary btn-rounded"
                        style="width: 50%;margin-left: 25%;margin-right: 25%">
                        <i class="fa fa-arrow-left" aria-hidden="true"> </i>
                        &nbsp; Kembali
                    </a>
                @endif
            </form>
        @endif
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
