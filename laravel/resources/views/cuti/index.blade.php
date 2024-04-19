@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card card-outline card-primary card-default">
            <div class="card-header">
                <h3 class="card-title">Tambah Cuti</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                  </div>
            </div>
            <div class="card-body mt-4 p-3">
                <form method="post" action="{{ url('/cuti/tambah') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col">
                            <label for="user_id">Nama Karyawan</label>
                            <select id="user_id" name="user_id" class="form-control selectpicker" id="">
                                <option value="{{ $data_user->id }}">{{ $data_user->name }}</option>
                            </select>
                        </div>
                        <div class="col">
                            @php
                                $cuti_dadakan = $data_user->cuti_dadakan;
                                $cuti_bersama = $data_user->cuti_bersama;
                                $cuti_menikah = $data_user->cuti_menikah;
                                $cuti_diluar_tanggungan = $data_user->cuti_diluar_tanggungan;
                                $cuti_khusus = $data_user->cuti_khusus;
                                $cuti_melahirkan = $data_user->cuti_melahirkan;
                                $izin_telat = $data_user->izin_telat;
                                $izin_pulang_cepat = $data_user->izin_pulang_cepat;

                                $data_cuti = array(
                                    [
                                        'nama' => 'Cuti Dadakan',
                                        'nama_cuti' => 'Cuti Dadakan ('.$cuti_dadakan.')'
                                    ],
                                    [
                                        'nama' => 'Cuti Bersama',
                                        'nama_cuti' => 'Cuti Bersama ('.$cuti_bersama.')'
                                    ],
                                    [
                                        'nama' => 'Cuti Menikah',
                                        'nama_cuti' => 'Cuti Menikah ('.$cuti_menikah.')'
                                    ],
                                    [
                                        'nama' => 'Cuti Diluar Tanggungan',
                                        'nama_cuti' => 'Cuti Diluar Tanggungan ('.$cuti_diluar_tanggungan.')'
                                    ],
                                    [
                                        'nama' => 'Cuti Khusus',
                                        'nama_cuti' => 'Cuti Khusus ('.$cuti_khusus.')'
                                    ],
                                    [
                                        'nama' => 'Cuti Melahirkan',
                                        'nama_cuti' => 'Cuti Melahirkan ('.$cuti_melahirkan.')'
                                    ],
                                    [
                                        'nama' => 'Izin Telat',
                                        'nama_cuti' => 'Izin Telat ('.$izin_telat.')'
                                    ],
                                    [
                                        'nama' => 'Izin Pulang Cepat',
                                        'nama_cuti' => 'Izin Pulang Cepat ('.$izin_pulang_cepat.')'
                                    ]
                                );
                            @endphp
                            <label for="nama_cuti">Nama Cuti</label>
                            <select class="form-control selectpicker @error('nama_cuti') is-invalid @enderror" id="nama_cuti" name="nama_cuti" data-live-search="true">
                                <option value="">Pilih Cuti</option>
                                @foreach ($data_cuti as $dc)
                                @if(old('nama_cuti') == $dc["nama"])
                                <option value="{{ $dc["nama"] }}" selected>{{ $dc["nama_cuti"] }}</option>
                                @else
                                <option value="{{ $dc["nama"] }}">{{ $dc["nama_cuti"] }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('nama_cuti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="datetime" class="form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="tanggal_akhir">Tanggal Akhir</label>
                            <input type="datetime" class="form-control @error('tanggal_akhir') is-invalid @enderror" name="tanggal_akhir" id="tanggal_akhir" value="{{ old('tanggal_akhir') }}">
                            @error('tanggal_akhir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <input type="hidden" name="tanggal">
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="foto_cuti">Unggah Foto</label>
                            <input type="file" name="foto_cuti" id="foto_cuti" class="form-control @error('foto_cuti') is-invalid @enderror">
                            @error('foto_cuti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="alasan_cuti">Alasan Cuti</label>
                            <input type="text" class="form-control @error('alasan_cuti') is-invalid @enderror" id="alasan_cuti" name="alasan_cuti" value="{{ old('alasan_cuti') }}">
                            @error('alasan_cuti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <input type="hidden" name="status_cuti">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                  <br>
            </div>
        </div>

        <br><br>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h3 mb-2 text-gray-800">My Cuti</h1>
           </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableprint" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Karyawan</th>
                                <th>Nama Cuti</th>
                                <th>Tanggal</th>
                                <th>Alasan Cuti</th>
                                <th>Foto Cuti</th>
                                <th>Status Cuti</th>
                                <th>Catatan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($data_cuti_user as $dcu)
                           <tr>
                               <td>{{ $loop->iteration }}</td>
                               <td>{{ $dcu->User->name }}</td>
                               <td>{{ $dcu->nama_cuti }}</td>
                               <td>{{ $dcu->tanggal}}</td>
                               <td>{{ $dcu->alasan_cuti}}</td>
                               <td>
                                    <img src="{{ url('storage/'.$dcu->foto_cuti) }}" style="width:150px" alt="">
                               </td>
                               <td>
                                    @if($dcu->status_cuti == "Diterima")
                                        <span class="badge badge-success">{{ $dcu->status_cuti }}</span>
                                    @elseif($dcu->status_cuti == "Ditolak")
                                        <span class="badge badge-danger">{{ $dcu->status_cuti }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $dcu->status_cuti }}</span>
                                    @endif
                               </td>
                               <td>{{ $dcu->catatan }}</td>
                               <td>
                                @if($dcu->status_cuti == "Diterima")
                                    <span class="badge badge-success">Sudah Approve</span>
                                @else
                                    <a href="{{ url('/cuti/edit/'.$dcu->id) }}" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-solid fa-edit"></i></a>
                                @endif

                                @if($dcu->status_cuti == "Diterima")
                                    <span class="badge badge-success">Sudah Approve</span>
                                @else
                                    <form action="{{ url('/cuti/delete/'.$dcu->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger btn-circle" onClick="return confirm('Are You Sure')"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                               </td>
                           </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
@endsection
