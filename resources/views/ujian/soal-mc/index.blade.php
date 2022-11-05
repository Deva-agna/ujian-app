@extends('layout.master')

@section('halaman', 'List Soal')

@section('title','List Soal')

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
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-plus"></i> Tambah Soal
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('soal.mc.create', $ujian->slug) }}"><i class="fa-regular fa-file"></i> Create</a>
                <a class="dropdown-item" href="{{ route('soal.mc.pilih', $ujian->slug) }}"><i class="fa-regular fa-clipboard"></i> Pilih</a>
                <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="fa-regular fa-file-excel"></i> Excel</a> -->
            </div>
        </div>
        <a href="{{ route('ujian') }}" class="btn btn-sm btn-secondary">
            <span>Kembali</span>
        </a>
    </div>
</div>

@forelse($list_s->load('soal.detailSoal') as $list)
<div class="card">
    <div class="card-header">
        <div class="d-flex">
            <h4 class="card-title">No {{$loop->iteration}}</h4>
            <p class="ml-2 m-0">{{$list->soal->title}}</p>
        </div>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li>
                    @if($list->soal->status_update)
                    <a href="{{ route('soal.mc.create.jawaban', $list->soal->slug) }}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tambah Jawaban" class="badge badge-info"><i class="fa-solid fa-plus"></i></a>
                    <a href="{{ route('soal.list.jawaban', $list->soal->slug) }}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Hapus Jawaban" class="badge badge-warning"><i class="fa-solid fa-xmark"></i></a>
                    <a href="{{ route('soal.mc.edit', $list->soal->slug) }}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit Soal" class="badge badge-primary"><i class="fa-solid fa-file-pen"></i></a>
                    @endif
                    <form id="form-delete{{$list->soal->id}}" action="{{route('soal.destroy.list')}}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <input type="hidden" name="slug_soal" value="{{$list->soal->slug}}">
                        <input type="hidden" name="slug_ujian" value="{{$ujian->slug}}">
                        <button data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Hapus soal dari list" class="btn-hapus badge badge-danger border-0" data-id="{{$list->soal->id}}"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </li>
                <li>
                    <a data-action="collapse" class="rotate"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse">
        <div class="card-body">
            @if($list->soal->image)
            <img src="{{ asset('soal/'. $list->soal->image) }}" class=" img-fluid img-preview-soal d-block" width="200px">
            @endif
            <div class="ql-editor" style="white-space: normal; padding: 12px 0 12px 0;">
                {!! $list->soal->soal !!}
            </div>
            <hr>
            <table>
                @foreach($list->soal->detailSoal as $data)
                <tr>
                    <td>
                        @if($data->kunci_jawaban)
                        <i class="fa-solid fa-circle-check"></i>
                        @else
                        <i class="fa-regular fa-circle"></i>
                        @endif
                    </td>
                    <td class="pl-1">
                        @if($data->image)
                        <img src="{{ asset('soal/'. $data->image) }}" class=" img-fluid img-preview-soal d-block" width="200px">
                        @endif
                        <div class="ql-editor" style="white-space: normal; padding: 12px 0 12px 0">
                            {!! $data->jawaban !!}
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@empty
<div class="text-center">
    <span>Tidak ada soal yang ditemukan!</span>
</div>
@endforelse
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
            text: "Soal akan dihapus dari list!",
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