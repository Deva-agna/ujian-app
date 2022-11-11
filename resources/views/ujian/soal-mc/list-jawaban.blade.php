@extends('layout.master')

@section('halaman', 'Hapus Jawaban')

@section('title','Hapus Jawaban')

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

<div class="card">
    <div class="card-body">
        <table class="table">
            @foreach($soal->detailSoal as $data)
            <tr>
                @if(!$data->kunci_jawaban)
                <td>
                    <i class="fa-regular fa-circle"></i>
                </td>
                <td class="pl-1">
                    @if($data->image)
                    <img src="{{ asset('soal/'. $data->image) }}" class=" img-fluid img-preview-soal d-block" width="200px">
                    @endif
                    <div class="ql-editor" style="white-space: normal; padding: 12px 0 12px 0">
                        {!! $data->jawaban !!}
                    </div>
                </td>
                <td>
                    <form id="form-delete{{$data->id}}" action="{{route('soal.destroy.list.jawaban')}}" method="post" class="d-inline">
                        @method('put')
                        @csrf
                        <input type="hidden" name="detail_slug" value="{{$data->slug}}">
                        <button data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Hapus jawaban" class="btn-hapus badge badge-danger border-0" data-id="{{$data->id}}"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </table>
        <a href="{{ route('soal.mc.list', $soal->detailUjian[0]->ujian->slug) }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
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
            text: "Jawaban akan dihapus!",
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