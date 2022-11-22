@extends('layout.master')

@section('halaman', 'Tambah Soal')

@section('title','Tambah Soal')

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
            <form name="myForm" action="{{ route('soal.mc.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validasiForm()">
                @csrf
                <div class="card">
                    <input type="hidden" name="ujian_id" value="{{$ujian->id}}">
                    <input type="hidden" name="jadwalBM_id" value="{{$ujian->jadwal_b_m_id}}">
                    <input type="hidden" name="mapel_id" value="{{$ujian->jadwalBM->mapel_id}}">
                    <input type="hidden" name="kelas_id" value="{{$ujian->jadwalBM->subKelas->kelas_id}}">
                    <div class="card-body">
                        <div>
                            <h1 class="card-title">Deskripsi</h1>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan deskripsi/keterangan dari soal">
                        </div>
                        <hr>
                        <div>
                            <h1 class="card-title">Soal</h1>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_soal" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-soal btn btn-sm btn-icon btn-outline-secondary waves-effect d-none">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_soal" class="form-control-file mb-1" name="image_soal" id="image_soal" accept="image/*" onchange="previewImageSoal()">
                            <img src="" class="mt-1 img-fluid img-preview-soal d-block" width="180px">
                        </div>
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <div id="input-soal">
                                <div class="editor">

                                </div>
                            </div>
                            <input type="hidden" id="soal" name="soal"></input>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="list-jawaban">
                            <div class="form-isian">
                                <div class="d-flex justify-content-between">
                                    <h1 class="card-title mb-0">Jawaban</h1>
                                    <button type="button" class="btn-add-jawaban btn btn-sm btn-info waves-effect waves-float waves-light"><i class="fa-solid fa-plus"></i> Tambah Jawaban</button>
                                </div>
                                <div class="form-group">
                                    <div class="flex">
                                        <label for="image_jawaban0" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                        <button type="button" class="img-clear-jawaban0 btn btn-sm btn-icon btn-outline-secondary waves-effect d-none">
                                            <i class="fa-solid fa-eraser"></i>
                                        </button>
                                    </div>
                                    <input type="file" hidden name="image_jawaban[]" class="form-control-file mb-1" id="image_jawaban0" accept="image/*">
                                    <input id="cek_image" type="hidden" name="cek_image[]" value="">
                                    <img src="" class="mt-1 img-fluid img-preview-jawaban0 d-block" width="180px">
                                </div>
                                <div class="form-group">
                                    <label>Jawaban</label>
                                    <div id="ql-editor-show0">
                                        <div class="editor">

                                        </div>
                                    </div>
                                    <input type="hidden" id="jawaban0" name="jawaban[]"></input>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="checkbox[]" id="kunci_jawaban0">
                                    <label class="custom-control-label" for="kunci_jawaban0">Jawaban Benar</label>
                                    <input type="hidden" name="kunci_jawaban[]" value="">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <a href="{{ route('soal.mc.list', $ujian->slug) }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button id="btn-submit" class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
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

    var inputSoal = new Quill('#input-soal', {
        bounds: '#input-soal',
        modules: {
            formula: true,
            syntax: true,
            toolbar: tools
        },
        theme: 'snow'
    });

    enableMathQuillFormulaAuthoring(inputSoal, {
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

    inputSoal.on('text-change', function() {
        var html = inputSoal.root.innerHTML;
        $("#soal").val(removeTags(html));
    });

    var formJawaban = new Quill('#ql-editor-show0', {
        bounds: '#ql-editor-show0',
        modules: {
            formula: true,
            syntax: true,
            toolbar: tools
        },
        theme: 'snow'
    });

    enableMathQuillFormulaAuthoring(formJawaban, {
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

    formJawaban.on('text-change', function() {
        var html = formJawaban.root.innerHTML;
        $("#jawaban0").val(removeTags(html));
    });
</script>

<script>
    listRemove = [];
    var i = 1;
    var quill = [];
    $(document).ready(function() {
        $('.btn-add-jawaban').on('click', function() {
            createEditor(i);
            i++;
        });
    });

    $(document).on('click', '.btn-remove-jawaban', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        console.log(id);
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "form jawaban akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('.form-isian').remove();
            }
        })
    });

    function removeTags(str) {
        if ((str === null) || (str === '<p><br></p>'))
            return str.replace(/(<([^>]+)>)/ig, '');
        else
            str = str.toString();
        return str;
    }

    function createEditor(index) {
        $('.list-jawaban').append(`<div class="form-isian">
                        <div class="d-flex justify-content-between">
                            <h1 class="card-title mb-0">Jawaban</h1>
                            <button type="button" data-id ="${index}" class="btn-remove-jawaban btn btn-sm btn-warning waves-effect waves-float waves-light"><i class="fa-solid fa-xmark"></i> Hapus Jawaban</button>
                        </div>
                        <div class="form-group">
                            <div class="flex">
                                <label for="image_jawaban${index}" class="mb-0 btn btn-sm btn-outline-secondary waves-effect"><i class="fa-solid fa-image"></i> Gambar</label>
                                <button type="button" class="img-clear-jawaban${index} btn btn-sm btn-icon btn-outline-secondary waves-effect d-none">
                                    <i class="fa-solid fa-eraser"></i>
                                </button>
                            </div>
                            <input type="file" hidden name="image_jawaban[]" class="form-control-file mb-1" name="image_jawaban_a" id="image_jawaban${index}" accept="image/*">
                            <input id="cek_image" type="hidden" name="cek_image[]" value="">
                            <img src="" class="mt-1 img-fluid img-preview-jawaban${index} d-block" width="180px">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="ql-editor-show${index}">
                                <div class="editor">

                                </div>
                            </div>
                            <input type="hidden" id="jawaban${index}" name="jawaban[]"></input>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="checkbox[]" id="kunci_jawaban${index}">
                            <label class="custom-control-label" for="kunci_jawaban${index}">Jawaban Benar</label>
                            <input type="hidden" name="kunci_jawaban[]" value="">
                        </div>
                        <hr>
                        </div>`);

        quill[index] = new Quill(`#ql-editor-show${index}`, {
            bounds: `#ql-editor-show${index}`,
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

        quill[index].on('text-change', function(delta, oldDelta, source) {
            var html = quill[index].root.innerHTML;
            $("#jawaban" + index).val(removeTags(html));
        })

        $("#image_jawaban" + index).on("input", function() {
            const image = document.querySelector('#image_jawaban' + index);
            const imgPreview = document.querySelector('.img-preview-jawaban' + index);

            if (image.files.length > 0) {
                if (image.files[0].size > 2 * 1048576) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Gambar yang diunggah maksimal 2 MB!',
                    })
                    image.value = "";
                    imgPreview.src = "";
                    $(`.img-clear-jawaban${index}`).addClass('d-none');
                } else {
                    imgPreview.style.display = 'block';

                    const oFReader = new FileReader();
                    oFReader.readAsDataURL(image.files[0]);

                    oFReader.onload = function(oFREvent) {
                        imgPreview.src = oFREvent.target.result;
                    }
                    $(`.img-clear-jawaban${index}`).removeClass('d-none');
                }
            } else {
                image.value = "";
                imgPreview.src = "";
                $(`.img-clear-jawaban${index}`).addClass('d-none');
            }
        });

        $(`.img-clear-jawaban${index}`).on('click', function() {
            const image = document.querySelector('#image_jawaban' + index);
            const imgPreview = document.querySelector('.img-preview-jawaban' + index);

            image.value = "";
            imgPreview.src = "";
            $(`.img-clear-jawaban${index}`).addClass('d-none');
        });
    }

    function validasiForm() {

        var deskripsi = document.getElementsByName('deskripsi');
        var soal = document.getElementsByName('soal');

        if (deskripsi[0].value == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi deskripsi dengan benar!',
            });
            return false;
        } else if (soal[0].value == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi soal dengan benar!',
            });
            return false;
        }

        var jawaban = document.getElementsByName('jawaban[]');
        var image = document.getElementsByName('image_jawaban[]');
        var checkbox = document.getElementsByName('checkbox[]');
        var kunci_jawaban = document.getElementsByName('kunci_jawaban[]');
        var cek_image = document.getElementsByName('cek_image[]');

        var jumlah = 0;

        for (let k = 0; k < jawaban.length; k++) {
            if (checkbox[k].checked) {
                jumlah++;
                kunci_jawaban[k].value = "1";
            } else {
                kunci_jawaban[k].value = "0";
            }
            if (jawaban[k].value == "" && image[k].value == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap isi jawaban dengan benar!',
                });
                return false;
            }
            cek_image[k].value = image[k].value;
        }

        if (jumlah == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pilih jawaban benar minimal 1(satu)!',
            });
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
                imgPreview.src = "";
                $('.img-clear-soal').addClass('d-none');
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
            image.value = "";
            imgPreview.src = "";
            $('.img-clear-soal').addClass('d-none');
        }
    }

    $('.img-clear-soal').on('click', function() {
        const image = document.querySelector('#image_soal');
        const imgPreview = document.querySelector('.img-preview-soal');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-soal').addClass('d-none');
    });

    $("#image_jawaban0").on("input", function() {
        const image = document.querySelector('#image_jawaban0');
        const imgPreview = document.querySelector('.img-preview-jawaban0');

        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                imgPreview.src = "";
                $('.img-clear-jawaban0').addClass('d-none');
            } else {
                imgPreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
                $('.img-clear-jawaban0').removeClass('d-none');
            }
        } else {
            image.value = "";
            imgPreview.src = "";
            $('.img-clear-jawaban0').addClass('d-none');
        }
    });

    $('.img-clear-jawaban0').on('click', function() {
        const image = document.querySelector('#image_jawaban0');
        const imgPreview = document.querySelector('.img-preview-jawaban0');

        image.value = "";
        imgPreview.src = "";
        $('.img-clear-jawaban0').addClass('d-none');
    });
</script>

@endsection