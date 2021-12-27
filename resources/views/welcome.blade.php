<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('APP_NAME')}}</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
        <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{asset('css/landing.css')}}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
    </head>
    <body class="antialiased">
        <div class="d-flex row justify-content-between w-100 align-items-center col-12">
            <div class="p-4 ml-3">
                <a href="{{route('dashboard')}}" class="row align-items-center">
                    <img src="{{ asset('images/logo2.png')}}" alt="Logo" class="brand-image img-circle img-md" >
                    <span class="text-white text-bold text-xl">{{env('APP_NAME')}}</span>
                </a>
            </div>
            @if (Route::has('login'))
                <div class="p-4">
                    @auth
                        <a href="{{ url('/home') }}" class="text-white text-bold mr-2 sign-in">Home</a>
                        <a href="{{ route('auth.logout') }}" class="text-white text-bold ml-2 sign-in">logout</a>
                    @else
                        <a href="{{ route('login') }}" class="text-white text-bold mr-2 sign-in">Sign in</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-info btn-lg ml-2 get-Started floating-btn">Get Started</a>
                    @endauth
                </div>
            @endif
        </div>
        <div class="mt-4">
            <div class="container__diagonal">
                <div class="text-in-diagonal text-xl text-bold">
                    <div class="title-1">Search or create events to unite</div> 
                    <div class="title-1"> 
                        <span class="title-2">like-minded people.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex w-100 col-12 justify-content-center align-items-center landing-footer">
            <a class="link-muted" href="#"><i class="fab fa-facebook"></i></a>
            <a class="link-muted mx-2" href="#"><i class="fab fa-github"></i></a>
            <a class="link-muted" href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- jQuery UI -->
        <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    </body>
</html>
