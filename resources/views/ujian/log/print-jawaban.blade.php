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