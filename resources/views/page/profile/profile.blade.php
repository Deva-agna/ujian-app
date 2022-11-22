@extends('layout.master')

@section('halaman', 'Profile')

@section('title','Profile')

@section('profile','active')

@section('vendor-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection

@section('page-css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/page-profile.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/sweetalert2.min.css') }}">
@endsection

@section('konten')

<div id="user-profile">
    <div class="row">
        <div class="col-12">
            <div class="card profile-header mb-2">
                <!-- profile cover photo -->
                <img class="card-img-top" src="{{ asset('app-assets/images/profile/user-uploads/timeline.jpg') }}" alt="User Profile Image" />
                <!--/ profile cover photo -->

                <div class="position-relative">
                    <!-- profile picture -->
                    <div class="profile-img-container d-flex align-items-center">
                        <div class="profile-img" style="overflow: hidden;">
                            @if(Auth::guard('web')->user()->img)
                            <img src="{{asset('foto/'. Auth::guard('web')->user()->img)}}" style="width: 100%;" class="rounded img-fluid" alt="Card image" />
                            @else
                            <img src="{{asset('app-assets/images/no_image.jpg')}}" class="rounded img-fluid" alt="Card image" />
                            @endif
                        </div>
                        <!-- profile title -->
                        <div class="profile-title ml-3">
                            <h2 class="text-white">{{ Auth::guard('web')->user()->nama }}</h2>
                        </div>
                    </div>
                </div>

                <!-- tabs pill -->
                <div class="profile-header-nav">
                    <!-- navbar -->
                    <nav class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                        <button class="btn btn-icon navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa-solid fa-ellipsis-vertical" class="font-medium-5"></i>
                        </button>

                        <!-- collapse  -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0">
                                <ul class="nav nav-pills mb-0">
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold @yield('profile-active')" href="{{ route('profile') }}">
                                            <span class="d-none d-md-block">Data Diri</span>
                                            <i class="fa-regular fa-id-badge d-block d-md-none"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold @yield('edit-active')" href="{{ route('profile.edit') }}">
                                            <span class="d-none d-md-block">Ubah data diri</span>
                                            <i class="fa-regular fa-pen-to-square d-block d-md-none"></i>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-bold @yield('change-active')" href="{{ route('profile.edit.password') }}">
                                            <span class="d-none d-md-block">Ubah Password</span>
                                            <i class="fa-solid fa-lock d-block d-md-none"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--/ collapse  -->
                    </nav>
                    <!--/ navbar -->
                </div>
            </div>
        </div>
    </div>
</div>

@yield('body-profile')

@endsection

@section('vendor-js')
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }} "></script>
<script src=" {{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }} "></script>

<script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
@endsection

@section('page-js')

<script src=" {{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }} "></script>

@endsection

@section('script')
<script src="{{ asset('app-assets/js/sweetalert2.min.js') }}"></script>

<script>
    const imgPreview = document.querySelector('#account-upload-img');
    const src = imgPreview.src;

    function previewImag() {
        const image = document.querySelector('#account-upload');
        if (image.files[0].size > 2 * 1048576) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Gambar yang diunggah maksimal 2 MB!',
            })
            image.value = "";
            imgPreview.src = src;
        } else {
            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>

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