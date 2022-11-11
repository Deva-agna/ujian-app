@extends('layout.master')

@section('halaman', 'Hasil Ujian')

@section('title','Hasil Ujian')

@section('list-ujian-selesai','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
@endsection

@section('konten')
<section>
    <div class="card">
        <!-- <div style="padding: 20px 20px 0 20px;" class="d-print-none d-flex justify-content-between"> -->
        <div style="padding: 20px 20px 0 20px;" class="text-right">
            <!-- <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-download"></i> Export
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" target="_blank" href="#"><i class="fa-solid fa-print"></i> Print / PDF</a>
                </div>
            </div> -->
            <a href="{{ route('list.ujian.selesai') }}" class="btn btn-sm btn-secondary">
                <span>Kembali</span>
            </a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="m-1">
                    <tr>
                        <td style="width: 1px;">Nama</td>
                        <td style="padding: 0 15px 0 15px; width: 1px;">:</td>
                        <td class="text-uppercase font-weight-bold">{{ $nilai->siswa->nama }}</td>
                    </tr>
                    <tr>
                        <td>NIS</td>
                        <td style="padding: 0 15px 0 15px;">:</td>
                        <td>{{ $nilai->siswa->nis }}</td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td style="padding: 0 15px 0 15px;">:</td>
                        <td class="text-uppercase">{{ $nilai->siswa->subKelas->kelas->nama_kelas }} | {{ $nilai->siswa->subKelas->sub_kelas }}</td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td style="padding: 0 15px 0 15px;">:</td>
                        <td>{{$nilai->ujian->waktu_ujian}} Menit</td>
                    </tr>
                    <tr>
                        <td>Mapel</td>
                        <td style="padding: 0 15px 0 15px;">:</td>
                        <td>{{$nilai->ujian->jadwalBM->mapel->nama_mapel}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card-nilai">
                    <div class="text-center">
                        Nilai<br>{{ $nilai->nilai }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @foreach($nilai->jawaban->load('soal', 'detailJawabanEssay') as $data)
            @if($data->soal->image)
            <img src="{{ asset('soal/'. $data->soal->image) }}" class=" img-fluid d-block" width="200px">
            @endif
            <div class="ql-editor" style="white-space: normal; padding: 12px 0 12px 0;">
                {!! $data->soal->soal !!}
            </div>
            <span>Jawaban:</span>
            <div>
                @if($data->detailJawabanEssay->gambar)
                <img src="{{ asset('gambar-jawaban/'. $data->detailJawabanEssay->gambar) }}" class="img-fluid d-block" alt="Jawaban dalam bentuk gambar" style="margin-top: 5px; border-radius: 5px; opacity: 0.5; cursor: pointer;" width="200px">
                @endif
                <div class="mt-1">
                    {{$data->detailJawabanEssay->jawaban}}
                </div>
            </div>
            <div style="background-color: #EAEAEA;" class="mt-1 p-1">
                Nilai : {{ $data->detailJawabanEssay->nilai }}
            </div>
            <hr>
            @endforeach
        </div>
    </div>
</section>
@endsection