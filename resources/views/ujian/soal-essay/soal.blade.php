@extends('layout.master')

@section('halaman', 'Pilih Soal')

@section('title','Pilih Soal')

@section('ujian','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

<div class="card p-1">
    <div class="d-flex justify-content-between">
        <form action="{{ route('soal.essay.pilih', $ujian->slug) }}">
            <div class="input-group input-group-merge ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon-search2"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg></span>
                </div>
                <input type="text" name="cari" class="form-control form-control-sm" placeholder="Deskripsi. . ." aria-describedby="basic-addon-search2" value="{{request('cari')}}">
            </div>
        </form>
        <a href="{{ route('soal.essay.list', $ujian->slug) }}" class="btn btn-sm btn-secondary">
            <span>Kembali</span>
        </a>
    </div>
</div>

@foreach($soal_s as $soal)

<div class="card">
    <div class="card-header" style="background-color: #EAEAEA;">
        <p class="m-0">{{$soal->title}}</p>
    </div>
    <div class="card-body">
        @if($soal->image)
        <img src="{{ asset('soal/'. $soal->image) }}" class=" img-fluid img-preview-soal d-block" width="200px">
        @endif
        <div class="ql-editor" style="white-space: normal; padding: 12px 0 12px 0;">
            {!! $soal->soal !!}
        </div>
        <hr>
        <div class="d-flex justify-content-end">
            <?php
            $cek = true;
            ?>

            @foreach($soalTelahDiPilih as $data)
            @if($data->soal_id == $soal->id)
            <?php
            $cek = false;
            ?>
            @break
            @endif
            @endforeach

            @if($cek)
            <form id="form-add{{$soal->id}}" action="{{route('soal.pilih.store')}}" method="post">
                @method('post')
                @csrf
                <input type="hidden" name="ujian_id" value="{{$ujian->id}}">
                <input type="hidden" name="soal_id" value="{{$soal->id}}">
                <button class="btn-add btn btn-sm btn-warning waves-effect waves-float waves-light" data-id="{{$soal->id}}" style="background-color: transparent;">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Ke List</span>
                </button>
            </form>
            @endif
            <form id="form-duplikat{{$soal->id}}" action="{{route('duplikat.soal.store')}}" method="post" class="ml-1">
                @csrf
                @method('put')
                <input type="hidden" name="ujian_id" value="{{$ujian->id}}">
                <input type="hidden" name="soal_id" value="{{$soal->id}}">
                <button class="btn-duplikat btn btn-sm btn-info waves-effect waves-float waves-light" data-id="{{$soal->id}}" style="background-color: transparent;">
                    <i class="fa-regular fa-copy"></i>
                    <span>Duplikat</span>
                </button>
            </form>

        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    {{ $soal_s->links() }}
</div>
@endforeach

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
    $(document).on('click', '.btn-add', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Soal akan ditambahkan ke list!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tambah!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-add${id}`).submit();
            }
        })
    });

    $(document).on('click', '.btn-duplikat', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Soal akan diduplikat!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Duplikat!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-duplikat${id}`).submit();
            }
        })
    });
</script>

@endsection