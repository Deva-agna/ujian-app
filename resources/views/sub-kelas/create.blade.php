@extends('layout.master')

@section('halaman', 'Tambah Kelas')

@section('title','Tambah Kelas')

@section('sub-kelas','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('sub.kelas.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kelas">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas" class="form-control form-control-sm @error('kelas') is-invalid @enderror" id="kelas">
                                <option value="">Pilih</option>
                                @foreach($kelas_s as $kelas)
                                <option class="text-uppercase" {{ old('kelas') == $kelas->id ? 'selected' : '' }} value="{{$kelas->id}}">{{$kelas->nama_kelas}}</option>
                                @endforeach
                            </select>
                            @error('kelas')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sub_kelas">Nama Ruang <span class="text-danger">*</span></label>
                            <input type="text" name="sub_kelas" class="form-control form-control-sm @error('sub_kelas') is-invalid @enderror" id="sub_kelas" placeholder="Masukan nama ruang (Ruang I / A) dan seterusnya" value="{{old('sub_kelas')}}">
                            @error('sub_kelas')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('sub.kelas') }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection