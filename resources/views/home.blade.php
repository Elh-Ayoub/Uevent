<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home - {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/home.css')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Home</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container">
                <div class="text-center mb-5">
                    {{-- <h5 class="text-primary h6">Our Blog</h5> --}}
                    <h2 class="display-20 display-md-18 display-lg-16">Most recent our blog</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-3">
                        <article class="card card-style2">
                            <div class="card-img">
                                <img class="w-100" src="https://via.placeholder.com/350x280/6A5ACD/000000" alt="...">
                                <div class="date"><span>15</span>Sep</div>
                            </div>
                            <div class="card-body">
                                <h3 class="h5"><a href="#!">Loft therapy taking care of your home</a></h3>
                                <p class="display-30">Loft therapy will be a thing of the past and here's why.</p>
                                <a href="#!" class="read-more">read more</a>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#!"><i class="fas fa-user"></i>Brittany Hucks</a></li>
                                    <li><a href="#!"><i class="far fa-comment-dots"></i><span>26</span></a></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <article class="card card-style2">
                            <div class="card-img">
                                <img class="w-100" src="https://via.placeholder.com/350x280/FFB6C1/000000" alt="...">
                                <div class="date"><span>18</span>Aug</div>
                            </div>
                            <div class="card-body">
                                <h3 class="h5"><a href="#!">All you need to know about cleaning</a></h3>
                                <p class="display-30">Five common mistakes everyone makes in about cleaning.</p>
                                <a href="#!" class="read-more">read more</a>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#!"><i class="fas fa-user"></i>Mark Abell</a></li>
                                    <li><a href="#!"><i class="far fa-comment-dots"></i><span>28</span></a></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <article class="card card-style2">
                            <div class="card-img">
                                <img class="w-100" src="https://via.placeholder.com/350x280/008080/000000" alt="...">
                                <div class="date"><span>24</span>May</div>
                            </div>
                            <div class="card-body">
                                <h3 class="h5"><a href="#!">This cleaning tips will haunt you forever</a></h3>
                                <p class="display-30">Seven difficult things you should know about haunt.</p>
                                <a href="#!" class="read-more">read more</a>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#!"><i class="fas fa-user"></i>Curtis Chester</a></li>
                                    <li><a href="#!"><i class="far fa-comment-dots"></i><span>18</span></a></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <article class="card card-style2">
                            <div class="card-img">
                                <img class="w-100" src="https://via.placeholder.com/350x280/EE82EE/000000" alt="...">
                                <div class="date"><span>09</span>May</div>
                            </div>
                            <div class="card-body">
                                <h3 class="h5"><a href="#!">Five things to know about cleaning service office</a></h3>
                                <p class="display-30">Seven difficult things you should know about haunt.</p>
                                <a href="#!" class="read-more">read more</a>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#!"><i class="fas fa-user"></i>Kathleen</a></li>
                                    <li><a href="#!"><i class="far fa-comment-dots"></i><span>24</span></a></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <article class="card card-style2">
                            <div class="card-img">
                                <img class="w-100" src="https://via.placeholder.com/350x280/4682B4/000000" alt="...">
                                <div class="date"><span>14</span>Apr</div>
                            </div>
                            <div class="card-body">
                                <h3 class="h5"><a href="#!">Seven difficult things about cleaning service like</a></h3>
                                <p class="display-30">Seven difficult things you should know about haunt.</p>
                                <a href="#!" class="read-more">read more</a>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#!"><i class="fas fa-user"></i>Admin</a></li>
                                    <li><a href="#!"><i class="far fa-comment-dots"></i><span>09</span></a></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-3">
                        <article class="card card-style2">
                            <div class="card-img">
                                <img class="w-100" src="https://via.placeholder.com/350x280/87CEEB/000000" alt="...">
                                <div class="date"><span>26</span>Mar</div>
                            </div>
                            <div class="card-body">
                                <h3 class="h5"><a href="#!">The hidden agenda of window cleaning concept</a></h3>
                                <p class="display-30">Seven difficult things you should know about haunt.</p>
                                <a href="#!" class="read-more">read more</a>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li><a href="#!"><i class="fas fa-user"></i>Vickie</a></li>
                                    <li><a href="#!"><i class="far fa-comment-dots"></i><span>11</span></a></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>
        @include('layouts.footer')
    </div>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- jQuery UI -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@if(Session::get('fail'))
<script>
  $(function() {
    toastr.error("{{Session::get('fail')}}")
  });
</script>
@endif
@if(Session::get('success'))
<script>
  $(function() {
    toastr.success("{{Session::get('success')}}")
  });
</script>
@endif
@if(Session::get('fail-arr'))
    @foreach(Session::get('fail-arr') as $key => $err)
    <script>
      $(function() {
        toastr.error("{{$err[0]}}");
      });
    </script>
    @endforeach
@endif
@if(Session::get('success-arr'))
    @foreach(Session::get('success-arr') as $key => $success)
    <script>
      $(function() {
        toastr.success("{{$success}}");
      });
    </script>
    @endforeach
@endif
</body>
</html>
