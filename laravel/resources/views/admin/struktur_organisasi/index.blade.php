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
                        <h5 class="card-title m-0 me-2">STRUKTUR ORGANISASI</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tree">
                    </div>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
        <!--/ Data Tables -->
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://balkan.app/js/OrgChart.js"></script>
<script>
    OrgChart.templates.mila.defs = '<marker id="arrow" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="8" markerHeight="8" orient="auto-start-reverse"><path fill="#aeaeae" d="M 0 0 L 10 5 L 0 10 z" /></marker><marker id="dotBlue" viewBox="0 0 10 10" refX="5" refY="5" markerWidth="5" markerHeight="5"> <circle cx="5" cy="5" r="5" fill="#039BE5" /></marker>';
    OrgChart.templates.mila.link = '<path marker-start="url(#dotBlue)" marker-end="url(#arrow)"   stroke-linejoin="round" stroke="#aeaeae" stroke-width="1px" fill="none" d="M{xa},{ya} {xb},{yb} {xc},{yc} L{xd},{yd}" />';
    OrgChart.templates.mila.link_field_0 = '<text text-anchor="middle" fill="#039BE5" data-width="290" x="0" y="0" style="font-size:12px;">{val}</text>';
    var chart = new OrgChart(document.getElementById("tree"), {
        enableDragDrop: true,
        template: "mila",
        nodeBinding: {
            field_0: "name",
            img_0: "foto",
            field_1: "jabatan",
        },

    });
    console.log(@json($user));
    var app = @json($user);
    chart.load(app);
    // chart.load([{
    //         id: 1,
    //         name: "Direktur Operasional",
    //         pid: '',
    //         nama_jabatan: "Direktur Operasional",
    //         foto_karyawan: "https://cdn.balkan.app/shared/2.jpg"
    //     },
    //     {
    //         id: 'a718f012-4e21-47e5-bc05-86bb9901d2e9',
    //         pid: 1,
    //         name: "Manager Produksi",
    //         nama_jabatan: "Manager Produksi",
    //         foto_karyawan: "https://cdn.balkan.app/shared/3.jpg"
    //     },
    //     {
    //         id: 3,
    //         pid: 'a718f012-4e21-47e5-bc05-86bb9901d2e9',
    //         name: "Junior Manager",
    //         nama_jabatan: "Junior Manager",
    //         foto_karyawan: "https://cdn.balkan.app/shared/4.jpg"
    //     },
    //     {
    //         id: 4,
    //         pid: 2,
    //         name: "Junior Manager Maintenance",
    //         nama_jabatan: "Junior Manager Maintenance",
    //         foto_karyawan: "https://cdn.balkan.app/shared/5.jpg"
    //     },
    //     {
    //         id: 10,
    //         pid: 2,
    //         name: "Junior Manager Quality Control",
    //         nama_jabatan: "Junior Manager Quality Control",
    //         foto_karyawan: "https://cdn.balkan.app/shared/5.jpg"
    //     },
    //     {
    //         id: 8,
    //         pid: 2,
    //         tags: ["assistant"],
    //         name: "Admin",
    //         nama_jabatan: "Admin",
    //         foto_karyawan: "https://cdn.balkan.app/shared/9.jpg"
    //     },
    //     {
    //         id: 5,
    //         pid: 10,
    //         name: "SPV QC",
    //         nama_jabatan: "SPV QC",
    //         foto_karyawan: "https://cdn.balkan.app/shared/6.jpg"
    //     },
    // ]);
</script>
@endsection