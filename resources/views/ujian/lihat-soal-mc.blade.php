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
        <a href="{{ route('ujian') }}" class="btn btn-sm btn-secondary">
            <span>Kembali</span>
        </a>
    </div>
</div>

@foreach($list_s->load('soal.detailSoal') as $list)
<div class="card">
    <div class="card-header">
        <div class="d-flex">
            <h4 class="card-title">No {{$loop->iteration}}</h4>
            <p class="ml-2 m-0">{{$list->soal->title}}</p>
        </div>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li>
                    <a data-action="collapse" class="rotate"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
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
@endforeach
@endsection