@extends('layout.master')

@section('halaman', 'Log Ujian')

@section('title','Log Ujian')

@section('log','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('konten')

<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Log Ujian</h4>
                </div>
                <div class="pl-2 pr-2 table-responsive">
                    <table id="table_data" class="table">
                        <thead>
                            <tr>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Ruang</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Durasi</th>
                                <th>Token</th>
                                <th>Tipe</th>
                                <th>Status</th>
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
            ajax: "{{ route('log.ujian') }}",
            order: [
                [3, 'desc']
            ],
            columns: [{
                    data: 'mapel',
                    name: 'mapel'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'sub_kelas',
                    name: 'sub_kelas'
                },
                {
                    data: 'waktu_mulai',
                    name: 'waktu_mulai'
                },
                {
                    data: 'waktu_selesai',
                    name: 'waktu_selesai'
                },
                {
                    data: 'waktu_ujian',
                    name: 'waktu_ujian'
                },
                {
                    data: 'token',
                    name: 'token'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'status',
                    name: 'status'
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