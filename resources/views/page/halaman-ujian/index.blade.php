@extends('layout.master')

@section('halaman', 'Ujian')

@section('title','Ujian')

@section('ujian','active')

@section('konten')

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Ujian</h4>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ulangan</th>
                            <th>Mapel</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ujian as $data)
                        <tr>
                            <td>{{$data->title}}</td>
                            <td>{{$data->jadwalBM->mapel->nama_mapel}}</td>
                            <td>{{Carbon\Carbon::parse($data->waktu_mulai)->format('d, M Y H:i')}}</td>
                            <td>{{Carbon\Carbon::parse($data->waktu_selesai)->format('d, M Y H:i')}}</td>
                            @if($data->type_ujian == 'pg')
                            <td>PG (Satu Jawaban)</td>
                            @elseif($data->type_ujian == 'mc')
                            <td>PG (Banyak Jawaban)</td>
                            @else
                            <td>Essay</td>
                            @endif
                            <td>
                                <?php date_default_timezone_set("Asia/Jakarta"); ?>
                                @if(strtotime($data->waktu_selesai) > time())
                                <a href="{{ route('page.konfirmasi.token', $data->slug) }}" class="btn btn-sm btn-info">Masuk</a>
                                @else
                                <span class="badge badge-success">Ujian Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="6">Ujian tidak ditemukan!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')

<script>

</script>

@endsection