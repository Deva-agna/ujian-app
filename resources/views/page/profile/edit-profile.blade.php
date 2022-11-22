@extends('page.profile.profile')

@section('edit-active', 'active')

@section('body-profile')

<div class="card">
    <div class="card-body">
        <div class="tab-content">
            <!-- general tab -->
            <div role="tabpanel" class="tab-pane active show" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                <!-- header media -->
                <div class="media">
                    <a href="javascript:void(0);" class="mr-25">
                        @if(Auth::guard('web')->user()->img)
                        <img src="{{asset('foto/'. Auth::guard('web')->user()->img)}}" id="account-upload-img" class="rounded mr-50" alt="profile image" width="80" style="object-fit: cover;">
                        @else
                        <img src="{{asset('app-assets/images/no_image.jpg')}}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" style="object-fit: cover;">
                        @endif
                    </a>
                    <!-- upload and reset button -->
                    <div class="media-body mt-75 ml-1">
                        <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75 waves-effect waves-float waves-light">Upload</label>
                        <p>Maksimal foto yang diuanggah hanya 2MB!</p>
                    </div>
                    <!--/ upload and reset button -->
                </div>
                <!--/ header media -->

                <!-- form -->
                <form class="mt-2" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="file" name="image" id="account-upload" hidden="" accept="image/*" onchange="previewImag()">
                    <input type="hidden" name="slug" value="{{Auth::guard('web')->user()->slug}}">
                    <input type="hidden" name="imgOld" value="{{Auth::guard('web')->user()->img}}">
                    <input type="hidden" name="tanggal_lahir_old" value="{{Auth::guard('web')->user()->tanggal_lahir}}">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukan nama" value="{{old('nama', Auth::guard('web')->user()->nama)}}">
                                @error('nama')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="number" class="form-control form-control-sm @error('nip') is-invalid @enderror" id="nip" name="nip" placeholder="Masukan NIP" value="{{old('nip', Auth::guard('web')->user()->nip)}}">
                                @error('nip')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukan Email" value="{{old('email', Auth::guard('web')->user()->email)}}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="text" class="form-control-sm form-control @error('tanggal_lahir') is-invalid @enderror flatpickr-basic flatpickr-input" placeholder="Tanggal lahir" id="tanggal_lahir" name="tanggal_lahir" readonly="readonly" value="{{old('tanggal_lahir', Auth::guard('web')->user()->tanggal_lahir)}}">
                                @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="no_telpon">No Telpon</label>
                                <input type="number" class="form-control form-control-sm" id="no_telpon" name="no_telpon" placeholder="Masukan no telpon" value="{{old('no_telpon', Auth::guard('web')->user()->no_telpon)}}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control form-control-sm" id="jenis_kelamin">
                                    <option value="">Pilih</option>
                                    <option {{ old('jenis_kelamin', Auth::guard('web')->user()->jenis_kelamin) == 'male' ? 'selected' : '' }} value="male">Laki - Laki</option>
                                    <option {{ old('jenis_kelamin', Auth::guard('web')->user()->jenis_kelamin) == 'famale' ? 'selected' : '' }} value="famale">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-sm" id="alamat" rows="2" placeholder="Textarea">{{old('alamat', Auth::guard('web')->user()->alamat)}}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-sm btn-primary mt-2 mr-1 waves-effect waves-float waves-light">Simpan</button>
                        </div>
                    </div>
                </form>
                <!--/ form -->
            </div>
            <!--/ general tab -->
        </div>
    </div>
</div>

@endsection