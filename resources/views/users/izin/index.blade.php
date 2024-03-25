@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container">
    <form class="my-2">
        <div class="input-group">
            <input type="date" value="{{ date('Y-m-d') }}" style="font-weight: bold" placeholder="Phone number" class="form-control">
            <input type="time" value="{{ date('H:i:s') }}" style="font-weight: bold" placeholder="Phone number" class="form-control">
        </div>
    </form>
    <button id="addForm" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%" data-toggle="modal" data-target="#myModal">
        <i class="fa fa-plus" aria-hidden="true"> </i>
        &nbsp; Add
    </button>
    <script>
        $('button').click(function(){
        $('#myModal').modal('show');
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">From Permission</h4>
                </div>
                <div class="container">
                    <form class="my-2" method="post" action="{{ url('/izin/tambah-izin-proses') }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="telp" value="{{ $data_user->telepon }}">
                            <input type="hidden" name="email" value="{{ $data_user->email }}">
                            <input type="hidden" name="departements" value="{{ $user->dept_id }}">
                            <input type="hidden" name="jabatan" value="{{ $user->jabatan_id }}">
                            <input type="hidden" name="divisi" value="{{ $user->divisi_id }}" id="">
                            <input type="hidden" name="id_user_atasan" value="{{ $getUserAtasan->id }}">
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Name" readonly>
                            <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" value="Permission Category" readonly>
                            <select name="izin" id="" style="font-weight: bold" class="form-control" required>
                                <option value="Pulang Cepat">--Select Permissions--</option>
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
                            <input type="text"  class="form-control" value="Approve By" readonly>
                            <input type="text" class="form-control" name="approve_atasan" value="{{ $getUserAtasan->name }}" readonly>
                        </div>
                        {{-- <button type="submit" class="btn btn-primary btn-rounded" style="width: 50%;margin-left: 25%;margin-right: 25%">
                            <i class="fa fa-plus" aria-hidden="true"> </i>
                            &nbsp; Submit
                        </button> --}}

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            <div class="notification-content" style="background-color: white">
                <a href="profile.html">
                    <div class="notification">
                        <h6>Izin Cuti</h6>
                        <p>Acara Keluarga</p>
                        <div class="notification-footer">
                            <span>
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 11C8.76142 11 11 8.76142 11 6C11 3.23858 8.76142 1 6 1C3.23858 1 1 3.23858 1 6C1 8.76142 3.23858 11 6 11Z" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6 3V6L8 7" stroke="#787878" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                10h ago
                            </span>
                            <p class="mb-0">Mark as read</p>
                        </div>
                    </div>
                </a>
            </div>
    </div>
@endsection
