@extends('layout.master')

@section('halaman', 'Tambah Guru')

@section('title','Tambah Guru')

@section('master-user','sidebar-group-active open')

@section('siswa','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form id="jquery-val-form" action="{{ route('siswa.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        @for($i = 0; $i < $jumlah_data; $i++) <div class="row">
                            <div class="form-group col-md-4">
                                <label for="nama{{$i}}">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama[]" class="form-control form-control-sm @error('nama.' . $i) is-invalid @enderror" id="nama{{$i}}" placeholder="Masukan Nama" value="{{old('nama.' . $i)}}">
                                @error('nama.' . $i)
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nis{{$i}}">NIS <span class="text-danger">*</span></label>
                                <input type="number" name="nis[]" class="form-control form-control-sm @error('nis.' . $i) is-invalid @enderror" id="nis{{$i}}" placeholder="Masukan NIS" value="{{old('nis.' . $i)}}">
                                @error('nis.' . $i)
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sub_kelas{{$i}}">Kelas & Ruang <span class="text-danger">*</span></label>
                                <select name="sub_kelas[]" class="text-uppercase form-control form-control-sm @error('sub_kelas.' . $i) is-invalid @enderror" id="sub_kelas{{$i}}">
                                    <option value="">Pilih</option>
                                    @foreach($sub_kelas_s as $sub_kelas)
                                    <option class="text-uppercase" {{ old('sub_kelas.' . $i) == $sub_kelas->id ? 'selected' : '' }} value="{{$sub_kelas->id}}">{{$sub_kelas->sub_kelas}} | {{$sub_kelas->kelas->nama_kelas}}</option>
                                    @endforeach
                                </select>
                                @error('sub_kelas.' . $i)
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                    </div>
                    @endfor
            </div>
            <div class="card-footer">
                <a href="{{ route('siswa') }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
                <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
</section>
@endsection