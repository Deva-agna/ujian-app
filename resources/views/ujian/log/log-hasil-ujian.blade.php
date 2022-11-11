@extends('layout.master')

@section('halaman', 'Peserta Ujian')

@section('title','Peserta Ujian')

@section('log','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Daftar Peserta</h4>
                    <div class="dt-action-buttons text-right">
                        <div class="dt-buttons d-inline-flex">
                            <a href="{{ route('log.ujian') }}" class="btn btn-sm btn-secondary">
                                <span>Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pl-2 pr-2 table-responsive">
                    <table id="table_data" class="table">
                        <thead>
                            <tr role="row">
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>Masuk Ujian</th>
                                <th>Status</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('vendor-js')
<script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
@endsection

@section('page-js')
<script>
    $(function() {
        var table = $('#table_data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('log.hasil.ujian', $ujian->slug) }}",
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'start',
                    name: 'start'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'nilai',
                    name: 'nilai'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

    });
</script>
@endsection