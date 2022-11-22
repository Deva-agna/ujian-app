@extends('layout.master')

@section('halaman', 'Edit Soal')

@section('title','Edit Soal')

@section('ujian','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-quill-editor.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/mathquill/mathquill.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/quill/mathquill/mathquill4quill.css') }}">

<style>
    .ql-snow .ql-tooltip {
        position: relative;
    }
</style>
@endsection

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form name="myForm" action="{{ route('soal.pg.update') }}" method="post" id="myForm" enctype="multipart/form-data" onsubmit="return validasiFrom()">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{$soal->slug}}">
                    <div class="card-body">
                        <div>
                            <h1 class="card-title">Deskripsi</h1>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan deskripsi/keterangan dari soal" value="{{$soal->title}}">
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title">Soal</h1>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_soal" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-soal btn btn-sm btn-icon btn-outline-secondary waves-effect {{ !$soal->image ? 'd-none' : ''}}">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_soal" class="form-control-file mb-1" name="image_soal" id="image_soal" accept="image/*" onchange="previewImageSoal()">
                            @if($soal->image)
                            <img src="{{ asset('soal/'. $soal->image) }}" class="mt-1 img-fluid img-preview-soal d-block" width="180px">
                            @else
                            <img src="" class="mt-1 img-fluid img-preview-soal d-block" width="180px">
                            @endif
                            <input type="hidden" name="image_old_soal" value="{{$soal->image}}">
                        </div>
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <div id="input-soal">
                                <div class="editor">
                                    {!!$soal->soal!!}
                                </div>
                            </div>
                            <input type="hidden" id="soal" name="soal" value="{{$soal->soal}}"></input>
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title">Jawaban a</h1>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_jawaban_a" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-jawaban-a btn btn-sm btn-icon btn-outline-secondary waves-effect {{ !$soal->detailSoal[0]->image ? 'd-none' : ''}}">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_jawaban_a" class="form-control-file mb-1" name="image_jawaban_a" id="image_jawaban_a" accept="image/*" onchange="previewImageJawabanA()">
                            @if($soal->detailSoal[0]->image)
                            <img src="{{ asset('soal/'. $soal->detailSoal[0]->image) }}" class="mt-1 img-fluid img-preview-jawaban-a d-block" width="180px">
                            @else
                            <img src="" class="mt-1 img-fluid img-preview-jawaban-a d-block" width="180px">
                            @endif
                            <input type="hidden" name="jawaban_a_id" value="{{$soal->detailSoal[0]->id}}">
                            <input type="hidden" id="image_old_jawaban_a" name="image_old_jawaban_a" value="{{$soal->detailSoal[0]->image}}">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="input-jawaban-a">
                                <div class="editor">
                                    {!!$soal->detailSoal[0]->jawaban!!}
                                </div>
                            </div>
                            <input type="hidden" id="jawaban_a" name="jawaban_a" value="{{$soal->detailSoal[0]->jawaban}}"></input>
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title">Jawaban b</h1>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_jawaban_b" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-jawaban-b btn btn-sm btn-icon btn-outline-secondary waves-effect {{ !$soal->detailSoal[1]->image ? 'd-none' : ''}}">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_jawaban_b" class="form-control-file mb-1" name="image_jawaban_b" id="image_jawaban_b" accept="image/*" onchange="previewImageJawabanB()">
                            @if($soal->detailSoal[1]->image)
                            <img src="{{ asset('soal/'. $soal->detailSoal[1]->image) }}" class="mt-1 img-fluid img-preview-jawaban-b d-block" width="180px">
                            @else
                            <img src="" class="mt-1 img-fluid img-preview-jawaban-b d-block" width="180px">
                            @endif
                            <input type="hidden" name="jawaban_b_id" value="{{$soal->detailSoal[1]->id}}">
                            <input type="hidden" id="image_old_jawaban_b" name="image_old_jawaban_b" value="{{$soal->detailSoal[1]->image}}">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="input-jawaban-b">
                                <div class="editor">
                                    {!!$soal->detailSoal[1]->jawaban!!}
                                </div>
                            </div>
                            <input type="hidden" id="jawaban_b" name="jawaban_b" value="{{$soal->detailSoal[1]->jawaban}}"></input>
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title">Jawaban c</h1>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_jawaban_c" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-jawaban-c btn btn-sm btn-icon btn-outline-secondary waves-effect {{ !$soal->detailSoal[2]->image ? 'd-none' : ''}}">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_jawaban_c" class="form-control-file mb-1" name="image_jawaban_c" id="image_jawaban_c" accept="image/*" onchange="previewImageJawabanC()">
                            @if($soal->detailSoal[2]->image)
                            <img src="{{ asset('soal/'. $soal->detailSoal[2]->image) }}" class="mt-1 img-fluid img-preview-jawaban-c d-block" width="180px">
                            @else
                            <img src="" class="mt-1 img-fluid img-preview-jawaban-c d-block" width="180px">
                            @endif
                            <input type="hidden" name="jawaban_c_id" value="{{$soal->detailSoal[2]->id}}">
                            <input type="hidden" id="image_old_jawaban_c" name="image_old_jawaban_c" value="{{$soal->detailSoal[2]->image}}">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="input-jawaban-c">
                                <div class="editor">
                                    {!!$soal->detailSoal[2]->jawaban!!}
                                </div>
                            </div>
                            <input type="hidden" id="jawaban_c" name="jawaban_c" value="{{$soal->detailSoal[2]->jawaban}}"></input>
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title">Jawaban d</h1>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_jawaban_d" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-jawaban-d btn btn-sm btn-icon btn-outline-secondary waves-effect {{ !$soal->detailSoal[3]->image ? 'd-none' : ''}}">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_jawaban_d" class="form-control-file mb-1" name="image_jawaban_d" id="image_jawaban_d" accept="image/*" onchange="previewImageJawabanD()">
                            @if($soal->detailSoal[3]->image)
                            <img src="{{ asset('soal/'. $soal->detailSoal[3]->image) }}" class="mt-1 img-fluid img-preview-jawaban-d d-block" width="180px">
                            @else
                            <img src="" class="mt-1 img-fluid img-preview-jawaban-d d-block" width="180px">
                            @endif
                            <input type="hidden" name="jawaban_d_id" value="{{$soal->detailSoal[3]->id}}">
                            <input type="hidden" id="image_old_jawaban_d" name="image_old_jawaban_d" value="{{$soal->detailSoal[3]->image}}">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="input-jawaban-d">
                                <div class="editor">
                                    {!!$soal->detailSoal[3]->jawaban!!}
                                </div>
                            </div>
                            <input type="hidden" id="jawaban_d" name="jawaban_d" value="{{$soal->detailSoal[3]->jawaban}}"></input>
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title mb-0">Pilih kunci jawaban</h1>
                        </div>
                        <div class="demo-inline-spacing mb-3">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kunci_jawaban_a" name="kunci_jawaban" class="custom-control-input" value="a" @if($soal->detailSoal[0]->kunci_jawaban) checked @endif>
                                <label class="custom-control-label" for="kunci_jawaban_a">A</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kunci_jawaban_b" name="kunci_jawaban" class="custom-control-input" value="b" @if($soal->detailSoal[1]->kunci_jawaban) checked @endif>
                                <label class="custom-control-label" for="kunci_jawaban_b">B</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kunci_jawaban_c" name="kunci_jawaban" class="custom-control-input" value="c" @if($soal->detailSoal[2]->kunci_jawaban) checked @endif>
                                <label class="custom-control-label" for="kunci_jawaban_c">C</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kunci_jawaban_d" name="kunci_jawaban" class="custom-control-input" value="d" @if($soal->detailSoal[3]->kunci_jawaban) checked @endif>
                                <label class="custom-control-label" for="kunci_jawaban_d">D</label>
                            </div>
                        </div>
                        <a href="{{ route('soal.pg.list', $soal->detailUjian[0]->ujian->slug) }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('vendor-js')
