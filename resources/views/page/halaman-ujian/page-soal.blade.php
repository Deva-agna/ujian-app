<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title','MI Muhammadiyah 23')</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/fonts/css2.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">

    <!-- CSS sweet-alert-2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">

    <!-- font-awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/font-awesome-6.1.1/css/all.min.css') }}">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/style.css') }}">
    <!-- END: Custom CSS-->

</head>

<body>

    <div id="presubmit" class="loadingio-spinner-dual-ball-gqrevhuqhbs mt-n3 d-none">
        <div class="ldio-g2z2ox57oa">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="preload" class="loadingio-spinner-dual-ball-gqrevhuqhbs mt-n3">
        <div class="ldio-g2z2ox57oa">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <span id="durasi" class="badge badge-info fixed-top" style="border-radius: 0;">0 : 0 : 0 : 0</span>
    <section id="container">
        <div class="card card-custome mt-3">
            <div class="kop-soal pb-0 d-flex justify-content-between align-items-center">
                <img class="kop-soal-img" src="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}" alt="logo mim 23 surabaya">
                <div class="w-100 text-center">
                    <h1 class="kop-soal-title">{{$nilai->ujian->title}}</h1>
                </div>
            </div>
            <div class="title-page">
                <p>PILIHLAH SATU JAWABAN YANG DIANGGAP BENAR!</p>
            </div>
            <table class="m-1">
                <tr>
                    <td style="width: 1px;">Nama</td>
                    <td style="width: 1px; padding: 0 10px 0 10px;">:</td>
                    <td class="text-uppercase font-weight-bold">{{ Auth::guard('siswa')->user()->nama }}</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td style="padding: 0 10px 0 10px;">:</td>
                    <td>{{ Auth::guard('siswa')->user()->nis }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td style="padding: 0 10px 0 10px;">:</td>
                    <td class="text-uppercase">{{ Auth::guard('siswa')->user()->subKelas->kelas->nama_kelas }} - {{ Auth::guard('siswa')->user()->subKelas->sub_kelas }}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td style="padding: 0 10px 0 10px;">:</td>
                    <td>{{$nilai->ujian->waktu_ujian}} Menit</td>
                </tr>
                <tr>
                    <td>Mapel</td>
                    <td style="padding: 0 10px 0 10px;">:</td>
                    <td>{{$nilai->ujian->jadwalBM->mapel->nama_mapel}}</td>
                </tr>

            </table>
            <hr>
            <div class="card-body">
                <form id="myForm" action="{{ route('penilaian.pg.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="nilai_id" value="{{$nilai->id}}">
                    @foreach($nilai->jawaban as $data)
                    <input id="jawaban_hidden{{$loop->iteration}}" type="hidden" name="jawaban[]">
                    <div class="card-soal mb-1" id="error{{$loop->iteration}}">
                        <p style="width: 100%; margin: 0;" id="noSoal{{$loop->iteration}}" class="font-weight-bold badge badge-light-danger">Soal No. {{$loop->iteration}}</p>
                        <table>
                            <tr>
                                <td style="width: 100%;" colspan="2">
                                    <div class="ql-editor" style="white-space: normal;">
                                        @if($data->soal->image)
                                        <img src="{{ asset('soal/'. $data->soal->image) }}" class="img-modal img-fluid d-block mb-1" width="200px" style="cursor: pointer;">
                                        @endif
                                        {!! $data->soal->soal !!}
                                    </div>
                                </td>
                            </tr>
                            <?php $i = $loop->iteration ?>
                            @foreach($data->detailJawaban as $jawaban)
                            <tr>
                                <td style="padding-left:15px; white-space: normal;" class="ql-editor">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="jawaban<?= $i ?>{{ $loop->iteration }}" name="check[<?= $i ?>]" class="custom-control-input jawaban<?= $i ?>" value="{{$jawaban->id}}" />
                                        <label class="custom-control-label" for="jawaban<?= $i ?>{{ $loop->iteration }}">
                                            @if($jawaban->detailSoal->image)
                                            <img src="{{ asset('soal/'. $jawaban->detailSoal->image) }}" class="img-modal img-fluid d-block mb-1" width="200px" style="cursor: pointer;">
                                            @endif
                                            {!! $jawaban->detailSoal->jawaban !!}
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    @endforeach
                    <button class="btn-selesai btn-sm btn btn-primary waves-effect waves-float waves-light" type="button">Selesai</button>
                </form>
            </div>
        </div>

        <!-- Modal -->
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

    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <!-- BEGIN: Theme JS-->
    <!-- END: Theme JS-->

    <!-- font-awesome -->
    <script src="{{ asset('app-assets/css/font-awesome-6.1.1/js/all.min.js') }}"></script>

    <script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts.js') }}"></script>

    <script>
        $(`.img-modal`).on("click", function(e) {

            const src = e.target.getAttribute("src");
            document.querySelector(".modal-img").src = src;
            const myModal = new bootstrap.Modal(document.getElementById('modal-foto'));
            myModal.show();
        })
    </script>

    <script>
        var waktuMulai = new Date("{{$nilai->start}}").getTime();
        var menit = "{{$nilai->ujian->waktu_ujian}}";
        var waktuSelesai = new Date(waktuMulai + menit * 60000);

        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = waktuSelesai - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (distance > 0) {
                document.getElementById("durasi").innerHTML = days + " : " + hours + " : " +
                    minutes + " : " + seconds;
            } else {
                clearInterval(x);
                localStorage.clear();
                $('#presubmit').removeClass('d-none');
                $('#myForm').submit();
            }
        }, 1000);

        for (let index = 1; index <= "{{$nilai->jawaban->count()}}"; index++) {
            let checkLocalStorage = localStorage.getItem(`no${index}`);
            if (checkLocalStorage) {
                document.getElementById(checkLocalStorage).checked = true;
                $(`#noSoal${index}`).addClass("badge-light-success").removeClass("badge-light-danger");
            }
        }
        for (let index = 1; index <= "{{$nilai->jawaban->count()}}"; index++) {
            $(`.jawaban${index}`).on('change', function() {
                localStorage.setItem(`no${index}`, this.id);
                $(`#jawaban_hidden${index}`).val(this.value);
                $(`#noSoal${index}`).addClass("badge-light-success").removeClass("badge-light-danger");
            });
        }

        function validasiForm() {
            for (let index = 1; index <= "{{$nilai->jawaban->count()}}"; index++) {
                let data = $(`.jawaban${index}:checked`).length;
                if (data == 0) {
                    $('html, body').animate({
                        scrollTop: $(`#error${index}`).offset().top - 40
                    }, 1000);
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
                        icon: 'warning',
                        title: `Harap pilih jawaban No. ${index} !`
                    })
                    return false;
                }
            }
            return true;
        }
    </script>

    <script>
        $(document).on('click', '.btn-selesai', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Perhatian!',
                text: "Cek terlebih dahulu jawaban anda, jika anda sudah yakin maka anda dapat menekan Ya, Simpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal!',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (validasiForm()) {
                        localStorage.clear();
                        $('#presubmit').removeClass('d-none');
                        $('#myForm').submit();
                    }
                }
            })
        });
    </script>

    <script>
        var preload = document.getElementById("preload");

        window.addEventListener('load', function() {
            preload.style.display = 'none';
        })
    </script>

</body>

</html>