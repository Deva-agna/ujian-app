@extends('layout.master')

@section('halaman', 'Dashboard')

@section('title','Dashboard')

@section('dashboard','active')

@section('konten')

<div class="col-12" style="padding: 0;">
    <div class="card card-statistics">
        <div class="card-header">
            <h4 class="card-title">Informasi</h4>
        </div>
        <div class="card-body statistics-body">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="avatar bg-light-primary mr-2">
                            <div class="avatar-content">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{$guru}}</h4>
                            <p class="card-text font-small-3 mb-0">Guru</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                    <div class="media">
                        <div class="avatar bg-light-info mr-2">
                            <div class="avatar-content">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{$siswa}}</h4>
                            <p class="card-text font-small-3 mb-0">Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                    <div class="media">
                        <div class="avatar bg-light-danger mr-2">
                            <div class="avatar-content">
                                <i class="fa-solid fa-house text-success"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{$kelas}}</h4>
                            <p class="card-text font-small-3 mb-0">Kelas</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="media">
                        <div class="avatar bg-light-success mr-2">
                            <div class="avatar-content">
                                <i class="fa-solid fa-book text-warning"></i>
                            </div>
                        </div>
                        <div class="media-body my-auto">
                            <h4 class="font-weight-bolder mb-0">{{$mapel}}</h4>
                            <p class="card-text font-small-3 mb-0">Mapel</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection