@extends('layout.master')

@section('halaman', 'Edit Jadwal Mengajar')

@section('title','Edit Jadwal Mengajar')

@section('jadwalBM','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }} ">
<link rel="stylesheet" type="text/css" href=" {{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }} ">
@endsection

@section('konten')

@error('error')
<div class="alert alert-warning alert-dismissible" role="alert">
    <h4 class="alert-heading">Informasi!</h4>
    <div class="alert-body">
        {{$message}}
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@enderror

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('jadwalBM.update') }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{ $jadwalBM->slug }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Guru Pengajar <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-control form-control-sm @error('user_id') is-invalid @enderror" id="user_id">
                                <option value="">Pilih</option>
                                @foreach($guru_s as $guru)
                                <option {{ old('user_id', $jadwalBM->user_id) == $guru->id ? 'selected' : '' }} value="{{ $guru->id }}">{{$guru->nama}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sub_kelas">Kelas yang diampu <span class="text-danger">*</span></label>
                            <select name="sub_kelas" class="text-uppercase form-control form-control-sm @error('sub_kelas') is-invalid @enderror" id="sub_kelas">
                                <option value="">Pilih</option>
                                @foreach($sub_kelas_s as $sub_kelas)
                                <option class="text-uppercase" {{ old('sub_kelas', $jadwalBM->sub_kelas_id) == $sub_kelas->id ? 'selected' : '' }} value="{{ $sub_kelas->id }}">{{$sub_kelas->sub_kelas}} | {{$sub_kelas->kelas->nama_kelas}}</option>
                                @endforeach
                            </select>
                            @error('sub_kelas')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mapel_id">Mapel yang diampu <span class="text-danger">*</span></label>
                            <select name="mapel_id" class="form-control form-control-sm @error('mapel_id') is-invalid @enderror" id="mapel_id">
                                <option value="">Pilih</option>
                                @foreach($mapel_s as $mapel)
                                <option {{ old('mapel_id', $jadwalBM->mapel_id) == $mapel->id ? 'selected' : '' }} value="{{ $mapel->id }}">{{$mapel->nama_mapel}}</option>
                                @endforeach
                            </select>
                            @error('mapel_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('jadwalBM') }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
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