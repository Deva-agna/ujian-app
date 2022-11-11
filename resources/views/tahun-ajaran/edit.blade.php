@extends('layout.master')

@section('halaman', 'Edit Tahun Ajaran')

@section('title','Edit Tahun Ajaran')

@section('tahun_ajaran','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('tahun.ajaran.update') }}" method="post">
                    @method('put')
                    @csrf
                    <input type="hidden" name="slug" value="{{$tahun_ajaran->slug}}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="disabledInput">Tahun Ajaran</label>
                            <p class="form-control-static" id="staticInput">{{ $tahun_ajaran->tahun_ajaran }}</p>
                        </div>
                        <div class="form-group">
                            <label for="kurikulum">Kurikulum <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kurikulum') is-invalid @enderror" id="kurikulum" placeholder="Masukan Kurikulum" name="kurikulum" value="{{old('kurikulum', $tahun_ajaran->kurikulum)}}">
                            @error('kurikulum')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('tahun.ajaran') }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-sm btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection