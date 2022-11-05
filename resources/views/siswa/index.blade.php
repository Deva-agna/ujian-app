@extends('layout.master')

@section('halaman', 'Master Siswa')

@section('title','Master Siswa')

@section('master-user','sidebar-group-active open')

@section('siswa','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

<!-- <div class="w-100 mb-1 p-1" style="background-color: #FBF8E5; color: #906F42; font-size: 14px; border: solid 2px;">
    <i style="color: #FECF08;" class="fas fa-solid fa-triangle-exclamation"></i> <span><span style="font-weight: bold;">PERHATIAN.. </span>untuk tambah siswa menggunakan excel, template dapat diunduh <a href="#" style="font-weight: bold;">di sini!</a></span>
</div> -->


<section id="ajax-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Data Siswa</h4>
                    <div class="dt-action-buttons text-right">
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button create-new btn btn-primary" data-toggle="modal" data-target="#jumlah-data">
                                <i class="fa-solid fa-plus"></i> <span>Tambah Siswa</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive pl-2 pr-2">
                    <table class="table" id="table_data">
                        <thead>
                            <tr role="row">
                                <th>nama</th>
                                <th>nis</th>
                                <th>password</th>
                                <th>kelas</th>
                                <th>Ruang</th>
                                <th>Aksi</th>
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
            ajax: "{{ route('siswa') }}",
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nis',
                    name: 'nis'
                },
                {
                    data: 'view_password',
                    name: 'view_password'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'ruang',
                    name: 'ruang'
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

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>

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
            text: "Data siswa akan dihapus!",
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

    $(document).on('click', '.btn-reset', function(e) {
        e.preventDefault();
        var urlToRedirect = e.currentTarget.getAttribute('href');
        console.log(urlToRedirect)
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Password siswa akan digenerate ulang!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Reset!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlToRedirect
            }
        })
    });
</script>

@endsection