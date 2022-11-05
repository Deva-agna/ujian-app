@extends('layout.master')

@section('halaman', 'Edit Data Guru')

@section('title','Edit Data Guru')

@section('master-user','sidebar-group-active open')

@section('guru','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }} ">
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }} ">
@endsection

@section('konten')
<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('guru.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{$guru->slug}}">
                    <input type="hidden" name="imgOld" value="{{$guru->img}}">
                    <input type="hidden" name="tanggal_lahir_old" value="{{$guru->tanggal_lahir}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="basicInput">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror" id="basicInput" placeholder="Masukan Nama" value="{{old('nama', $guru->nama)}}">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="basicInput">NIP <span class="text-danger">*</span></label>
                            <input type="number" name="nip" class="form-control form-control-sm @error('nip') is-invalid @enderror" id="basicInput" placeholder="Masukan NIP" value="{{old('nip', $guru->nip)}}">
                            @error('nip')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" placeholder="Masukan Email" value="{{old('email', $guru->email)}}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="@error('tanggal_lahir') is-invalid @enderror form-control  form-control-sm flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly" value="{{old('tanggal_lahir', $guru->tanggal_lahir)}}">
                            @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_telpon">No Telpon</label>
                            <input type="number" name="no_telpon" class="form-control form-control-sm" id="no_telpon" placeholder="Masukan No Telpon" value="{{old('no_telpon', $guru->no_telpon)}}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control form-control-sm" id="jenis_kelamin">
                                <option value="">Pilih</option>
                                <option {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'male' ? 'selected' : '' }} value="male">Laki - Laki</option>
                                <option {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'famale' ? 'selected' : '' }} value="famale">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-sm" id="alamat" rows="2" placeholder="Textarea">{{old('alamat', $guru->alamat)}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Foto</label>
                            <input type="file" name="image" class="form-control-file mb-1" name="image" id="image" accept="image/*" onchange="previewImage()">
                            @if($guru->img)
                            <img src="{{ asset('foto/'. $guru->img) }}" class="img-fluid img-preview mb-3 d-block" width="180px">
                            @else
                            <img src="" class=" img-fluid img-preview d-block" width="180px">
                            @endif
                        </div>
                        <a href="{{ route('guru') }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('vendor-js')

<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }} "></script>

@endsection

@section('page-js')

<script src=" {{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }} "></script>

@endsection

@section('script')

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>

@endsection