@extends('layout.master')

@section('halaman', 'Master Mapel')

@section('title','Master Mapel')

@section('naik-kelas','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

<section>
    <div class="card">
        <div class="card-body">
            <form id="form-store" action="{{ route('naik.kelas.store') }}" method="post" onsubmit="return validasiForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="kelas_awal">Pilih Kelas / Ruang</label>
                        <select class="custom-select text-uppercase" id="kelas_awal">
                            <option selected value="">Pilih</option>
                            @foreach($sub_kelas_s as $sub_kelas)
                            <option class="text-uppercase" value="{{ $sub_kelas->slug }}">{{ $sub_kelas->kelas->nama_kelas }} | {{ $sub_kelas->sub_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="kelas_tujuan">Pilih Kelas / Ruang yang dituju</label>
                        <select class="custom-select text-uppercase" name="kelas_tujuan" id="kelas_tujuan">
                            <option selected value="">Pilih</option>
                            @foreach($sub_kelas_s as $sub_kelas)
                            <option class="text-uppercase" value="{{ $sub_kelas->slug }}">{{ $sub_kelas->kelas->nama_kelas }} | {{ $sub_kelas->sub_kelas }}</option>
                            @endforeach
                            <option value="lulus">Lulus</option>
                        </select>
                    </div>
                </div>
                <div id="container-table" class="table-responsive d-none">

                </div>
                <button id="btn-submit" class="btn btn-primary waves-effect waves-float waves-light d-none" type="button">Simpan</button>
            </form>
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
    $('#kelas_awal').on('change', function(e) {
        $('#container-table').removeClass('d-none');
        let val = this.value;
        if (val == '') {
            $('#container-table').addClass('d-none');
            $('#table_data').remove();
            $('#btn-submit').addClass('d-none');
        } else {
            $.ajax({
                url: `/naik-kelas/${val}/view`,
                method: 'get',
                success: function(data) {
                    $('.table-responsive').html(data);
                    $('#table_data').DataTable({
                        order: [
                            [1, 'asc']
                        ],
                    });
                    $('#btn-submit').removeClass('d-none');
                    $('#check-all').on('change', function() {
                        if ($('#check-all').is(':checked')) {
                            $('.check-siswa').prop('checked', true);
                        } else {
                            $('.check-siswa').prop('checked', false);
                        }
                    })
                }
            });
        }
    });

    $('#btn-submit').on('click', function() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data kelas dari siswa akan diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-store`).submit();
            }
        })
    });

    function validasiForm() {
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
        let kelas_tujuan = document.getElementsByName('kelas_tujuan');
        if (kelas_tujuan[0].value == "") {
            Toast.fire({
                icon: 'warning',
                title: 'Bidang kelas tujuan wajib dipilih!'
            })
            return false;
        }

        if ($('input[name="siswa[]"]:checked').length == 0) {
            Toast.fire({
                icon: 'warning',
                title: 'Harap pilih minimal 1 siswa!'
            })
            return false;
        }
    }
</script>

@endsection