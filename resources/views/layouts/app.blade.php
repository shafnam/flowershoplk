<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <title> FlowerShoplk </title>

    <!-- Bootstrap style -->     
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" media="screen"/>
    <link href="{{ asset('css/base.css') }}" rel="stylesheet" media="screen"/>
    <!-- custom style -->	
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    <!-- Bootstrap style responsive -->	
    <link href="{{ asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->	
    <link href="{{ asset('js/google-code-prettify/prettify.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('PgwSlider-master/pgwslider.css') }}" rel="stylesheet" media="screen"/>
    

    {{-- <link href="https://fonts.googleapis.com/css?family=Sunflower:300,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit:400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rancho" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Petit+Formal+Script|Playfair+Display:400,400i,700,700i" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css?family=Cuprum:400,700|Playball|Source+Sans+Pro:400,600,700" rel="stylesheet">    

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- Page specific assests -->
    @yield('css')   
    @yield('js')
    
    {{-- <link href="{{ asset('theme/css/material-dashboard.css?v=2.1.0') }}" rel="stylesheet">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('theme/demo/demo.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/bx-slider/jquery.bxslider.min.css')}}" rel="stylesheet" /> --}}
</head>

<body class="">
    <div id="app">
        @yield('content')
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/google-code-prettify/prettify.js') }}"></script>
    <script src="{{ asset('js/bootshop.js') }}"></script>
    <script src="{{ asset('js/jquery.lightbox-0.5.js') }}"></script>
    <script src="{{ asset('PgwSlider-master/pgwslider.min.js') }}"></script>
    <!-- Custom Script-->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
        
        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
        
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
