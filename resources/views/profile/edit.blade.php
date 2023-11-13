{{-- @extends('layouts.app', ['title' => __('User Profile')]) --}}
<?php $id = auth()->user()->id; ?>


@extends( $id == 1 ? 'layouts.app' : 'puskesmas.layouts_puskesmas.app')


@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('Ini adalah halaman profil. Disini terdapat informasi mengenai instansi dan kartu untuk mengubah akun.'),
        'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-sm btn-info mr-4">{{ __('Connect') }}</a>
                            <a href="#" class="btn btn-sm btn-default float-right">{{ __('Message') }}</a>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">

                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3>
                                {{ auth()->user()->puskesmas->nama_puskesmas }}<span class="font-weight-light"></span>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{auth()->user()->puskesmas->alamat}}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{__('Telp')}}
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>{{ auth()->user()->puskesmas->no_telp }}
                            </div>
                            <hr class="my-4" />
                            @if ($id==1)
                            <p>{{ __('Instalasi Farmasi Kabupaten adalah unit pelaksana fungsional yang menyelenggarakan seluruh kegiatan pelayanan kefarmasian berupa penerimaan, penyimpanan, pendistribusian, dan juga pemeliharaan persediaan farmasi berupa obat, alat kesehatan, dan perbekalan kesehatan lainnya di Kabupaten') }}</p>
                            <a href="https://dinkes.limapuluhkotakab.go.id/Welcome/tampilStatis/UGZld1h6aU1Ka1I1dEdMdkJFTTEwQT09">{{ __('Show more') }}</a>

                            @else
                            <p>{{__('Pusat Kesehatan Masyarakat (Puskesmas) adalah fasilitas pelayanan kesehatan yang menyelenggarakan upaya kesehatan masyarakat dan upaya kesehatan perseorangan tingkat pertama, dengan lebih mengutamakan upaya promotif dan preventif di wilayah kerjanya.')}}</p>

                            <a href="https://puskesmaskepung.kedirikab.go.id/Buku/PERMENKES-NO-43-TAHUN-2019-TENTANG-PUSKESMAS_ID32.html">{{ __('Show more') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>

                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-4" />
                        <form method="post" action="{{ route('update.puskesmas',[auth()->user()->puskesmas->id]) }}" autocomplete="off">
                            @csrf
                            @method('post')

                            <h6 class="heading-small text-muted mb-4">{{ __('Puskesmas') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('kepala_puskesmas') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-kepala_puskesmas">{{ __('Kepala Puskesmas') }}</label>
                                    <input type="kepala_puskesmas" name="kepala_puskesmas" id="input-kepala_puskesmas" class="form-control form-control-alternative{{ $errors->has('kepala_puskesmas') ? ' is-invalid' : '' }}" placeholder="{{ __('Kepala Puskesmas') }}" value="{{ old('kepala_puskesmas', auth()->user()->puskesmas->kepala_puskesmas) }}" required>

                                    @if ($errors->has('kepala_puskesmas'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('kepala_puskesmas') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('nip_kapus') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nip_kapus">{{ __('NIP Kepala Puskesmas') }}</label>
                                    <input type="nip_kapus" name="nip_kapus" id="input-nip_kapus" class="form-control form-control-alternative{{ $errors->has('nip_kapus') ? ' is-invalid' : '' }}" placeholder="{{ __('NIP Kepala Puskesmas') }}" value="{{ old('nip_kapus', auth()->user()->puskesmas->nip_kapus) }}" required>

                                    @if ($errors->has('nip_kapus'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nip_kapus') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('pengelola') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-pengelola">{{ __('Pengelola') }}</label>
                                    <input type="pengelola" name="pengelola" id="input-pengelola" class="form-control form-control-alternative{{ $errors->has('pengelola') ? ' is-invalid' : '' }}" placeholder="{{ __('pengelola') }}" value="{{ old('Pengelola', auth()->user()->puskesmas->pengelola) }}" required>

                                    @if ($errors->has('pengelola'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('pengelola') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('nip_pengelola') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nip_pengelola">{{ __('NIP Pengelola') }}</label>
                                    <input type="nip_pengelola" name="nip_pengelola" id="input-nip_pengelola" class="form-control form-control-alternative{{ $errors->has('nip_pengelola') ? ' is-invalid' : '' }}" placeholder="{{ __('NIP Pengelola') }}" value="{{ old('nip_Pengelola', auth()->user()->puskesmas->nip_pengelola) }}" required>

                                    @if ($errors->has('nip_pengelola'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nip_pengelola') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>

                        <hr class="my-4" />
                        <form method="post" action="{{ route('profile.password') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                            @if (session('password_status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('password_status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>

                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm New Password') }}" value="" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
