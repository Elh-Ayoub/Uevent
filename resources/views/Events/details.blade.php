<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{$event->title}} - {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/createEvent.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <div class="content-wrapper pb-3">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-lg text-bold">{{$event->title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$event->title}}</a></li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-lg-4 mb-2 p-0">
                        <article class="card-style2">
                            <div class="card-img">
                                <img class="w-100" src="{{$event->poster}}" alt="...">
                                <div class="date"><span>{{($event->publish_at) ? date('d', strtotime($event->publish_at)) : (date('d', strtotime($event->created_at)))}}</span>{{($event->publish_at) ? date('M', strtotime($event->publish_at)) : (date('M', strtotime($event->created_at)))}}</div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-12">
                                    <h6 class="mb-0 text-lg text-bold sample_label">Author</h6>
                                </div>
                                </div>
                                <hr>
                                <img src="{{App\Models\User::find($event->id)->profile_photo}}" class="img-fluid img-circle" alt="User-Image" style="border: 1px solid grey;">
                                <span class="ml-2 text-lg">{{App\Models\User::find($event->id)->username}}</span>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-0 text-lg text-bold sample_label">About</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0 text-info">Description:  </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if($event->description)
                                        {{$event->description}}
                                        @else
                                        No description!
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0 text-info">Number of Tickets:  </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if($event->tickets_limited === 'yes')
                                        {{$event->tickets_number}}
                                        <span class="text-info">Available: </span>
                                        {{$event->tickets_number}}
                                        @else
                                        Unlimited
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0 text-info">Ticket price: </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if($event->ticket_price === 0)
                                        Free
                                        @else
                                            {{$event->ticket_price}} $
                                        @endif
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-0 text-lg text-bold sample_label">Location</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0 text-info">Address:  </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{$event->location}}
                                    </div>
                                </div>
                                <hr>
                                <iframe width="600" height="450" style="border:0" loading="lazy" allowfullscreen
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDidlLcVi1QvFXiSpp3FgATAtoKiiwkqZ0&q=kharkiv+Ukraine"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
</body>
</html>
