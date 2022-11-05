@extends('layout.master')

@section('halaman', 'Tambah Jawaban')

@section('title','Tambah Jawaban')

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
            <form action="{{ route('soal.mc.store.jawaban') }}" method="post" enctype="multipart/form-data" onsubmit="return validasiForm()">
                @csrf
                @method('patch')
                <input type="hidden" name="slug" value="{{$soal->slug}}">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title mb-0">Jawaban</h1>
                        <div class="form-group">
                            <label for="image_jawaban">Gambar</label>
                            <input type="file" name="image_jawaban" class="form-control-file mb-1" id="image_jawaban" accept="image/*">
                            <img src="" class=" img-fluid img-preview-jawaban d-block" width="180px">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="ql-editor-show">
                                <div class="editor">

                                </div>
                            </div>
                            <input type="hidden" id="jawaban" name="jawaban"></input>
                        </div>
                        <a href="{{ route('soal.mc.list', $soal->detailUjian[0]->ujian->slug) }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
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
            'blockquote',
            'code-block'
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
        [
            'direction',
            {
                align: []
            }
        ],
        ['formula'],
    ]

    var formJawaban = new Quill('#ql-editor-show', {
        bounds: '#ql-editor-show',
        modules: {
            formula: true,
            syntax: true,
            toolbar: tools
        },
        theme: 'snow'
    });

    let enableMathQuillFormulaAuthoring = mathquill4quill();
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
        console.log(html);
        $("#jawaban").val(removeTags(html));
    });

    $("#image_jawaban").on("input", function() {
        const image = document.querySelector('#image_jawaban');
        const imgPreview = document.querySelector('.img-preview-jawaban');

        if (image.files[0].size > 2 * 1048576) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Gambar yang diunggah maksimal 2 MB!',
            })
            image.value = "";
            imgPreview.src = "";
        } else {
            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    });

    function removeTags(str) {
        if ((str === null) || (str === '<p><br></p>'))
            return str.replace(/(<([^>]+)>)/ig, '');
        else
            str = str.toString();
        return str;
    }
</script>

<script>
    function validasiForm() {

        var jawaban = document.getElementsByName('jawaban');
        var image = document.getElementsByName('image_jawaban');

        if (jawaban[0].value == "" && image[0].value == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi jawaban dengan benar!',
            });
            return false;
        }
    }
</script>

@endsection