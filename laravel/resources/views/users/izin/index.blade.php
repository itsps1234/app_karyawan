@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
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
@elseif(Session::has('izinsuccess'))
<div class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Sukses!</strong> Anda Berhasil Menyimpan Data Izin.
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@elseif(Session::has('hapus_izin_sukses'))
<div id="alert_hapus_izin_sukses" class="alert alert-success light alert-lg alert-dismissible fade show">
    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
        <line x1="9" y1="9" x2="9.01" y2="9"></line>
        <line x1="15" y1="9" x2="15.01" y2="9"></line>
    </svg>
    <strong>Success!</strong> Anda Berhasil Menghapus Data Izin
    <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
@endif
<div class="container">
    @if($jam_kerja=='' || $jam_kerja==NULL)
    <div id="alert_kontrak_kerja_null" class="alert alert-danger light alert-lg alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg>
        <strong>User Belum Mapping Shift.</strong> Harap Hubungi HRD.
        <button class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif
    <form class="my-2">
        <div class="input-group">
            <input type="date" value="{{ date('Y-m-d') }}" style="font-weight: bold" placeholder="Phone number" class="form-control">
            <input type="time" value="{{ date('H:i:s') }}" style="font-weight: bold" placeholder="Phone number" class="form-control">
        </div>
    </form>
    <button id="addForm" class="btn btn-sm btn-primary btn-rounded" style="width: 30%;margin-left: 35%;margin-right: 35%" data-bs-toggle="modal" data-bs-target="#myModal">
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
                            <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->name }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Kategori Izin" readonly>
                            <select name="izin" id="izin" style="font-weight: bold" class="form-control" required>
                                <option value="">--Pilih Izin--</option>
                                @foreach($kategori_izin as $izin)
                                <option value="{{$izin->nama_izin}}">{{$izin->nama_izin}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Tanggal" readonly>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" readonly style="font-weight: bold" required placeholder="Tanggal" class="form-control">
                        </div>
                        <div id="jam_masuk_kerja" class="input-group">
                            <input type="text" class="form-control" value="Jam Masuk Kerja" readonly>
                            <input type="time" id="jam_masuk" name="jam_masuk" value="@if($jam_kerja=='' || $jam_kerja==NULL)Mapping Belum Tersedia @else {{$jam_kerja->Shift->jam_masuk}} @endif" readonly style="font-weight: bold" required placeholder="Jam Masuk Kerja" class="form-control">
                        </div>
                        <div id="jam_datang" class="input-group">
                            <input type="text" class="form-control" value="Jam Datang" readonly>
                            <input type="time" id="jam" name="jam" value="{{ date('H:i') }}" readonly style="font-weight: bold" required placeholder="Jam Datang" class="form-control">
                        </div>
                        <div id="form_terlambat" class="input-group">
                            <input type="text" class="form-control" value="Terlambat" readonly>
                            <input type="text" id="terlambat" name="terlambat" value="" readonly style="font-weight: bold" required placeholder="Terlambat" class="form-control">
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
        @if ($record_data->status_izin == 0 || $record_data->status_izin=='NOT APPROVE')
        <!-- <a href="{{ url('/cuti/detail/delete/'.$record_data->id) }}"> -->
        <a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#delete{{$record_data->id}}" aria-controls="offcanvasBottom">
            <small class="badge light badge-danger" style="float: right;padding-right:10px; box-shadow: 0px 0px 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M3 6.52381C3 6.12932 3.32671 5.80952 3.72973 5.80952H8.51787C8.52437 4.9683 8.61554 3.81504 9.45037 3.01668C10.1074 2.38839 11.0081 2 12 2C12.9919 2 13.8926 2.38839 14.5496 3.01668C15.3844 3.81504 15.4756 4.9683 15.4821 5.80952H20.2703C20.6733 5.80952 21 6.12932 21 6.52381C21 6.9183 20.6733 7.2381 20.2703 7.2381H3.72973C3.32671 7.2381 3 6.9183 3 6.52381Z" fill="#1C274C" />
                    <path opacity="0.5" d="M11.5956 22.0001H12.4044C15.1871 22.0001 16.5785 22.0001 17.4831 21.1142C18.3878 20.2283 18.4803 18.7751 18.6654 15.8686L18.9321 11.6807C19.0326 10.1037 19.0828 9.31524 18.6289 8.81558C18.1751 8.31592 17.4087 8.31592 15.876 8.31592H8.12405C6.59127 8.31592 5.82488 8.31592 5.37105 8.81558C4.91722 9.31524 4.96744 10.1037 5.06788 11.6807L5.33459 15.8686C5.5197 18.7751 5.61225 20.2283 6.51689 21.1142C7.42153 22.0001 8.81289 22.0001 11.5956 22.0001Z" fill="#1C274C" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.42543 11.4815C9.83759 11.4381 10.2051 11.7547 10.2463 12.1885L10.7463 17.4517C10.7875 17.8855 10.4868 18.2724 10.0747 18.3158C9.66253 18.3592 9.29499 18.0426 9.25378 17.6088L8.75378 12.3456C8.71256 11.9118 9.01327 11.5249 9.42543 11.4815Z" fill="#1C274C" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5747 11.4815C14.9868 11.5249 15.2875 11.9118 15.2463 12.3456L14.7463 17.6088C14.7051 18.0426 14.3376 18.3592 13.9254 18.3158C13.5133 18.2724 13.2126 17.8855 13.2538 17.4517L13.7538 12.1885C13.795 11.7547 14.1625 11.4381 14.5747 11.4815Z" fill="#1C274C" />
                </svg>
            </small>
        </a>
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="delete{{$record_data->id}}" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-body text-center small">
                <h5 class="title">KONFIRMASI HAPUS</h5>
                <p>Apakah Anda Ingin Menghapus Pengajuan Izin?</p>
                <a href="{{url('/izin/delete_izin/'.$record_data->id)}}" class="btn btn-sm btn-danger light pwa-btn">Hapus</a>
                <a href="javascrpit:void(0);" class="btn btn-sm light btn-primary ms-2" data-bs-dismiss="offcanvas" aria-label="Close">Batal</a>
            </div>
        </div>
        @elseif($record_data->status_izin == 2)
        <a href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#download{{$record_data->id}}" aria-controls="offcanvasBottom">
            <small class="badge light badge-success" style="float: right;padding-right:10px; box-shadow: 0px 0px 4px;">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="18" width="18" version="1.1" id="Capa_1" viewBox="0 0 48 48" xml:space="preserve">
                    <g>
                        <g>
                            <path d="M47.987,21.938c-0.006-0.091-0.023-0.178-0.053-0.264c-0.011-0.032-0.019-0.063-0.033-0.094    c-0.048-0.104-0.109-0.202-0.193-0.285c-0.001-0.001-0.001-0.001-0.001-0.001L42,15.586V10c0-0.022-0.011-0.041-0.013-0.063    c-0.006-0.088-0.023-0.173-0.051-0.257c-0.011-0.032-0.019-0.063-0.034-0.094c-0.049-0.106-0.11-0.207-0.196-0.293l-9-9    c-0.086-0.086-0.187-0.148-0.294-0.197c-0.03-0.013-0.06-0.022-0.09-0.032c-0.086-0.03-0.174-0.047-0.264-0.053    C32.038,0.01,32.02,0,32,0H7C6.448,0,6,0.448,6,1v14.586l-5.707,5.707c0,0-0.001,0.001-0.002,0.002    c-0.084,0.084-0.144,0.182-0.192,0.285c-0.014,0.031-0.022,0.062-0.033,0.094c-0.03,0.086-0.048,0.173-0.053,0.264    C0.011,21.96,0,21.978,0,22v19c0,0.552,0.448,1,1,1h5v5c0,0.552,0.448,1,1,1h34c0.552,0,1-0.448,1-1v-5h5c0.552,0,1-0.448,1-1V22    C48,21.978,47.989,21.96,47.987,21.938z M44.586,21H42v-2.586L44.586,21z M38.586,9H33V3.414L38.586,9z M8,2h23v8    c0,0.552,0.448,1,1,1h8v5v5H8v-5V2z M6,18.414V21H3.414L6,18.414z M40,46H8v-4h32V46z M46,40H2V23h5h34h5V40z" />
                            <path d="M18.254,26.72c-0.323-0.277-0.688-0.473-1.097-0.586c-0.408-0.113-0.805-0.17-1.19-0.17h-3.332V38h2.006v-4.828h1.428    c0.419,0,0.827-0.074,1.224-0.221c0.397-0.147,0.748-0.374,1.054-0.68c0.306-0.306,0.552-0.688,0.74-1.148    c0.187-0.459,0.281-0.994,0.281-1.606c0-0.68-0.105-1.247-0.315-1.7C18.843,27.364,18.577,26.998,18.254,26.72z M16.971,31.005    c-0.306,0.334-0.697,0.501-1.173,0.501h-1.156v-3.825h1.156c0.476,0,0.867,0.147,1.173,0.442c0.306,0.295,0.459,0.765,0.459,1.411    C17.43,30.18,17.277,30.67,16.971,31.005z" />
                            <polygon points="30.723,38 32.78,38 32.78,32.832 35.857,32.832 35.857,31.081 32.764,31.081 32.764,27.8 36.112,27.8     36.112,25.964 30.723,25.964   " />
                            <path d="M24.076,25.964H21.05V38h3.009c1.553,0,2.729-0.524,3.528-1.572c0.799-1.049,1.198-2.525,1.198-4.429    c0-1.904-0.399-3.386-1.198-4.446C26.788,26.494,25.618,25.964,24.076,25.964z M26.55,33.843c-0.13,0.528-0.315,0.967-0.552,1.318    c-0.238,0.351-0.521,0.615-0.85,0.79c-0.329,0.176-0.686,0.264-1.071,0.264h-0.969v-8.466h0.969c0.385,0,0.742,0.088,1.071,0.264    c0.329,0.175,0.612,0.439,0.85,0.79c0.238,0.351,0.422,0.793,0.552,1.326s0.196,1.156,0.196,1.87    C26.746,32.702,26.68,33.316,26.55,33.843z" />
                        </g>
                    </g>
                </svg>
            </small>
        </a>
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="download{{$record_data->id}}" aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-body text-center small">
                <h5 class="title">FORM PENGAJUAN IZIN</h5>
                <p>Apakah Anda Ingin Download Form Pengajuan Izin?</p>
                <a href="{{url('/izin/cetak_form_izin/'.$record_data->id)}}" class="btn btn-sm btn-danger light pwa-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="18" width="18" version="1.1" id="Capa_1" viewBox="0 0 48 48" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M47.987,21.938c-0.006-0.091-0.023-0.178-0.053-0.264c-0.011-0.032-0.019-0.063-0.033-0.094    c-0.048-0.104-0.109-0.202-0.193-0.285c-0.001-0.001-0.001-0.001-0.001-0.001L42,15.586V10c0-0.022-0.011-0.041-0.013-0.063    c-0.006-0.088-0.023-0.173-0.051-0.257c-0.011-0.032-0.019-0.063-0.034-0.094c-0.049-0.106-0.11-0.207-0.196-0.293l-9-9    c-0.086-0.086-0.187-0.148-0.294-0.197c-0.03-0.013-0.06-0.022-0.09-0.032c-0.086-0.03-0.174-0.047-0.264-0.053    C32.038,0.01,32.02,0,32,0H7C6.448,0,6,0.448,6,1v14.586l-5.707,5.707c0,0-0.001,0.001-0.002,0.002    c-0.084,0.084-0.144,0.182-0.192,0.285c-0.014,0.031-0.022,0.062-0.033,0.094c-0.03,0.086-0.048,0.173-0.053,0.264    C0.011,21.96,0,21.978,0,22v19c0,0.552,0.448,1,1,1h5v5c0,0.552,0.448,1,1,1h34c0.552,0,1-0.448,1-1v-5h5c0.552,0,1-0.448,1-1V22    C48,21.978,47.989,21.96,47.987,21.938z M44.586,21H42v-2.586L44.586,21z M38.586,9H33V3.414L38.586,9z M8,2h23v8    c0,0.552,0.448,1,1,1h8v5v5H8v-5V2z M6,18.414V21H3.414L6,18.414z M40,46H8v-4h32V46z M46,40H2V23h5h34h5V40z" />
                                <path d="M18.254,26.72c-0.323-0.277-0.688-0.473-1.097-0.586c-0.408-0.113-0.805-0.17-1.19-0.17h-3.332V38h2.006v-4.828h1.428    c0.419,0,0.827-0.074,1.224-0.221c0.397-0.147,0.748-0.374,1.054-0.68c0.306-0.306,0.552-0.688,0.74-1.148    c0.187-0.459,0.281-0.994,0.281-1.606c0-0.68-0.105-1.247-0.315-1.7C18.843,27.364,18.577,26.998,18.254,26.72z M16.971,31.005    c-0.306,0.334-0.697,0.501-1.173,0.501h-1.156v-3.825h1.156c0.476,0,0.867,0.147,1.173,0.442c0.306,0.295,0.459,0.765,0.459,1.411    C17.43,30.18,17.277,30.67,16.971,31.005z" />
                                <polygon points="30.723,38 32.78,38 32.78,32.832 35.857,32.832 35.857,31.081 32.764,31.081 32.764,27.8 36.112,27.8     36.112,25.964 30.723,25.964   " />
                                <path d="M24.076,25.964H21.05V38h3.009c1.553,0,2.729-0.524,3.528-1.572c0.799-1.049,1.198-2.525,1.198-4.429    c0-1.904-0.399-3.386-1.198-4.446C26.788,26.494,25.618,25.964,24.076,25.964z M26.55,33.843c-0.13,0.528-0.315,0.967-0.552,1.318    c-0.238,0.351-0.521,0.615-0.85,0.79c-0.329,0.176-0.686,0.264-1.071,0.264h-0.969v-8.466h0.969c0.385,0,0.742,0.088,1.071,0.264    c0.329,0.175,0.612,0.439,0.85,0.79c0.238,0.351,0.422,0.793,0.552,1.326s0.196,1.156,0.196,1.87    C26.746,32.702,26.68,33.316,26.55,33.843z" />
                            </g>
                        </g>
                    </svg>
                    &nbsp;Download
                </a>
                <a href="javascrpit:void(0);" class="btn btn-sm light btn-primary ms-2" data-bs-dismiss="offcanvas" aria-label="Close">Batal</a>
            </div>
        </div>
        @endif
        <a href="{{url('/izin/detail/edit/'.$record_data->id)}}">
            <div class="notification">
                <h6>{{ $record_data->izin }}</h6>
                <p>{{ $record_data->keterangan_izin}}</p>
                <div class="notification-footer">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 4.01833C6.46047 4.04114 6.07192 4.09237 5.72883 4.20736C4.53947 4.60599 3.60599 5.53947 3.20736 6.72883C3 7.3475 3 8.11402 3 9.64706C3 9.74287 3 9.79078 3.01296 9.82945C3.03787 9.90378 3.09622 9.96213 3.17055 9.98704C3.20922 10 3.25713 10 3.35294 10H20.6471C20.7429 10 20.7908 10 20.8294 9.98704C20.9038 9.96213 20.9621 9.90378 20.987 9.82945C21 9.79078 21 9.74287 21 9.64706C21 8.11402 21 7.3475 20.7926 6.72883C20.394 5.53947 19.4605 4.60599 18.2712 4.20736C17.9281 4.09237 17.5395 4.04114 17 4.01833L17 6.5C17 7.32843 16.3284 8 15.5 8C14.6716 8 14 7.32843 14 6.5L14 4H10L10 6.5C10 7.32843 9.32843 8 8.50001 8C7.67158 8 7 7.32843 7 6.5L7 4.01833Z" fill="#222222" />
                            <path d="M3 11.5C3 11.2643 3 11.1464 3.07322 11.0732C3.14645 11 3.2643 11 3.5 11H20.5C20.7357 11 20.8536 11 20.9268 11.0732C21 11.1464 21 11.2643 21 11.5V12C21 15.7712 21 17.6569 19.8284 18.8284C18.6569 20 16.7712 20 13 20H11C7.22876 20 5.34315 20 4.17157 18.8284C3 17.6569 3 15.7712 3 12V11.5Z" fill="#2A4157" fill-opacity="0.24" />
                            <path d="M8.5 2.5L8.5 6.5" stroke="#222222" stroke-linecap="round" />
                            <path d="M15.5 2.5L15.5 6.5" stroke="#222222" stroke-linecap="round" />
                        </svg>
                        {{ \Carbon\Carbon::parse($record_data->tanggal)->format('d-m-Y')}}
                    </span>
                    @if ($record_data->status_izin == 0)
                    <small class="badge light badge-danger"><i class="far fa-edit"></i> Tambahkan TTD</small>
                    @elseif($record_data->status_izin == 1)
                    <small class="badge light badge-primary"><i class="fa fa-spinner"></i> Menunggu Approve</small>
                    @else
                    <small class="badge light badge-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none">
                            <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7 3.33782C8.47087 2.48697 10.1786 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 10.1786 2.48697 8.47087 3.33782 7" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Permintaan Disetujui</small>
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
            $("#alert_hapus_izin_sukses").remove();
        }, 7000); // 7 secs

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#jam_masuk_kerja').hide();
        $('#jam_datang').hide();
        $('#form_terlambat').hide();
        $('body').on("change", "#izin", function() {
            var id = $(this).val();
            // console.log(id);
            if (id == 'Sakit') {
                $('#jam_masuk_kerja').hide();
                $('#jam_datang').hide();
                $('#form_terlambat').hide();
            } else if (id == 'Tidak Masuk (Mendadak)') {
                $('#jam_masuk_kerja').hide();
                $('#form_terlambat').hide();
                $('#jam_datang').hide();
            } else if (id == 'Pulang Cepat') {
                $('#jam_masuk_kerja').hide();
                $('#form_terlambat').hide();
                $('#jam_datang').hide();
            } else if (id == 'Datang Terlambat') {
                $('#jam_masuk_kerja').show();
                $('#jam_datang').show();
                $('#form_terlambat').show();

                var awal = $('#jam_masuk').val();
                var akhir = $('#jam').val();
                var time1 = awal.split(":");
                var time2 = akhir.split(":");
                var ok1 = time1[0] + time1[1];
                var ok2 = time2[0] + time2[1];
                if (ok1 < ok2) {
                    var jam = (time2[0] - time1[0]);
                    var menit = (time2[1] - time1[1]);
                    // hours = Math.floor((diff / 60));
                    // minutes = (diff % 60);
                    console.log('jam = ' + jam);
                    console.log('menit = ' + menit);
                    // console.log('MENIT = ' + minutes);
                    $('#terlambat').val(Math.abs(jam) + ' Jam, ' + Math.abs(menit) + ' Menit')
                } else {
                    var diff1 = getTimeDiff('24:00', '{time1}', 'm');
                    var diff2 = getTimeDiff('{time2}', '00:00', 'm');
                    var totalDiff = diff1 + diff2;
                    hours = Math.floor((totalDiff / 60));
                    minutes = (totalDiff % 60);
                };
                var hasil = ((akhir - awal)) / 1000;

            } else {
                $('#kategori_cuti').hide();
                $('#kuota_hari').hide();
                $('#id_cuti').val('');
                $('#name_form_tanggal').val('Tanggal Cuti');
                var start = moment().subtract(-14, 'days');
                $('input[id="date_range_cuti"]').daterangepicker({
                    drops: 'up',
                    minDate: start,
                    startDate: start,
                    endDate: start,
                    autoApply: true,
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
            }
        });
    });
</script>
@endsection