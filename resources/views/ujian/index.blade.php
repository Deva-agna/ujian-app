@extends('layout.master')

@section('halaman', 'Master Ujian')

@section('title','Master Ujian')

@section('ujian','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

@if(session()->has('error'))
<div class="alert alert-info alert-dismissible" role="alert">
    <h4 class="alert-heading">Info</h4>
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
                    <h4 class="card-title">List Ujian</h4>
                    <div class="dt-action-buttons text-right">
                        <div class="dt-buttons d-inline-flex">
                            <a href="{{route('ujian.create')}}" class="dt-button create-new btn btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                <i class="fa-solid fa-plus"></i> <span>Tambah Ujian</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pl-2 pr-2">
                    <table class="table" id="table_data">
                        <thead>
                            <tr role="row">
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
            ajax: "{{ route('ujian') }}",
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
            text: "Data Ujian akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-delete${id}`).submit();
            }
        })
    });

    $(document).on('click', '.btn-active', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        Swal.fire({
            title: 'Perhatian!',
            text: "Pastikan semua data sudah benar, paling tidak minimal ada 5 soal!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-delete${id}`).submit();
            }
        })
    });

    $(document).on('click', '.btn-cancelled', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        Swal.fire({
            title: 'Perhatian!',
            text: "Ujian akan dibatalkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-cancelled${id}`).submit();
            }
        })
    });

    $(document).on('click', '.btn-completed', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin!',
            text: "Ujian akan di tutup",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tutup!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-completed${id}`).submit();
            }
        })
    });
</script>

@endsection