<script src="{{ asset('app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
@endsection

@section('page-js')

<script src="{{ asset('app-assets/vendors/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/editors/quill/mathquill/mathquill.min.js') }}"></script>
<script src="{{ asset('app-assets/vendors/js/editors/quill/mathquill/mathquill4quill.js') }}"></script>

<script>
    let enableMathQuillFormulaAuthoring = mathquill4quill();
    var tools = [
        [{
            size: []
        }],
        ['bold', 'italic', 'underline', 'strike'],
        [{
                color: []
            },
            {
                background: []
            }
        ],
        [{
                script: 'super'
            },
            {
                script: 'sub'
            }
        ],
        [{
                header: '1'
            },
            {
                header: '2'
            },
        ],
        [{
                list: 'ordered'
            },
            {
                list: 'bullet'
            },
            {
                indent: '-1'
            },
            {
                indent: '+1'
            }
        ],
        ['formula'],
    ]

    var Editors = ['#input-soal', '#input-jawaban-a', '#input-jawaban-b', '#input-jawaban-c', '#input-jawaban-d'];
    var input = ['#soal', '#jawaban_a', '#jawaban_b', '#jawaban_c', '#jawaban_d'];
    var quill = [];

    for (var i = 0; i < Editors.length; i++) {
        styleEditor(i);
    }

    function styleEditor(index) {
        quill[index] = new Quill(Editors[index], {
            bounds: Editors[i],
            modules: {
                formula: true,
                syntax: true,
                toolbar: tools
            },
            theme: 'snow'
        });

        enableMathQuillFormulaAuthoring(quill[index], {
            operators: [
                ["\\pm", "\\pm"],
                ["\\sqrt{x}", "\\sqrt"],
                ["\\sqrt[3]{x}", "\\sqrt[3]{}"],
                ["\\sqrt[n]{x}", "\\nthroot"],
                ["\\frac{x}{y}", "\\frac"],
                ["\\sum^{s}_{x}{d}", "\\sum"],
                ["\\prod^{s}_{x}{d}", "\\prod"],
                ["\\coprod^{s}_{x}{d}", "\\coprod"],
                ["\\int^{s}_{x}{d}", "\\int"],
                ["\\binom{n}{k}", "\\binom"]
            ],
            displayHistory: true,
        });

        quill[index].on('text-change', function() {
            var html = quill[index].root.innerHTML;
            $(input[index]).val(removeTags(html));
        });
    }

    function removeTags(str) {
        if ((str === null) || (str === '<p><br></p>'))
            return str.replace(/(<([^>]+)>)/ig, '');
        else
            str = str.toString();
        return str;
    }

    function validasiFrom() {
        var deskripsi = document.forms["myForm"]['deskripsi'].value;
        var soal = document.forms["myForm"]['soal'].value;
        var jawabanA = document.forms["myForm"]['jawaban_a'].value;
        var jawabanB = document.forms["myForm"]['jawaban_b'].value;
        var jawabanC = document.forms["myForm"]['jawaban_c'].value;
        var jawabanD = document.forms["myForm"]['jawaban_d'].value;

        var image_soal = document.forms["myForm"]['image_soal'].value;
        var image_jawaban_a = document.forms["myForm"]['image_jawaban_a'].value;
        var image_jawaban_b = document.forms["myForm"]['image_jawaban_b'].value;
        var image_jawaban_c = document.forms["myForm"]['image_jawaban_c'].value;
        var image_jawaban_d = document.forms["myForm"]['image_jawaban_d'].value;

        var image_old_jawaban_a = document.forms["myForm"]['image_old_jawaban_a'].value;
        var image_old_jawaban_b = document.forms["myForm"]['image_old_jawaban_b'].value;
        var image_old_jawaban_c = document.forms["myForm"]['image_old_jawaban_c'].value;
        var image_old_jawaban_d = document.forms["myForm"]['image_old_jawaban_d'].value;

        var kunci_jawaban = document.forms["myForm"]['kunci_jawaban'].value;

        if (deskripsi == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi deskripsi dengan benar!',
            })
            return false;
        } else if (soal == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi soal dengan benar!',
            })
            return false;
        } else if (jawabanA == "" && image_jawaban_a == "" && image_old_jawaban_a == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi jawaban A dengan benar!',
            })
            return false;
        } else if (jawabanB == "" && image_jawaban_b == "" && image_old_jawaban_b == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi jawaban B dengan benar!',
            })
            return false;
        } else if (jawabanC == "" && image_jawaban_c == "" && image_old_jawaban_c == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi jawaban C dengan benar!',
            })
            return false;
        } else if (jawabanD == "" && image_jawaban_d == "" && image_old_jawaban_d == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi jawaban D dengan benar!',
            })
            return false;
        } else if (kunci_jawaban == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap pilih kunci jawaban!',
            })
            return false;
        }
    }
