<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
        <!-- Form -->
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            {{-- <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text">
                </div>
            </div> --}}
        </form>
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if ($count)
                    <span class="md-2 badge badge-danger">{{($count ?? '')}} <i class="ni ni-bell-55"></i></span>
                @else
                    <span>{{($count ?? '')}} <i class="ni ni-bell-55"></i></span>
                @endif

            </a>
            <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
              <!-- Dropdown header -->
              <div class="px-3 py-3">
                <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">{{$count}}</strong> notifications.</h6>
              </div>
              <!-- List group -->
              @foreach ($tanggal as $tanggal )
              <div class="list-group list-group-flush">
                <a href="#!" class="list-group-item list-group-item-action">
                  <div class="row align-items-center">
                    <div class="col-auto row-auto">
                      <!-- Avatar -->
                      <img alt="Image placeholder" src="../assets/img/theme/obat.png" class="avatar rounded-circle">
                    </div>
                    <div>
                      {{-- <div class="d-flex justify-content-between align-items-center"> --}}
                        <div>

                          <h4 class="mb-0 text-sm">{{"Nama Obat : "}}{{$tanggal->obat->nama_obat}}</h4>
                        </div>
                        <div >
                            <small> {{"Tanggal Masuk :"}} </small>
                          <small class="text-success">{{($tanggal->created_at->format('Y-m-d'))}}</small>
                        </div>
                        <div>
                            <small> {{"Tanggal Expired : "}} </small>
                            <small class="text-danger" >   {{ ($tanggal->expired)}}</small>
                        </div>
                        <div>
                            <b><small> {{"Stok: "}} {{ ($tanggal->sisa_stok)}}</small></b>
                        </div>
                      </div>
                    {{-- </div> --}}
                  </div>
                </a>
              @endforeach
          </li>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
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
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
