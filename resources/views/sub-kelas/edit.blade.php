@extends('layout.master')

@section('halaman', 'Edit Data Kelas')

@section('title','Edit Data Kelas')

@section('sub-kelas','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('sub.kelas.update') }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{ $sub_kelas->slug }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sub_kelas">Nama Ruang <span class="text-danger">*</span></label>
                            <input type="text" name="sub_kelas" class="form-control form-control-sm @error('sub_kelas') is-invalid @enderror" id="sub_kelas" placeholder="Masukan Nama Kelas" value="{{old('sub_kelas', $sub_kelas->sub_kelas)}}">
                            @error('sub_kelas')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('sub.kelas') }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection