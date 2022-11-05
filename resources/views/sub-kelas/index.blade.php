@extends('layout.master')

@section('halaman', 'Master Ruang')

@section('title','Master Ruang')

@section('sub-kelas','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

@if(session()->has('error'))
<div class="alert alert-warning alert-dismissible" role="alert">
    <h4 class="alert-heading">Peringatan!</h4>
    <div class="alert-body">
        {{session("error")}}
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif

<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Data Ruang</h4>
                    <div class="dt-action-buttons text-right">
                        <div class="dt-buttons d-inline-flex">
                            <a href="{{route('sub.kelas.create')}}" class="dt-button create-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                <i class="fa-solid fa-plus"></i> <span>Tambah Ruang</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pl-2 pr-2">
                    <table class="table" id="table_data">
                        <thead>
                            <tr role="row">
                                <th>Kode</th>
                                <th>Kelas</th>
                                <th>Ruangan</th>
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
            ajax: "{{ route('sub.kelas') }}",
            columns: [{
                    data: 'kode_sub_kelas',
                    name: 'kode_sub_kelas'
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
                    data: 'action',
                    name: 'action'
                },
            ]
        });

    });
</script>
@endsection

@section('script')

<script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>

@if(session()->has('sukses'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: '{{session("sukses")}}'
    })
</script>
@endif

<script>
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data kelas akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-delete${id}`).submit();
            }
        })
    });
</script>

@endsection