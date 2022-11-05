@extends('layout.master')

@section('halaman', 'Tambah Mapel')

@section('title','Tambah Mapel')

@section('mapel','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('mapel.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_mapel">Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mapel" class="form-control form-control-sm @error('nama_mapel') is-invalid @enderror" id="nama_mapel" placeholder="Masukan Nama Kelas" value="{{old('nama_mapel')}}">
                            @error('nama_mapel')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('mapel') }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection