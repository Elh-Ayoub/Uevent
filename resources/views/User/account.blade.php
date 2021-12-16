<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account - {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <!-- uPlot -->
  <link rel="stylesheet" href="{{ asset('plugins/uplot/uPlot.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/account.css')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="content-wrapper">
        
        <section class="content">
            <div class="container">
                <div id="content" class="content p-0">
                    <div class="profile-header">
                        <div class="profile-header-cover"></div>
                        <div class="profile-header-content">
                            <div class="profile-header-img mb-4">
                                <img src="{{Auth::user()->profile_photo}}" class="img-circle mb-4" alt=""/>
                            </div>
                
                            <div class="profile-header-info">
                                <h4 class="m-t-sm">{{Auth::user()->username}}</h4>
                                <p class="m-b-sm">{{Auth::user()->full_name}}r</p>
                                <a href="#" class="btn btn-xs btn-primary mb-2">Edit Profile</a>
                            </div>
                        </div>
                
                        <ul class="profile-header-tab nav nav-tabs">
                            <li class="nav-item"><a href="#account-panel" class="nav-link text-md active show" data-toggle="tab">Panel</a></li>
                            <li class="nav-item"><a href="#account-events" class="nav-link text-md" data-toggle="tab">My events</a></li>
                            <li class="nav-item"><a href="#account-tickets" class="nav-link text-md" data-toggle="tab">My tickets</a></li>
                            <li class="nav-item"><a href="#account-notification" class="nav-link text-md" data-toggle="tab">Notifications</a></li>
                            <li class="nav-item"><a href="#account-profile" class="nav-link text-md" data-toggle="tab">Profile</a></li>
                        </ul>
                    </div>
                
                    <div class="profile-container">
                        <div class="row row-space-20">
                            <div class="col-md-12">
                                <div class="tab-content p-0">
                                    <div class="tab-pane fade active show" id="account-panel">
                                        {{-- include users event view --}}
                                        @include('User.panel')
                                    </div>
                                    <div class="tab-pane fade" id="account-events">
                                        {{-- include users event view --}}
                                        @include('User.myevents')
                                    </div>
                                    <div class="tab-pane fade" id="account-tickets">
                                        {{-- include users tickets view --}}
                                        {{-- @include('User.mytickets') --}}
                                    </div>
                                    <div class="tab-pane fade" id="account-profile">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </section>
        @include('layouts.footer')
    </div>
</div>
<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- jQuery UI -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- uPlot -->
<script src="{{ asset('plugins/uplot/uPlot.iife.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/panel.js') }}"></script>
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
