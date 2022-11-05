@extends('layout.master')

@section('halaman', 'Tambah Ujian')

@section('title','Tambah Ujain')

@section('ujian','active')

@section('konten')

<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('ujian.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul Ujian <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="@error('title') is-invalid @enderror form-control form-control-sm" id="title" placeholder="Masukan judul ujian" value="{{old('title')}}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jadwal_belajar">Jadwal Belajar <span class="text-danger">*</span></label>
                            <select name="jadwal_belajar" class="@error('jadwal_belajar') is-invalid @enderror form-control form-control-sm text-uppercase" id="jadwal_belajar">
                                <option value="">Pilih</option>
                                @foreach($jadwalBM_s as $jadwalBM)
                                <option class="text-uppercase" {{ old('jadwal_belajar') == $jadwalBM->id ? 'selected' : '' }} value="{{$jadwalBM->id}}">{{ $jadwalBM->subKelas->kelas->nama_kelas }} | {{$jadwalBM->subKelas->sub_kelas}} | {{ $jadwalBM->mapel->nama_mapel }} | {{$jadwalBM->hari}} | {{ $jadwalBM->jam_mulai }} - {{ $jadwalBM->jam_selesai }}</option>
                                @endforeach
                            </select>
                            @error('jadwal_belajar')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="waktu_mulai">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="@error('waktu_mulai') is-invalid @enderror form-control  form-control-sm" value="{{old('waktu_mulai')}}" onclick="valueClear()">
                            @error('waktu_mulai')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="waktu_selesai">Waktu Selesai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="@error('waktu_selesai') is-invalid @enderror form-control  form-control-sm" value="{{old('waktu_selesai')}}" onclick="date()">
                            @error('waktu_selesai')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="waktu_ujian">Waktu Ujian <span class="text-danger">*</span> (Menit)</label>
                            <input type="number" name="waktu_ujian" class="@error('waktu_ujian') is-invalid @enderror form-control form-control-sm" id="waktu_ujian" placeholder="Masukan waktu ujian" value="{{old('waktu_ujian')}}">
                            @error('waktu_ujian')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type_ujian">Tipe Ujian <span class="text-danger">*</span></label>
                            <select name="type_ujian" class="@error('type_ujian') is-invalid @enderror form-control form-control-sm text-uppercase" id="type_ujian">
                                <option value="">Pilih</option>
                                <option class="text-uppercase" {{ old('type_ujian') == 'pg' ? 'selected' : '' }} value="pg">PG (Satu Jawaban)</option>
                                <option class="text-uppercase" {{ old('type_ujian') == 'mc' ? 'selected' : '' }} value="mc">PG (Banyak Jawaban)</option>
                                <option class="text-uppercase" {{ old('type_ujian') == 'essay' ? 'selected' : '' }} value="essay">essay</option>
                            </select>
                            @error('type_ujian')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <a href="{{ route('ujian') }}" class="btn btn-secondary waves-effect waves-float waves-light">Kembali</a>
                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

<script>
    function valueClear() {
        document.getElementById('waktu_selesai').value = '';
    }

    function date() {
        var waktu_mulai = document.getElementById('waktu_mulai').value;
        document.getElementById('waktu_selesai').setAttribute("min", waktu_mulai);
    }
</script>

@endsection