@extends('layout.master')

@section('halaman', 'Ujian')

@section('title','Ujian')

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
                    <h4 class="card-title">Jadwal Belajar</h4>
                </div>
                <div class="pl-2 pr-2 table-responsive">
                    <table class="table" id="table_data">
                        <thead>
                            <tr role="row">
                                <th>Hari</th>
                                <th>Mapel</th>
                                <th>Jam</th>
                                <th>Guru Pengajar</th>
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
            ajax: "{{ route('dashboard.siswa') }}",
            order: [
                [0, 'asc'],
                [2, 'asc'],
            ],
            columns: [{
                    data: 'hari',
                    name: 'hari'
                },
                {
                    data: 'mapel',
                    name: 'mapel'
                },
                {
                    data: 'jam',
                    name: 'jam'
                },
                {
                    data: 'pengajar',
                    name: 'pengajar'
                },
            ]
        });

    });
</script>
@endsection