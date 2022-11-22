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