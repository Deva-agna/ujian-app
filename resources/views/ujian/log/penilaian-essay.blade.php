@extends('layout.master')

@section('halaman', 'Penilaian')

@section('title','Penilaian')

@section('log','active')

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
<section>
    <div class="card">
        <div style="padding: 20px 20px 0 20px;" class="d-print-none d-flex justify-content-between">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-download"></i> Export
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" target="_blank" href="{{ route('print.jawaban.essay', $nilai->id) }}"><i class="fa-solid fa-print"></i> Print / PDF</a>
                </div>
            </div>
            <a href="{{ route('log.hasil.ujian', $nilai->ujian->slug) }}" class="btn btn-sm btn-secondary">
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
                        <td class="text-uppercase">{{ $nilai->siswa->subKelas->kelas->nama_kelas }}</td>
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
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card-nilai">
                    <div class="text-center">
                        Nilai<br>{{ $nilai->nilai }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('error'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <h4 class="alert-heading">Info</h4>
        <div class="alert-body">
            {{session("error")}}
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('penilaian.essay.store') }}" method="post">
                @csrf
                @method('patch')

                <input type="hidden" name="nilai_id" value="{{$nilai->id}}">

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
                    <img src="{{ asset('gambar-jawaban/'. $data->detailJawabanEssay->gambar) }}" class="img-modal img-fluid d-block" alt="Jawaban dalam bentuk gambar" style="margin-top: 5px; border-radius: 5px; opacity: 0.5; cursor: pointer;" width="50px">
                    @endif
                    <div class="mt-1">
                        {{$data->detailJawabanEssay->jawaban}}
                    </div>
                </div>
                <div style="background-color: #EAEAEA;" class="mt-1">
                    <div class="form-group p-1">
                        <label for="nilai">Nilai <span class="text-danger">*</span></label>
                        <input type="number" name="nilai[]" class="form-control  @error('nilai.' . $loop->iteration-1) is-invalid @enderror" id="nilai" placeholder="Masukan nilai" value="{{old('nilai.' . $loop->iteration-1, $data->detailJawabanEssay->nilai)}}">
                        @error('nilai.' . $loop->iteration-1)
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                        <input type="hidden" name="detail_jawaban_essay_id[]" value="{{$data->detailJawabanEssay->id}}">
                    </div>
                </div>
                <hr>
                @endforeach
                <button class="btn-selesai btn btn-primary waves-effect waves-float waves-light" type="sumbit">Simpan</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-foto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="modal-img w-100" alt="modal img" style="border-radius: 10px;">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

<script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>

<script>
    $(`.img-modal`).on("click", function(e) {

        const src = e.target.getAttribute("src");
        document.querySelector(".modal-img").src = src;
        const myModal = new bootstrap.Modal(document.getElementById('modal-foto'));
        myModal.show();
    })
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

@endsection