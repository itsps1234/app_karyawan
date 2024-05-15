@extends('admin.layouts.dashboard')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
<style type="text/css">
    .my-swal {
        z-index: X;
    }
</style>
@endsection
@section('isi')
@include('sweetalert::alert')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
        <!-- Transactions -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">DATA MASTER JABATAN</h5>
                    </div>
                </div>
                <div class="card-body">
                    <hr class="my-5">
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal_tambah_jabatan"><i class="menu-icon tf-icons mdi mdi-plus"></i>Tambah</button>
                    <div class="modal fade" id="modal_tambah_jabatan" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <form method="post" action="{{ url('/jabatan/insert/'.$holding) }}" class=" modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title" id="backDropModalTitle">Tambah Jabatan</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('nama_divisi') is-invalid @enderror" id="nama_divisi" name="nama_divisi" autofocus value="{{ old('nama_divisi') }}">
                                                    <option value=""> Pilih Divisi</option>
                                                    @foreach($data_divisi as $s)
                                                    <option value="{{$s->id}}">{{$s->nama_divisi}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="nama_divisi" class="float-left">Nama Divisi</label>
                                            </div>
                                            @error('nama_divisi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" name="nama_jabatan" autofocus value="{{ old('nama_jabatan') }}">
                                                <label for="nama_jabatan" class="float-left">Nama Jabatan</label>
                                            </div>
                                            @error('nama_jabatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('level_jabatan') is-invalid @enderror" id="level_jabatan" name="level_jabatan" autofocus value="{{ old('level_jabatan') }}">
                                                    <option value=""> Pilih Level</option>
                                                    @foreach($get_level as $data)
                                                    <option value="{{$data->id}}">{{$data->level_jabatan}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="level_jabatan" class="float-left">Level Jabatan</label>
                                            </div>
                                            @error('level_jabatan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- modal edit -->
                    <div class="modal fade" id="modal_edit_jabatan" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <form method="post" action="{{ url('/jabatan/update/'.$holding) }}" class="modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title" id="backDropModalTitle">Edit Jabatan</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <input type="hidden" name="id_jabatan" id="id_jabatan" value="">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('nama_divisi_update') is-invalid @enderror" id="nama_divisi_update" name="nama_divisi_update" autofocus value="{{ old('nama_divisi_update') }}">
                                                    <option value=""> Pilih Divisi</option>
                                                    @foreach($data_divisi as $s)
                                                    <option value="{{$s->id}}">{{$s->nama_divisi}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="nama_divisi_update" class="float-left">Nama Divisi</label>
                                            </div>
                                            @error('nama_divisi_update')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" class="form-control @error('nama_jabatan_update') is-invalid @enderror" id="nama_jabatan_update" name="nama_jabatan_update" autofocus value="{{ old('nama_jabatan_update') }}">
                                                <label for="nama_jabatan_update" class="float-left">Nama Jabatan</label>
                                            </div>
                                            @error('nama_jabatan_update')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row g-2">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <select class="form-control @error('level_jabatan_update') is-invalid @enderror" id="level_jabatan_update" name="level_jabatan_update" autofocus value="{{ old('level_jabatan_update') }}">
                                                    <option value=""> Pilih Level</option>
                                                    @foreach($get_level as $data)
                                                    <option value="{{$data->id}}">{{$data->level_jabatan}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="level_jabatan_update" class="float-left">Level Jabatan</label>
                                            </div>
                                            @error('level_jabatan_update')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table" id="table_jabatan" style="width: 100%;">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Divisi</th>
                                <th>Nama&nbsp;Jabatan</th>
                                <th>Level</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
        <!--/ Data Tables -->
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    let holding = window.location.pathname.split("/").pop();
    var table = $('#table_jabatan').DataTable({
        "scrollY": true,
        "scrollX": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('jabatan-datatable') }}" + '/' + holding,
        },
        columns: [{
                data: "id",

                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'nama_divisi',
                name: 'nama_divisi'
            },
            {
                data: 'nama_jabatan',
                name: 'nama_jabatan'
            },
            {
                data: 'level_jabatan',
                name: 'level_jabatan'
            },
            {
                data: 'option',
                name: 'option'
            },
        ],
        order: [
            [1, 'asc']
        ]
    });
</script>
<script>
    $(document).on("click", "#btn_edit_jabatan", function() {
        let id = $(this).data('id');
        let divisi = $(this).data("divisi");
        let level = $(this).data("level");
        let jabatan = $(this).data("jabatan");
        let holding = $(this).data("holding");
        // console.log(divisi);
        $('#id_jabatan').val(id);
        $('#nama_divisi_update option').filter(function() {
            // console.log($(this).val().trim());
            return $(this).val().trim() == divisi
        }).prop('selected', true)
        $('#level_jabatan_update option').filter(function() {
            // console.log($(this).val().trim());
            return $(this).val().trim() == level
        }).prop('selected', true)
        $('#nama_jabatan_update').val(jabatan);
        $('#modal_edit_jabatan').modal('show');

    });
    $(document).on('click', '#btn_delete_jabatan', function() {
        var id = $(this).data('id');
        let holding = $(this).data("holding");
        console.log(id);
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Kamu tidak dapat mengembalikan data ini",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('/jabatan/delete/') }}" + '/' + id + '/' + holding,
                    type: "GET",
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data anda berhasil di hapus.',
                            icon: 'success',
                            timer: 1500
                        })
                        $('#table_jabatan').DataTable().ajax.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Cancelled!',
                    text: 'Your data is safe :',
                    icon: 'error',
                    timer: 1500
                })
            }
        });

    });
</script>
@endsection