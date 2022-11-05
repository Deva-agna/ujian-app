@extends('layout.master')

@section('halaman', 'Peserta Ujian')

@section('title','Peserta Ujian')

@section('master-user','sidebar-group-active open')

@section('ujian','active')

@section('konten')
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Peserta Ujian</h4>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Mulai</th>
                            <th>Status</th>
                            <th>Keterlambatan</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ujian->nilai->load('siswa') as $data)
                        <tr>
                            <td>{{ $data->siswa->nama }}</td>
                            <td>{{ $data->siswa->nis }}</td>
                            <td>{{ Carbon\Carbon::parse($data->start)->format('d, M Y H:i') }}</td>
                            <td><span class="badge  {{$data->status ? 'badge-info' : 'badge-warning'}}">{{$data->status ? 'Selesai' : 'Belum Selesai'}}</span></td>
                            <td>{{ $data->keterlambatan }}</td>
                            <td>{{ $data->nilai == '-' ? '-' : number_format($data->nilai, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection