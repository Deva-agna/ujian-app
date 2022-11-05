<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','MI Muhammadiyah 23')</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/fonts/css2.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">

    <!-- font-awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/font-awesome-6.1.1/css/all.min.css') }}">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/style.css') }}">
    <!-- END: Custom CSS-->
</head>

<body>
    <section id="">
        <div class="card mt-2">
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
                            <td class="text-uppercase">{{ $nilai->siswa->kelas->nama_kelas }}</td>
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

            <hr>
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
                <div style="background-color: #EAEAEA;" class="mt-1">
                    Nilai : {{ $data->detailJawabanEssay->nilai }}
                </div>
                <hr>
                @endforeach
            </div>
        </div>
    </section>

    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>

    <!-- font-awesome -->
    <script src="{{ asset('app-assets/css/font-awesome-6.1.1/js/all.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            window.print();
        })
    </script>
</body>

</html>