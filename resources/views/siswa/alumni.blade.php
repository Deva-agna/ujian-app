@extends('layout.master')

@section('halaman', 'Alumni')

@section('title','Alumni')

@section('alumni','active')

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
                    <h4 class="card-title">Data Alumni</h4>
                </div>
                <div class="table-responsive pl-2 pr-2">
                    <table class="table table-striped" id="table_data">
                        <thead>
                            <tr role="row">
                                <th>nama</th>
                                <th>nis</th>
                                <th>Lulus</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="jumlah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Jumlah data siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswa.create') }}">
                    <div class="modal-body">
                        <label>Jumlah</label>
                        <div class="form-group">
                            <input type="number" name="jumlah_data" placeholder="Masukkan jumlah siswa yang ingin di input!" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lanjut</button>
                    </div>
                </form>
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
            ajax: "{{ route('alumni') }}",
            order: [
                [2, 'desc']
            ],
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'lulus',
                    name: 'lulus'
                },
            ]
        });

    });
</script>
@endsection