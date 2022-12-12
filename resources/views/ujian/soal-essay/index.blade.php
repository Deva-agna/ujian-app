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
                <a class="dropdown-item" href="{{ route('soal.essay.create', $ujian->slug) }}"><i class="fa-regular fa-file"></i> Create</a>
                <a class="dropdown-item" href="{{ route('soal.essay.pilih', $ujian->slug) }}"><i class="fa-regular fa-clipboard"></i> Pilih</a>
                <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="fa-regular fa-file-excel"></i> Excel</a> -->
            </div>
        </div>
        <a href="{{ route('ujian') }}" class="btn btn-sm btn-secondary">
            <span>Kembali</span>
        </a>
    </div>
    <hr style="margin: 10px 0 0 0;">
    <div class="card-body table-responsive">
        <table class="">
            <thead>
                <tr>
                    <th style="width: 1px;">
                        No
                    </th>
                    <th style="width: 100%;" class="text-center">
                        Soal
                    </th>
                    <th style="width: 1px;">
                        Aksi
                    </th>
                </tr>
            </thead>
            @forelse($list_s as $list)
            <tr>
                <td>
                    <div class="text-nowrap">
                        {{$loop->iteration}} <span>.</span>
                    </div>
                </td>
                <td>
                    @if($list->soal->image)
                    <img src="{{ asset('soal/'. $list->soal->image) }}" class=" img-fluid img-preview-soal d-block" width="200px">
                    @endif
                    <div class="ql-editor" style="white-space: normal; padding: 12px 0 12px 0">
                        {!! $list->soal->soal !!}
                    </div>
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            @if($list->soal->status_update)
                            <a href="{{ route('soal.essay.edit', $list->soal->slug) }}" class="btn-active dropdown-item">
                                <i class="fa-solid fa-file-pen"></i>
                                <span>Edit</span>
                            </a>
                            @endif
                            <form id="form-delete{{$list->soal->id}}" action="{{route('soal.destroy.list')}}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <input type="hidden" name="slug_soal" value="{{$list->soal->slug}}">
                                <input type="hidden" name="slug_ujian" value="{{$ujian->slug}}">
                                <button class="btn-hapus dropdown-item w-100" data-id="{{$list->soal->id}}">
                                    <i class="fa-solid fa-trash-can"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center">Tidak ada soal yang ditemukan!</td>
                </tr>
            </tfoot>
            @endforelse
        </table>
    </div>
</div>
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