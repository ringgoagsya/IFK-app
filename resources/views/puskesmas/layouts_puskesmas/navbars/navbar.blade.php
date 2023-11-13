@auth()
    @include('puskesmas.layouts_puskesmas.navbars.navs.auth')
@endauth

@guest()
    @include('puskesmas.layouts_puskesmas.navbars.navs.guest')
@endguest
