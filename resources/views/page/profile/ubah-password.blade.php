@extends('page.profile.profile')

@section('change-active', 'active')

@section('body-profile')

<div class="card">
    <div class="card-body">
        <div class="tab-content">
            <!-- change password -->
            <!-- form -->
            <form action="{{route('profile.update.password')}}" method="post">
                @csrf
                <input type="text" name="id" value="{{ Auth::guard('web')->user()->id }}" hidden>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="password_lama">Old Password</label>
                            <div class="input-group form-password-toggle input-group-merge">
                                <input type="password" class="form-control form-control-sm @error('password_lama') is-invalid @enderror" id="password_lama" name="password_lama" placeholder="Old Password">
                                <div class="input-group-append">
                                    <div class="input-group-text cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off font-small-4">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="input-group form-password-toggle input-group-merge">
                                <input type="password" id="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="New Password">
                                <div class="input-group-append">
                                    <div class="input-group-text cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off font-small-4">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="password_confirmation">Retype New Password</label>
                            <div class="input-group form-password-toggle input-group-merge">
                                <input type="password" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="New Password">
                                <div class="input-group-append">
                                    <div class="input-group-text cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off font-small-4">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                            <line x1="1" y1="1" x2="23" y2="23"></line>
                                        </svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-primary mr-1 mt-1 waves-effect waves-float waves-light">Simpan</button>
                    </div>
                </div>
            </form>
            <!--/ form -->
            <!--/ change password -->
            <div class="mb-5">

            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
<script src="{{asset('app-assets/js/scripts/pages/page-account-settings.js')}}"></script>
@endsection