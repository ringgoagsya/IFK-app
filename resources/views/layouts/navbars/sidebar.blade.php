<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/series-blue.png" class="navbar-brand-img" alt="...">

        </a>
        <div class="d-flex align-items-center">{{__('Kab. Lima Puluh Kota')}}</div>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="#navbar-data" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-data">
                        <i class="fas fa-database text-blue" ></i>
                        <span class="nav-link-text " >{{ __('Data Master') }}</span>
                    </a>

                    <div class="collapse hidden" id="navbar-data">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('puskesmas-user.index')}}">
                                    <i class="fas fa-user text-blue"></i> {{ __('User') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('puskesmas-show.index')}}">
                                    <i class="fas fa-hospital text-blue"></i> {{ __('Puskesmas') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('pemasok.index')}}">
                                    <i class="ni ni-shop text-blue"></i> {{ __('Pemasok') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('obat.index')}}">
                                    <i class="fas fa-pills text-blue"></i> {{ __('Obat') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>







                <li class="nav-item">
                    <a class="nav-link active" href="#navbar-obat" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-obat">
                        <i class="fas fa-medkit text-blue" ></i>
                        <span class="nav-link-text " >{{ __('Manajemen Obat') }}</span>
                    </a>

                    <div class="collapse hidden" id="navbar-obat">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('stokobat.index')}}">
                                    <i class="fas fa-capsules text-blue"></i> {{ __('Stok Obat') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('obat-masuk.index')}}">
                                    <i class="fa fa-download text-blue"></i> {{ __('Obat Masuk') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{route('obat-keluar.index')}}">
                                    <i class="fa fa-upload text-blue"></i> {{ __('Obat Keluar') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="far fa-file-alt text-blue" ></i>
                        <span class="nav-link-text " >{{ __('Laporan') }}</span>
                    </a>

                    <div class="collapse hidden" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('stokobatinduk.index')}}">
                                    <i class="ni ni-single-copy-04 text-blue"></i> {{ __('Buku Stok Induk IFK') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('laporan.index')}}">
                                    <i class="ni ni-single-copy-04 text-blue"></i> {{ __('Laporan Perencanaan Obat') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('laporan-puskesmas.index')}} ">
                                    <i class="ni ni-single-copy-04 text-blue"></i> {{ __('LPLPO Puskesmas') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


            </ul>
        </div>
    </div>
</nav>

