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
    <div id="loading" class="warp-loading d-none">
        <div class="loading-submit">
        </div>
    </div>
    <span id="durasi" class="badge badge-info fixed-top" style="border-radius: 0;">0 : 0 : 0 : 0</span>
    <section id="container">
        <div class="card mt-3">
            <div class="card-header pb-0 d-flex justify-content-between">
                <div>
                    <img src="{{ asset('app-assets/images/logo_majelis_pendidikan.png') }}" width="100" alt="logo majelis">
                </div>
                <div>
                    <img src="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}" width="100" alt="logo mim 23 surabaya">
                </div>
            </div>
            <div class="title-page">
                SELAMAT MENGERJAKAN!
            </div>
            <table class="m-1">
                <tr>
                    <td style="width: 1px;">Nama</td>
                    <td style="width: 1px;">:</td>
                    <td class="text-uppercase font-weight-bold">{{ Auth::guard('siswa')->user()->nama }}</td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td>{{ Auth::guard('siswa')->user()->nis }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td class="text-uppercase">{{ Auth::guard('siswa')->user()->subKelas->kelas->nama_kelas }} - {{ Auth::guard('siswa')->user()->subKelas->sub_kelas }}</td>
                </tr>
                <tr>
                    <td>Ujian</td>
                    <td>:</td>
                    <td>{{$nilai->ujian->title}}</td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>:</td>
                    <td>{{$nilai->ujian->waktu_ujian}} Menit</td>
                </tr>
                <tr>
                    <td>Mapel</td>
                    <td>:</td>
                    <td>{{$nilai->ujian->jadwalBM->mapel->nama_mapel}}</td>
                </tr>

            </table>
            <hr>
            <div class="card-body">
                <form id="myForm" action="{{ route('create.essay.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validasiForm()">
                    @method('patch')
                    @csrf
                    <input type="hidden" name="nilai_id" value="{{$nilai->id}}">
                    <input type="hidden" name="keterlambatan" value="-" id="keterlambatan">
                    @foreach($nilai->jawaban as $data)
                    <div id="soal{{$loop->iteration}}">
                        <span class="font-weight-bold" style="background-color: #EEF1FF; padding: 5px; border-radius: 5px 5px 0 0;">Soal No. {{$loop->iteration}}</span>
                        <div style="background-color: #EEF1FF; border-radius: 0 5px 5px 5px;">
                            <div class="ql-editor" style="white-space: normal;">
                                @if($data->soal->image)
                                <img src="{{ asset('soal/'. $data->soal->image) }}" class="img-modal img-fluid d-block mb-1" width="200px" style="cursor: pointer;">
                                @endif
                                {!! $data->soal->soal !!}
                            </div>
                        </div>
                        <input type="hidden" name="jawaban_id[]" value="{{ $data->id }}">
                        <div class="form-group">
                            <label for="gambar{{$loop->iteration}}">Pilih Gambar</label>
                            <input type="file" class="form-control-file" id="gambar{{$loop->iteration}}" name="gambar[]">
                            <img src="" class="img-modal img-fluid img-preview{{$loop->iteration}} d-block" style="margin-top: 5px; border-radius: 5px; opacity: 0.5; cursor: pointer;" width="50px">
                            <input type="hidden" name="cek_gambar[]" value="">
                        </div>
                        <div class="form-group">
                            <label for="jawaban">Jawaban</label>
                            <textarea class="form-control" id="jawaban" rows="2" placeholder="Masukan jawaban anda disini!" name="jawaban[]"></textarea>
                        </div>
                        <hr>
                    </div>
                    @endforeach
                    <button class="btn-selesai btn btn-primary waves-effect waves-float waves-light" type="button">Selesai</button>
                </form>
            </div>
        </div>
    </section>

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

    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>

    <script src="{{ asset('app-assets/js/scripts/components/components-modals.js') }}"></script>
    <!-- font-awesome -->
    <script src="{{ asset('app-assets/css/font-awesome-6.1.1/js/all.min.js') }}"></script>

    <script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>

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
            }

            if (distance < 0) {
                document.getElementById("durasi").innerHTML = "Terlambat " + Math.abs(days + 1) + " : " + Math.abs(hours + 1) + " : " +
                    Math.abs(minutes + 1) + " : " + Math.abs(seconds);
                var element = document.getElementById("durasi");
                element.classList.add("badge-warning");
                element.classList.remove("badge-info");
                var html = Math.abs(days + 1) + " : " + Math.abs(hours + 1) + " : " + Math.abs(minutes + 1) + " : " + Math.abs(seconds);
                $('#keterlambatan').val(html);
            }
        }, 1000);

        let panjangData = '{{ $nilai->jawaban->count() }}';

        for (let index = 1; index <= panjangData; index++) {
            $(`#gambar${index}`).on("change", function() {
                document.querySelector(`.img-preview${index}`).src = "";
                if (this.files[0].size > 2 * 1048576) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Gambar yang diunggah maksimal 2 MB!',
                    })
                    this.value = "";
                } else {
                    const gambar = document.querySelector(`#gambar${index}`);
                    const imgPreview = document.querySelector(`.img-preview${index}`);

                    const oFReader = new FileReader();
                    oFReader.readAsDataURL(gambar.files[0]);

                    oFReader.onload = function(oFREvent) {
                        imgPreview.src = oFREvent.target.result;
                    }
                }
            });
        }

        $(`.img-modal`).on("click", function(e) {

            const src = e.target.getAttribute("src");
            document.querySelector(".modal-img").src = src;
            const myModal = new bootstrap.Modal(document.getElementById('modal-foto'));
            myModal.show();
        })

        function validasiForm() {
            let gambar = document.getElementsByName('gambar[]');
            let jawaban = document.getElementsByName('jawaban[]');
            let cek_gambar = document.getElementsByName('cek_gambar[]');

            for (let index = 0; index < jawaban.length; index++) {
                if (jawaban[index].value == "" && gambar[index].value == "") {

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
                        title: `Harap isi jawaban no ${index+1}!`
                    })
                    return false;
                }
                cek_gambar[index].value = gambar[index].value;
            }
            $('#loading').removeClass('d-none');
            return true;
        }
    </script>

    <script>
        $(document).on('click', '.btn-selesai', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Perhatian!',
                text: "Check terlebih dahulu jawaban anda, jika anda sudah yakin maka anda dapat menekan Ya, Simpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#myForm').submit();
                }
            })
        });
    </script>

</body>

</html>