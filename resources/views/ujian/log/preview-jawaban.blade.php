@extends('layout.master')

@section('halaman', 'Jawaban Siswa')

@section('title','Jawaban Siswa')

@section('log','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
@endsection

@section('konten')

<section>
    <div class="card mt-2">
        <div style="padding: 20px 20px 0 20px;" class="d-print-none d-flex justify-content-between">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-download"></i> Export
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" target="_blank" href="{{ route('print.jawaban', $nilai->id) }}"><i class="fa-solid fa-print"></i> Print / PDF</a>
                </div>
            </div>
            <a href="{{ route('log.hasil.ujian', $nilai->ujian->slug) }}" class="btn btn-sm btn-secondary">
                <span>Kembali</span>
            </a>
        </div>
        <div class="row p-1">
            <div class="col-md-6">
                <table class="m-1">
                    <tr>
                        <td style="width: 1px;">Nama</td>
                        <td style="padding: 0 15px 0 15px;">:</td>
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
                        <td>Ujian</td>
                        <td style="padding: 0 15px 0 15px;">:</td>
                        <td>{{$nilai->ujian->title}}</td>
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
            <div class="col-md-6 d-flex justify-content-around align-items-center">
                <div class="card-nilai">
                    <div class="text-center">
                        Nilai<br>{{ $nilai->nilai }}
                    </div>
                </div>
                <div class="card-nilai">
                    <div class="text-center">
                        Benar<br>{{ $nilai->benar }}
                    </div>
                </div>
                <div class="card-nilai">
                    <div class="text-center">
                        Salah<br>{{ $nilai->salah }}
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="card-body">
            @foreach($nilai->jawaban->load('soal.detailSoal', 'detailJawaban.detailSoal') as $data)
            <table>
                <tr id="jawaban{{$loop->iteration}}">
                    <td style="width: 100%;" colspan="2">
                        <span class="font-weight-bold">Soal No. {{$loop->iteration}}</span>
                        <div class="ql-editor" style="white-space: normal;">
                            @if($data->soal->image)
                            <img src="{{ asset('soal/'. $data->soal->image) }}" class=" img-fluid d-block" width="200px">
                            @endif
                            {!! $data->soal->soal !!}
                        </div>
                    </td>
                </tr>
                <?php $huruf = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I']  ?>
                @foreach($data->detailJawaban as $jawaban)
                <tr>
                    <td style="padding:0 0 0 15px;">
                        <div class="d-flex align-items-center">
                            @if($jawaban->status)
                            <i class="fa-solid {{ $nilai->ujian->type_ujian == 'pg' ? 'fa-circle' : 'fa-square-check' }}" style="margin-right: 5px;"></i>
                            <span><?= $huruf[$loop->iteration - 1] ?></span>
                            @else
                            <i class="fa-regular {{ $nilai->ujian->type_ujian == 'pg' ? 'fa-circle' : 'fa-square' }}" style="margin-right: 5px;"></i>
                            <span><?= $huruf[$loop->iteration - 1] ?></span>
                            @endif
                        </div>
                    </td>
                    <td style="padding-left:15px; white-space: normal; width: 100%;" class="ql-editor">
                        @if($jawaban->detailSoal->image)
                        <img src="{{ asset('soal/'. $jawaban->detailSoal->image) }}" class="img-fluid d-block" width="200px">
                        @endif
                        {!! $jawaban->detailSoal->jawaban !!}
                    </td>
                </tr>
                @endforeach
            </table>
            <span>Kunci Jawaban :
                @foreach($data->soal->detailSoal as $kunciJawaban)
                @if($kunciJawaban->kunci_jawaban)
                <?= $huruf[$loop->iteration - 1] ?>
                @endif
                @endforeach
            </span>
            <hr>
            @endforeach
        </div>
    </div>
</section>

@endsection