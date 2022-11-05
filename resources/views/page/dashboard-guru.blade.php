@extends('layout.master')

@section('halaman', 'Dashboard')

@section('title','Dashboard')

@section('dashboard','active')

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
                    <h4 class="card-title">Jadwal Belajar Mengajar</h4>
                </div>
                <div class="pl-2 pr-2">
                    <table class="table" id="table_data">
                        <thead>
                            <tr role="row">
                                <th>Kelas</th>
                                <th>Ruang</th>
                                <th>Mapel</th>
                                <th>Hari</th>
                                <th>Jam</th>
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
            ajax: "{{ route('dashboard-guru') }}",
            columns: [{
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'sub_kelas',
                    name: 'sub_kelas'
                },
                {
                    data: 'mapel',
                    name: 'mapel'
                },
                {
                    data: 'hari',
                    name: 'hari'
                },
                {
                    data: 'jam',
                    name: 'jam'
                },
            ]
        });

    });
</script>
@endsection