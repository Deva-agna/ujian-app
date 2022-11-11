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
                    <table id="table_data" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Ujian Ditutup</th>
                                <th>Title</th>
                                <th>Kelas</th>
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
                [0, 'desc']
            ],
            columns: [{
                    data: 'ujian_ditutup',
                    name: 'ujian_ditutup'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'sub_kelas',
                    name: 'sub_kelas'
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