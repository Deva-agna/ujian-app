@extends('layout.master')

@section('halaman', 'Tambah Tahun Ajaran')

@section('title','Tambah Tahun Ajaran')

@section('tahun_ajaran','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('tahun.ajaran.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <?php
                        $years = range(date('Y'), date('Y', strtotime('+5 year')));
                        ?>
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select class="custom-select @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran">
                                @foreach($years as $key => $year)
                                @if($key>0)
                                <option value="<?= $years[$key - 1] ?> / {{$year}}"><?= $years[$key - 1] ?> / {{$year}}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('tahun_ajaran')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kurikulum">Kurikulum <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kurikulum') is-invalid @enderror" id="kurikulum" placeholder="Masukan Kurikulum" name="kurikulum" value="{{old('kurikulum')}}">
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