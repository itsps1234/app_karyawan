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
                        <h5 class="card-title m-0 me-2">DATA MASTER SHIFT</h5>
                    </div>
                </div>
                <div class="card-body">
                    <hr class="my-5">
                    <form action="{{ url('/rekap-data/'.$holding) }}">
                        <div class="row g-3 text-center">
                            <div class="col-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control" name="mulai" placeholder="Tanggal Mulai" id="mulai" value="{{ request('mulai') }}">
                                    <label for="mulai">Tanggal Mulai</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" class="form-control" name="akhir" placeholder="Tanggal Akhir" id="akhir" value="{{ request('akhir') }}">
                                    <label for="akhir">Tanggal Selesai</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="search" class="btn btn-primary waves-effect waves-light"><i class="menu-icon tf-icons mdi mdi-filter"></i></button>
                                <button type="button" class="btn btn-sm btn-success waves-effect waves-light"><i class="menu-icon tf-icons mdi mdi-file-excel"></i>Excel</button>
                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light"><i class="menu-icon tf-icons mdi mdi-printer"></i>cetak</button>
                            </div>
                        </div>
                    </form>
                    <hr class="my-5">
                    <table class="table" id="table_rekapdata" style="width: 100%;">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama&nbsp;Karyawan</th>
                                <th>Total&nbsp;Hadir</th>
                                <th>Total&nbsp;Izin&nbsp;Terlambat</th>
                                <th>Total&nbsp;Terlambat</th>
                                <th>Total&nbsp;Izin&nbsp;Pulang&nbsp;Cepat</th>
                                <th>Total&nbsp;Pulang&nbsp;Cepat</th>
                                <th>Total&nbsp;Alfa</th>
                                <th>Total&nbsp;Libur</th>
                                <th>Total&nbsp;Cuti&nbsp;Dadakan</th>
                                <th>Total&nbsp;Cuti&nbsp;Bersama</th>
                                <th>Total&nbsp;Cuti&nbsp;Menikah</th>
                                <th>Total&nbsp;Cuti&nbsp;Diluar&nbsp;Tanggungan </th>
                                <th>Total&nbsp;Cuti&nbsp;Khusus </th>
                                <th>Total&nbsp;Cuti&nbsp;Melahirkan</th>
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
    var table = $('#table_rekapdata').DataTable({
        "scrollY": true,
        "scrollX": true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('rekapdata-datatable') }}" + '/' + holding,
        },
        columns: [{
                data: "id",

                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'total_hadir',
                name: 'total_hadir'
            },
            {
                data: 'izin_terlambat',
                name: 'izin_terlambat'
            },
            {
                data: 'total_terlambat',
                name: 'total_terlambat'
            },
            {
                data: 'izin_pulang_cepat',
                name: 'izin_pulang_cepat'
            },
            {
                data: 'total_pulang_cepat',
                name: 'total_pulang_cepat'
            },
            {
                data: 'alfa',
                name: 'alfa'
            },
            {
                data: 'libur',
                name: 'libur'
            },
            {
                data: 'cuti_dadakan',
                name: 'cuti_dadakan'
            },
            {
                data: 'cuti_bersama',
                name: 'cuti_bersama'
            },
            {
                data: 'cuti_menikah',
                name: 'cuti_menikah'
            },
            {
                data: 'cuti_diluar_tanggungan',
                name: 'cuti_diluar_tanggungan'
            },
            {
                data: 'cuti_khusus',
                name: 'cuti_khusus'
            },
            {
                data: 'cuti_melahirkan',
                name: 'cuti_melahirkan'
            },

        ]
    });
</script>
<script>
    $(document).on("click", "#btn_edit_shift", function() {
        let id = $(this).data('id');
        let shift = $(this).data("shift");
        let jammasuk = $(this).data("jammasuk");
        let jamkeluar = $(this).data("jamkeluar");
        let holding = $(this).data("holding");
        // console.log(jamkeluar);
        $('#id_shift').val(id);
        $('#nama_shift_update').val(shift);
        $('#jam_masuk_update').val(jammasuk);
        $('#jam_keluar_update').val(jamkeluar);
        $('#modal_edit_shift').modal('show');

    });
    $(document).on('click', '#btn_delete_shift', function() {
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
                    url: "{{ url('/shift/delete/') }}" + '/' + id + '/' + holding,
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
                        $('#table_rekapdata').DataTable().ajax.reload();
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