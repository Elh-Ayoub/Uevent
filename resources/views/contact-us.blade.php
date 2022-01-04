<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact us - {{env('APP_NAME')}}</title>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        <div class="content-wrapper">
            <section class="content-header">
              <div class="container">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Contact us</h1>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item active">Contact us</li>
                    </ol>
                  </div>
                </div>
              </div>
            </section>
            <!-- Main content -->
            <section class="content">      
                <div class="container">
                    <div class="card">
                        <form action="{{route('contact.send')}}" method="POST" class="needs-validation row card-body">
                            @csrf
                            <div class="col-5 text-center d-flex align-items-center justify-content-center">
                                <div class="">
                                    <h2>Uevent, <strong>Inc.</strong></h2>
                                    <p class="lead mb-5">st. pushkins'ka, 2, 61000, Kharkov, Ukraine<br>
                                        Phone: +38(095)-507-24-44 <br>
                                        Email: hello@ucode.world
                                    </p>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="inputName">Full name</label>
                                    <input type="text" id="inputName" name="name" class="required form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">E-Mail</label>
                                    <input type="email" id="inputEmail" name="email" class="required form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputSubject">Subject</label>
                                    <input type="text" id="inputSubject" name="subject" class="required form-control">
                                </div>
                                <div class="form-group">
                                    <label for="inputMessage">Message</label>
                                    <textarea id="inputMessage" class="required form-control" name="message" rows="4"></textarea>
                                </div>
                                    <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Send message">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <!-- /.content -->
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
<script src="{{ asset('js/sort.js') }}"></script>
<script src="{{ asset('js/categories.js') }}"></script>
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