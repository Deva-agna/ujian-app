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

    .ql-snow .ql-tooltip {
        position: relative;
    }
</style>
@endsection

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('soal.mc.update') }}" method="post" enctype="multipart/form-data" onsubmit="return validasiForm()">
                @method('put')
                @csrf
                <div class="card">
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
                            <label for="image_soal">Gambar</label>
                            <input type="file" name="image_soal" class="form-control-file mb-1" name="image_soal" id="image_soal" value="" accept="image/*" onchange="previewImageSoal()">
                            @if($soal->image)
                            <img src="{{ asset('soal/'. $soal->image) }}" class=" img-fluid img-preview-soal d-block" width="180px">
                            <a href="{{ route('soal.destroy.image', $soal->slug) }}" class="badge badge-primary btn-hapus" style="margin-top: 5px;" title="Hapus gambar"><i class="fa-solid fa-image" style="margin-right: 5px;"></i> Hapus</a>
                            @else
                            <img src="" class=" img-fluid img-preview-soal d-block" width="180px">
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
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        @foreach($soal->detailSoal as $data)
                        <h1 class="card-title mb-0">Jawaban</h1>
                        <input type="hidden" name="jawaban_slug[]" value="{{$data->slug}}">
                        <div class="form-group">
                            <label for="image_jawaban">Gambar</label>
                            <input type="file" name="image_jawaban[]" class="form-control-file mb-1" name="image_jawaban[]" id="image_jawaban{{$loop->iteration-1}}" accept="image/*">
                            <input id="cek_image" type="hidden" name="cek_image[]" value="">
                            @if($soal->detailSoal[$loop->iteration-1]->image)
                            <img src="{{ asset('soal/'. $soal->detailSoal[$loop->iteration-1]->image) }}" class=" img-fluid img-preview-jawaban{{$loop->iteration-1}} d-block" width="180px">
                            <a href="{{ route('soal.destroy.image', $soal->detailSoal[$loop->iteration-1]->slug) }}" class="badge badge-primary btn-hapus" style="margin-top: 5px;" title="Hapus gambar"><i class="fa-solid fa-image" style="margin-right: 5px;"></i> Hapus</a>
                            @else
                            <img src="" class=" img-fluid img-preview-jawaban{{$loop->iteration-1}} d-block" width="180px">
                            @endif
                            <input type="hidden" class=".image_old_jawaban{{$loop->iteration-1}}" name="image_old_jawaban[]" value="{{$soal->detailSoal[$loop->iteration-1]->image}}">
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <div id="ql-editor-show{{$loop->iteration-1}}">
                                <div class="editor">
                                    {!!$soal->detailSoal[$loop->iteration-1]->jawaban!!}
                                </div>
                            </div>
                            <input type="hidden" id="jawaban{{$loop->iteration-1}}" name="jawaban[]" value="{{$soal->detailSoal[$loop->iteration-1]->jawaban}}"></input>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" @if($data->kunci_jawaban) checked @endif name="checkbox[]" id="kunci_jawaban{{$loop->iteration-1}}">
                            <label class="custom-control-label" for="kunci_jawaban{{$loop->iteration-1}}">Jawaban Benar</label>
                            <input type="hidden" name="kunci_jawaban[]" value="">
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('soal.mc.list', $soal->detailUjian[0]->ujian->slug) }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                <button class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
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

    var i = "{{$soal->detailSoal->count()}}";
    var quill = [];

    $(document).ready(function() {
        for (let index = 0; index < i; index++) {
            showEditor(index);
        }
    });

    function removeTags(str) {
        if ((str === null) || (str === '<p><br></p>'))
            return str.replace(/(<([^>]+)>)/ig, '');
        else
            str = str.toString();
        return str;
    }

    function showEditor(index) {

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
            const image_old_jawaban = document.getElementsByClassName(`.image_old_jawaban${index}`);
            console.log(image_old_jawaban);
            if (image.files[0].size > 2 * 1048576) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Gambar yang diunggah maksimal 2 MB!',
                })
                image.value = "";
                const cekImage = image_old_jawaban[0].value;
                if (cekImage) {
                    imgPreview.src = `{{ asset('soal/${cekImage}') }}`;
                } else {
                    imgPreview.src = "";
                }
            } else {
                imgPreview.style.display = 'block';

                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
            }
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
        var image_old_jawaban = document.getElementsByName('image_old_jawaban[]');

        var jumlah = 0;

        for (let k = 0; k < jawaban.length; k++) {
            if (checkbox[k].checked) {
                jumlah++;
                kunci_jawaban[k].value = "1";
            } else {
                kunci_jawaban[k].value = "0";
            }
            if (jawaban[k].value == "" && image[k].value == "" && image_old_jawaban[k].value == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: `Harap isi jawaban dengan benar! Jawaban Ke ${k+1}`,
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

<script>
    function previewImageSoal() {
        const image = document.querySelector('#image_soal');
        const imgPreview = document.querySelector('.img-preview-soal');

        if (image.files[0].size > 2 * 1048576) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Gambar yang diunggah maksimal 2 MB!',
            })
            image.value = "";
            let cekImage = "{{$soal->image}}";
            if (cekImage) {
                imgPreview.src = "{{ asset('soal/'. $soal->image) }}";
            } else {
                imgPreview.src = "";
            }
        } else {
            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }

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