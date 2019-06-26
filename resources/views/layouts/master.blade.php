<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <title> FlowerShoplk Dashboard </title>
    
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">   
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/css?family=Cuprum:400,700|Playball|Source+Sans+Pro:400,600,700" rel="stylesheet">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('theme/css/material-dashboard.css?v=2.1.0') }}" rel="stylesheet">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('theme/demo/demo.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/bx-slider/jquery.bxslider.min.css')}}" rel="stylesheet" />
    <!-- Page specific css -->
    @yield('css')
</head>

<body class="">
    <div id="app">
        <div class="wrapper">
            @if(Auth::check() && (Auth::user()->title == "Administrator" || Auth::user()->title == "Editor" || Auth::user()->title == "ProductEditor"))
                <!-- Sidebar -->
                @include('admin.sidebar')
                <!-- End Sidebar -->
            @endif
            <div class="main-panel">
                @if(Auth::check() && (Auth::user()->title == "Administrator" || Auth::user()->title == "Editor" || Auth::user()->title == "ProductEditor"))
                    <!-- Navbar -->
                    @include('admin.navbar')
                    <!-- End Navbar -->
                @endif
                <div class="content" style="margin-top: 20px;">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                 <!-- Navbar -->
                 @include('admin.footer')
                 <!-- End Navbar -->
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('theme/js/core/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('theme/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <!-- Chartist JS 
    <script src="{{ asset('theme/js/plugins/chartist.min.js') }}"></script>-->
    <!--  Notifications Plugin    -->
    <script src="{{ asset('theme/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('theme/js/material-dashboard.min.js?v=2.1.0" type="text/javascript') }}"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('theme/demo/demo.js') }}"></script>
    <script src="{{ asset('theme/bx-slider/jquery.bxslider.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <!-- Custom Script-->
    <script src="{{ asset('theme/js/custom.js') }}"></script>
    <!-- Page specific js -->
    @yield('js')
</body>
</html>
