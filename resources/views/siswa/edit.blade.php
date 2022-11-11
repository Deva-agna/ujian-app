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
                <form action="{{ route('siswa.update') }}" method="post">
                    @csrf
                    @method('put')
                    <input type="hidden" name="slug" value="{{$siswa->slug}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror" id="nama" placeholder="Masukan Nama" value="{{old('nama', $siswa->nama)}}">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nis">NIS <span class="text-danger">*</span></label>
                            <input type="number" name="nis" class="form-control form-control-sm @error('nis') is-invalid @enderror" id="nis" placeholder="Masukan NIS" value="{{old('nis', $siswa->nis)}}">
                            @error('nis')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas <span class="text-danger">*</span></label>
                            <select name="sub_kelas" class="text-uppercase form-control form-control-sm @error('sub_kelas') is-invalid @enderror" id="sub_kelas">
                                <option value="">Pilih</option>
                                @foreach($sub_kelas_s as $sub_kelas)
                                <option class="text-uppercase" {{ old('sub_kelas', $siswa->sub_kelas_id) == $sub_kelas->id ? 'selected' : '' }} value="{{$sub_kelas->id}}">{{$sub_kelas->sub_kelas}} | {{ $sub_kelas->kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            @error('sub_kelas')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('siswa') }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection