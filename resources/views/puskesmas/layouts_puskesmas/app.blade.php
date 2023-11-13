<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title','Sistem Informasi Puskesmas')</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/logo-polos.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('argon') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/DataTables/DataTables-1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('argon') }}/DataTables/Buttons-2.2.3/css/buttons.bootstrap4.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('puskesmas.layouts_puskesmas.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('puskesmas.layouts_puskesmas.navbars.navbar')
            @yield('content')
            @include('puskesmas.layouts_puskesmas.footers.nav')
            @yield('modals')
        </div>

        @guest()
            {{-- @include('puskesmas.layouts_puskesmas.footers.guest') --}}
        @endguest
        {{-- <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script> --}}

        @stack('js')
        <!-- Argon JS -->
        {{-- <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script> --}}

         <!-- Script -->
        <!--  -->
        <!-- Argon Scripts -->
        <!-- Core -->
        <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
        <!-- Optional JS -->
        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
        {{-- DataTables JS --}}
        <script src="{{asset('assets/DataTables/DataTables-1.12.1/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/DataTables-1.12.1/js/dataTables.bootstrap4.min.js')}}"></script>

        <script src="{{asset('assets/DataTables/Buttons-2.2.3/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/Buttons-2.2.3/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/JSZip-2.5.0/jszip.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/pdfmake-0.1.36/pdfmake.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/pdfmake-0.1.36/vfs_fonts.js')}}"></script>
        <script src="{{asset('assets/DataTables/Buttons-2.2.3/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/Buttons-2.2.3/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('assets/DataTables/Buttons-2.2.3/js/buttons.colVis.min.js')}}"></script>
        @yield('script')
    </body>
</html>