</script>


@endsection

@section('script')

<script>
    function previewImageSoal() {
        const image = document.querySelector('#image_soal');
        const imgPreview = document.querySelector('.img-preview-soal');
        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                let cekImage = $("[name='image_old_soal']");
                if (cekImage[0].value) {
                    imgPreview.src = "{{ asset('soal/'. $soal->image) }}";
                } else {
                    imgPreview.src = "";
                    $('.img-clear-soal').addClass('d-none');
                }
            } else {
                imgPreview.style.display = 'block';
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
                $('.img-clear-soal').removeClass('d-none');
            }
        } else {
            let cekImage = $("[name='image_old_soal']");
            image.value = "";
            if (cekImage[0].value) {
                imgPreview.src = "{{ asset('soal/'. $soal->image) }}";
            } else {
                imgPreview.src = "";
                $('.img-clear-soal').addClass('d-none');
            }
        }
    }

    $('.img-clear-soal').on('click', function() {
        const image = document.querySelector('#image_soal');
        const imgPreview = document.querySelector('.img-preview-soal');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-soal').addClass('d-none');
        $("[name='image_old_soal']").val("");
    });

    function previewImageJawabanA() {
        const image = document.querySelector('#image_jawaban_a');
        const imgPreview = document.querySelector('.img-preview-jawaban-a');
        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                let cekImage = $("[name='image_old_jawaban_a']");
                if (cekImage[0].value) {
                    imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[0]->image) }}";
                } else {
                    imgPreview.src = "";
                    $('.img-clear-jawaban-a').addClass('d-none');
                }
            } else {
                imgPreview.style.display = 'block';
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
                $('.img-clear-jawaban-a').removeClass('d-none');
            }
        } else {
            let cekImage = $("[name='image_old_jawaban_a']");
            image.value = "";
            if (cekImage[0].value) {
                imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[0]->image) }}";
            } else {
                imgPreview.src = "";
                $('.img-clear-jawaban-a').addClass('d-none');
            }
        }
    }

    $('.img-clear-jawaban-a').on('click', function() {
        const image = document.querySelector('#image_jawaban_a');
        const imgPreview = document.querySelector('.img-preview-jawaban-a');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-jawaban-a').addClass('d-none');
        $("[name='image_old_jawaban_a']").val("");
    });

    function previewImageJawabanB() {
        const image = document.querySelector('#image_jawaban_b');
        const imgPreview = document.querySelector('.img-preview-jawaban-b');
        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                let cekImage = $("[name='image_old_jawaban_b']");
                if (cekImage[0].value) {
                    imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[1]->image) }}";
                } else {
                    imgPreview.src = "";
                    $('.img-clear-jawaban-b').addClass('d-none');
                }
            } else {
                imgPreview.style.display = 'block';
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
                $('.img-clear-jawaban-b').removeClass('d-none');
            }
        } else {
            let cekImage = $("[name='image_old_jawaban_b']");
            image.value = "";
            if (cekImage[0].value) {
                imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[1]->image) }}";
            } else {
                imgPreview.src = "";
                $('.img-clear-jawaban-b').addClass('d-none');
            }
        }
    }

    $('.img-clear-jawaban-b').on('click', function() {
        const image = document.querySelector('#image_jawaban_b');
        const imgPreview = document.querySelector('.img-preview-jawaban-b');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-jawaban-b').addClass('d-none');
        $("[name='image_old_jawaban_b']").val("");
    });

    function previewImageJawabanC() {
        const image = document.querySelector('#image_jawaban_c');
        const imgPreview = document.querySelector('.img-preview-jawaban-c');
        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                let cekImage = $("[name='image_old_jawaban_c']");
                if (cekImage[0].value) {
                    imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[2]->image) }}";
                } else {
                    imgPreview.src = "";
                    $('.img-clear-jawaban-c').addClass('d-none');
                }
            } else {
                imgPreview.style.display = 'block';
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
                $('.img-clear-jawaban-c').removeClass('d-none');
            }
        } else {
            let cekImage = $("[name='image_old_jawaban_c']");
            image.value = "";
            if (cekImage[0].value) {
                imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[2]->image) }}";
            } else {
                imgPreview.src = "";
                $('.img-clear-jawaban-c').addClass('d-none');
            }
        }
    }

    $('.img-clear-jawaban-c').on('click', function() {
        const image = document.querySelector('#image_jawaban_c');
        const imgPreview = document.querySelector('.img-preview-jawaban-c');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-jawaban-c').addClass('d-none');
        $("[name='image_old_jawaban_c']").val("");
    });

    function previewImageJawabanD() {
        const image = document.querySelector('#image_jawaban_d');
        const imgPreview = document.querySelector('.img-preview-jawaban-d');
        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                let cekImage = $("[name='image_old_jawaban_d']");
                if (cekImage[0].value) {
                    imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[3]->image) }}";
                } else {
                    imgPreview.src = "";
                    $('.img-clear-jawaban-d').addClass('d-none');
                }
            } else {
                imgPreview.style.display = 'block';
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
                $('.img-clear-jawaban-d').removeClass('d-none');
            }
        } else {
            let cekImage = $("[name='image_old_jawaban_d']");
            image.value = "";
            if (cekImage[0].value) {
                imgPreview.src = "{{ asset('soal/'. $soal->detailSoal[3]->image) }}";
            } else {
                imgPreview.src = "";
                $('.img-clear-jawaban-d').addClass('d-none');
            }
        }
    }

    $('.img-clear-jawaban-d').on('click', function() {
        const image = document.querySelector('#image_jawaban_d');
        const imgPreview = document.querySelector('.img-preview-jawaban-d');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-jawaban-d').addClass('d-none');
        $("[name='image_old_jawaban_d']").val("");
    });
</script>

@endsection