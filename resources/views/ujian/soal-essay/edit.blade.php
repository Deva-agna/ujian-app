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
    .waves-effect {
        position: static;
    }
</style>
@endsection

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form name="myForm" action="{{ route('soal.essay.update') }}" method="post" enctype="multipart/form-data" onsubmit="return validasiFrom()">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{$soal->slug}}">
                    <div class="card-body">
                        <div>
                            <h1 class="card-title">Deskripsi</h1>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukan deskripsi/keterangan dari soal" value="{{ $soal->title }}">
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
                            <input type="hidden" class="image_old_soal" name="image_old_soal" value="{{$soal->image}}">
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
                        <a href="{{ route('soal.essay.list', $soal->detailUjian[0]->ujian->slug) }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
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

    var Editors = ['#input-soal'];
    var input = ['#soal'];
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

        let enableMathQuillFormulaAuthoring = mathquill4quill();
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
        var image_soal = document.forms["myForm"]['image_soal'].value;
        var image_old_soal = document.forms["myForm"]['image_old_soal'].value;

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
        }
    }
</script>


@endsection

@section('script')

<script>
    function previewImageSoal() {
        const image = document.querySelector('#image_soal');
        const imgPreview = document.querySelector('.img-preview-soal');
        const image_old_soal = document.getElementsByClassName('image_old_soal');
        if (image.files.length > 0) {
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                let cekImage = image_old_soal[0].value;
                if (cekImage) {
                    imgPreview.src = `{{ asset('soal/${cekImage}') }}`;
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
            let cekImage = image_old_soal[0].value;
            image.value = "";
            if (cekImage) {
                imgPreview.src = `{{ asset('soal/${cekImage}') }}`;
            } else {
                imgPreview.src = "";
                $('.img-clear-soal').addClass('d-none');
            }
        }
    }

    $('.img-clear-soal').on('click', function() {
        const image = document.querySelector('#image_soal');
        const imgPreview = document.querySelector('.img-preview-soal');
        const image_old_soal = document.getElementsByClassName('image_old_soal');
        image.value = "";
        imgPreview.src = "";
        $('.img-clear-soal').addClass('d-none');
        image_old_soal[0].value = "";
    });

    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault();
        var urlToRedirect = e.currentTarget.getAttribute('href');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Gambar akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlToRedirect
            }
        })
    });
</script>

@endsection