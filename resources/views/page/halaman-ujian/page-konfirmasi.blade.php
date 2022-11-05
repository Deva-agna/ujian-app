@extends('layout.master')

@section('halaman', 'Ujian')

@section('title','Ujian')

@section('ujian','active')

@section('loading-page')
<div id="loading" class="warp-loading d-none">
    <div class="loading-submit">
    </div>
</div>
@endsection

@section('konten')

<div class="card">
    <div class="card-header pb-0 d-flex justify-content-between">
        <div>
            Data Diri
        </div>
        <span id="durasi-ujian" class=""></span>
        <div>
            <a href="{{ route('daftar.ujian.siswa') }}" class="btn btn-sm btn-secondary waves-effect waves-float waves-light">Kembali</a>
        </div>
    </div>
    <hr>
    <div class="card-body pb-0 pt-0">
        <table>
            <tr>
                <td>
                    Nama
                </td>
                <td class="pl-2">
                    {{Auth::guard('siswa')->user()->nama}}
                </td>
            </tr>
            <tr>
                <td>
                    NIS
                </td>
                <td class="pl-2">
                    {{Auth::guard('siswa')->user()->nis}}
                </td>
            </tr>
            <tr>
                <td>
                    Kelas
                </td>
                <td class="text-uppercase pl-2">
                    {{Auth::guard('siswa')->user()->subKelas->kelas->nama_kelas}} - {{Auth::guard('siswa')->user()->subKelas->sub_kelas}}
                </td>
            </tr>
        </table>
    </div>
    <div class="card-header pb-0">
        Konfirmasi
    </div>
    <hr>
    <div class="card-body pt-0">
        <form action=" {{ route('check.token') }} " method="post">
            @csrf
            @method('put')
            <input type="hidden" name="slug" value="{{$ujian->slug}}">
            <div class="form-group">
                <label for="token">Token <span class="text-danger">*</span></label>
                <input type="text" name="token" class="form-control form-control-sm @error('token') is-invalid @enderror" id="token" placeholder="Masukan token" value="{{old('token')}}">
                @error('token')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                @if(session()->has('error'))
                <div style="display: block; margin-top: 0.25rem; font-size: 0.857rem; color: #ea5455;">
                    {{session('error')}}
                </div>
                @endif
            </div>
            <button class="btn btn-primary waves-effect waves-float waves-light" disabled id="btn-mulai" type="submit">0d 0h 0m 0s</button>
        </form>
    </div>
</div>

@endsection

@section('page-js')

<script>
    var waktuMulai = new Date("{{$ujian->waktu_mulai}}").getTime();
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = waktuMulai - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("btn-mulai").innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("btn-mulai").innerHTML = "Mulai";
            document.getElementById("btn-mulai").disabled = false;
            waktuUjian();
        }
    }, 1000);

    function waktuUjian() {
        var waktuSelesai = new Date("{{$ujian->waktu_selesai}}").getTime();
        var y = setInterval(function() {
            var now = new Date().getTime();
            var distance = waktuSelesai - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("durasi-ujian").innerHTML = days + "d " + hours + "h " +
                minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(y);
                document.getElementById("durasi-ujian").classList.add("d-none");
                document.getElementById("btn-mulai").innerHTML = "ujian telah berakhir";
                document.getElementById("btn-mulai").disabled = true;
                waktuUjian();
            }
        }, 1000);
    }

    $('#btn-mulai').on('click', function() {
        $('#loading').removeClass('d-none');
    })
</script>

@endsection