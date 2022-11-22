@extends('layout.master')

@section('halaman', 'Profile')

@section('title','Profile')

@section('master-user','sidebar-group-active open')

@section('profile-siswa','active')

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

<section id="kartu-pelajar">
    <div class="card col-sm-8 col-md-7 col-lg-6 m-auto">
        <div class="card-body p-1">
            <div class="d-flex align-items-center">
                <img src="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}" alt="logo" width="60">
                <div style="margin-left: 5px; height: min-content;">
                    <h1 class="nama-sekolah p-0 m-0">MIM 23 Surabaya</h1>
                    <span class="deskripsi">Madrasah Ibtidaiah Muhammadiyah 23 Surabaya</span>
                </div>
            </div>
            <hr style="margin: 5px 0 5px 0;">
            <div class="d-flex align-items-center justify-content-end">
                <div class="text-right mr-2 biodata">
                    <p class="m-0">{{ auth()->user()->nis }}</p>
                    <p class="m-0">{{ auth()->user()->nama }}</p>
                    <p class="m-0 text-uppercase">{{ auth()->user()->subKelas->kelas->nama_kelas }} - {{ auth()->user()->subKelas->sub_kelas }}</p>
                </div>
                <img src="{{asset('app-assets/images/no_image.jpg')}}" alt="tidak ada foto" class="foto-siswa">
            </div>
            <hr style="margin: 5px 0 5px 0;">
            <p class="m-0 text-center">JL. Buntaran 156 Tandes</p>
        </div>
    </div>
</section>

<section class="mt-2">
    <div class="card col-sm-8 col-md-7 col-lg-6 m-auto">
        <div class="card-body">
            <form action="{{ route('profile.siswa.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="password-lama">Password Lama</label>
                    <div class="input-group form-password-toggle input-group-merge">
                        <input type="password" class="form-control @error('password_lama') is-invalid @enderror" id="password-lama" name="password_lama" placeholder="Masukan password lama">
                        <div class="input-group-append">
                            <div class="input-group-text cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        @error('password_lama')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="password-baru">Password Baru</label>
                    <div class="input-group form-password-toggle input-group-merge">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password-baru" name="password" placeholder="Masukan password baru">
                        <div class="input-group-append">
                            <div class="input-group-text cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="ulangi-password-baru">Ulangi Password Baru</label>
                    <div class="input-group form-password-toggle input-group-merge">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="ulangi-password-baru" name="password_confirmation" placeholder="Ulangi Password Baru">
                        <div class="input-group-append">
                            <div class="input-group-text cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mr-1 mt-1 waves-effect waves-float waves-light">Ubah Password</button>
            </form>
        </div>
    </div>
</section>


@endsection

@section('script')
<script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>
@if(session()->has('sukses'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: '{{session("sukses")}}'
    })
</script>
@endif

@endsection