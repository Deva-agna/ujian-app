@extends('layout.master')

@section('halaman', 'Ujian')

@section('title','Ujian')

@section('ujian','active')

@section('page-css')
<style>
    .bg-selesai {
        background-color: rgba(40, 199, 111, 0.2) !important;
    }
</style>
@endsection

@section('konten')

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Ujian</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ujian</th>
                            <th>Tipe</th>
                            <th style="width: 1px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ujian as $data)
                        <tr class="{{ $data->nilai->count() != 0 ? ($data->nilai[0]->status ? 'bg-selesai' : '') : ''}}">
                            <td>
                                <span>{{$data->title}}</span>
                                <hr style="margin: 0;">
                                <span style="font-size: 12px;">{{$data->jadwalBM->mapel->nama_mapel}}</span>
                                <hr style="margin: 0;">
                                <span style="font-size: 11px;">{{Carbon\Carbon::parse($data->waktu_mulai)->format('d/m H:i')}} - {{Carbon\Carbon::parse($data->waktu_selesai)->format('d/m H:i')}}</span>
                            </td>
                            @if($data->type_ujian == 'pg')
                            <td>PG</td>
                            @elseif($data->type_ujian == 'mc')
                            <td>PG Kompleks</td>
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