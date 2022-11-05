@extends('layout.master')

@section('halaman', 'Tambah Jadwal Belajar Mengajar')

@section('title','Tambah Jadwal Belajar Mengajar')

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

<div class="w-100 mb-1 p-1" style="background-color: #FBF8E5; color: #906F42; font-size: 14px; border: solid 2px;">
    <i style="color: #FECF08;" class="fas fa-solid fa-triangle-exclamation"></i> <span><span style="font-weight: bold;">PERHATIAN.. </span>untuk jam mengajar harap diisi dengan benar!</span>
</div>

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('jadwalBM.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="tahun_ajaran_id" value="{{$tahun_ajaran->id}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="user_id">Guru Pengajar <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-control form-control-sm @error('user_id') is-invalid @enderror" id="user_id">
                                <option value="">Pilih</option>
                                @foreach($guru_s as $guru)
                                <option {{ old('user_id') == $guru->id ? 'selected' : '' }} value="{{ $guru->id }}">{{$guru->nama}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sub_kelas">Kelas / Ruang <span class="text-danger">*</span></label>
                            <select name="sub_kelas" class="text-uppercase form-control form-control-sm @error('sub_kelas') is-invalid @enderror" id="sub_kelas">
                                <option value="">Pilih</option>
                                @foreach($sub_kelas_s as $sub_kelas)
                                <option class="text-uppercase" {{ old('sub_kelas') == $sub_kelas->id ? 'selected' : '' }} value="{{ $sub_kelas->id }}">{{$sub_kelas->sub_kelas}} | {{$sub_kelas->kelas->nama_kelas}}</option>
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
                                <option {{ old('mapel_id') == $mapel->id ? 'selected' : '' }} value="{{ $mapel->id }}">{{$mapel->nama_mapel}}</option>
                                @endforeach
                            </select>
                            @error('mapel_id')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hari">Hari <span class="text-danger">*</span></label>
                            <select name="hari" class="form-control form-control-sm @error('hari') is-invalid @enderror" id="hari">
                                <option value="">Pilih</option>
                                <option {{ old('hari') == 'senin' ? 'selected' : '' }} value="senin">Senin</option>
                                <option {{ old('hari') == 'selasa' ? 'selected' : '' }} value="selasa">Selasa</option>
                                <option {{ old('hari') == 'rabu' ? 'selected' : '' }} value="rabu">Rabu</option>
                                <option {{ old('hari') == 'kamis' ? 'selected' : '' }} value="kamis">Kamis</option>
                                <option {{ old('hari') == 'jumat' ? 'selected' : '' }} value="jumat">Jum`at</option>
                                <option {{ old('hari') == 'sabtu' ? 'selected' : '' }} value="sabtu">Sabtu</option>
                            </select>
                            @error('hari')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jam Mengajar <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" id="fp-time" name="jam_mulai" class="@error('jam_mulai') is-invalid @enderror form-control form-control-sm flatpickr-time text-left flatpickr-input active" placeholder="HH:MM" readonly="readonly" value="{{old('jam_mulai')}}">
                                    @error('jam_mulai')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" id="fp-time" name="jam_selesai" class="@error('jam_selesai') is-invalid @enderror form-control form-control-sm flatpickr-time text-left flatpickr-input active" placeholder="HH:MM" readonly="readonly" value="{{old('jam_selesai')}}">
                                    @error('jam_selesai')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('jadwalBM') }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
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