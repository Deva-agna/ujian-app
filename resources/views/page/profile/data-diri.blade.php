@extends('page.profile.profile')

@section('profile-active', 'active')

@section('body-profile')

<div id="profile-info">
    <div class="card">
        <div class="card-body">
            <div class="mt-2">
                <h5 class="mb-75">NIP:</h5>
                <p class="card-text">{{ Auth::guard('web')->user()->nip }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Email:</h5>
                <p class="card-text">{{ Auth::guard('web')->user()->email }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-75">Tanggal Lahir:</h5>
                <p class="card-text">{{ Auth::guard('web')->user()->tanggal_lahir }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-50">No Telpon:</h5>
                <p class="card-text mb-0">{{ Auth::guard('web')->user()->no_telpon ? Auth::guard('web')->user()->no_telpon : '-' }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-50">Jenis Kelamin:</h5>
                <p class="card-text mb-0">{{ Auth::guard('web')->user()->jenis_kelamin ? Auth::guard('web')->user()->jenis_kelamin : '-' }}</p>
            </div>
            <div class="mt-2">
                <h5 class="mb-50">Alamat:</h5>
                <p class="card-text mb-0">{{ Auth::guard('web')->user()->alamat ? Auth::guard('web')->user()->alamat : '-' }}</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
<script src="{{ asset('app-assets/js/scripts/pages/page-profile.js') }}"></script>
@endsection