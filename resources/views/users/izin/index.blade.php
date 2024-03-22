@extends('users.izin.layout.main')
@section('title') APPS | KARYAWAN - SP @endsection
@section('content')
<div class="container">
    <form class="my-2">
        <div class="input-group">
            <input type="hidden" placeholder="" name="telp" class="form-control" value="{{ $data_user->telepon }}">
            <input type="hidden" placeholder="" name="email" class="form-control" value="{{ $data_user->email }}">
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Name" readonly>
            <input type="text" class="form-control" value="{{ Auth::user()->fullname }}" style="font-weight: bold" readonly required>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Permission Category" readonly>
            <select name="cars" id="cars" style="font-weight: bold" class="form-control" required>
                <option value="Pulang Cepat">--Select Permissions--</option>
                <option value="Pulang Cepat">Pulang Cepat</option>
                <option value="Telat Masuk">Telat Masuk</option>
                <option value="Keluar Kantor">Keluar Kantor</option>
              </select>
        </div>
        <div class="input-group">
            <input type="date" style="font-weight: bold" required placeholder="Phone number" class="form-control">
            <input type="time" style="font-weight: bold" required placeholder="Phone number" class="form-control">
        </div>
        <div class="input-group">
            <textarea class="form-control" style="font-weight: bold" required placeholder="Description"></textarea>
        </div>
        <div class="input-group">
            <input type="text" class="form-control" value="Approve By" readonly>
            <input type="text" class="form-control" value="{{ $getUserAtasan->name }}" readonly>
        </div>
        <a href="company-detail.html" class="btn btn-primary w-100 btn-rounded">Submit</a>
    </form>
</div>
<hr width="90%" style="margin-left: 5%;margin-right: 5%">
    <div class="container">
            <div class="detail-content">
                <div class="flex-1">
                    <h4>History.</h4>
                    <p>Submission Data</p>
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
