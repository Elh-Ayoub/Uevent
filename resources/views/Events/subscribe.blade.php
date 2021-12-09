<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscribe to event - {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
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
                    <h1 class="m-0">Subscribe to event</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('event.details', $event->id)}}">{{$event->title}}</a></li>
                    <li class="breadcrumb-item"><a href="#">subscribe to event</a></li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container">
                <div class="card card-solid">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <h3 class="d-inline-block d-sm-none">{{$event->title}}</h3>
                                <div class="col-12">
                                    <img src="{{$event->poster}}" class="product-image" alt="Product Image">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <h3 class="my-3">{{$event->title}}</h3>
                                <p>{{$event->description}}</p>
                                <hr>
                                <div class="form-group col-4 mt-2 mb-0">
                                    <label for="quantity">Total price:</label>
                                </div>
                                <div class="bg-gray py-2 px-3">
                                    <h2 class="mb-0">
                                    <span id="price">{{$event->ticket_price}}</span> $ (USD)
                                    </h2>
                                </div>
                                <div class="form-group col-8 mt-3">
                                    <label for="promo_code">Add promo code:</label>
                                    <div class="d-flex align-items-center promo_code_container">
                                        <input type="text" id="promo_code" class="form-control col-8">
                                        <button class="btn btn-info" data-url="{{route('check.promo', $event->id)}}" id="check_promo_code">Apply</button> 
                                    </div>
                                </div>
                                <p id="promo_code_label" class="form-group col-8 sample_label"></p>
                                <div class="mt-4">
                                    <button id="pay" class="btn btn-primary btn-lg btn-flat">
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                    Continue to payment
                                    </button>
                                </div>
                                <div class="mt-4 product-share">
                                    <a href="#" class="text-gray">
                                    <i class="fab fa-facebook-square fa-2x"></i>
                                    </a>
                                    <a href="#" class="text-gray">
                                    <i class="fab fa-twitter-square fa-2x"></i>
                                    </a>
                                    <a href="#" class="text-gray">
                                    <i class="fas fa-envelope-square fa-2x"></i>
                                    </a>
                                    <a href="#" class="text-gray">
                                    <i class="fas fa-rss-square fa-2x"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payment" class="card card-primary" style="display: none;">
                    <div class="card-header">
                        <h2 class="card-title">Payment Details</h2><span class="small ml-2">(All fields are required)</span>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="panel-body col-8">
                            <div class='form-row row col-12'>
                                <div class='col-10 form-group required'>
                                   <label class="control-label @if(strpos(Session::get('error'), 'card_number') !== false) text-danger @endif">Card Number</label> <input
                                      autocomplete='off' class="form-control card_number @if(strpos(Session::get('error'), 'card_number') !== false) is-invalid @endif" size='20'
                                      type='text' name="card_number">
                                </div>
                            </div>
                            <div class='form-row row col-12'>
                                <div class='col-md-4 form-group cvc required'>
                                    <label class="control-label @if(strpos(Session::get('error'), 'cvc') !== false) text-danger @endif">CVC</label> 
                                    <input autocomplete='off'
                                        class="form-control card-cvc @if(strpos(Session::get('error'), 'cvc') !== false) is-invalid @endif" placeholder='ex. 311' size='3'
                                        type='password' name="cvc">
                                </div>
                                <div class='col-md-4 form-group expiration required'>
                                    <label class="control-label @if(strpos(Session::get('error'), 'month') !== false) text-danger @endif">Expiration Month</label> <input
                                        class="form-control card-expiry-month @if(strpos(Session::get('error'), 'month') !== false) is-invalid @endif" placeholder='MM' size='2'
                                        type='text' name="month">
                                </div>
                                <div class='col-md-4 form-group expiration required'>
                                    <label class="control-label @if(strpos(Session::get('error'), 'year') !== false) text-danger @endif">Expiration Year</label> <input
                                        class="form-control card-expiry-year @if(strpos(Session::get('error'), 'year') !== false) is-invalid @endif" placeholder='YYYY' size='4'
                                        type='text' name="year">
                                </div>
                            </div>
                            <div class='form-row row col-12'>
                                <div class='col-10 form-group required'>
                                    <label class="control-label @if(strpos(Session::get('error'), 'name_on_card') !== false) text-danger @endif">Name on Card</label> 
                                    <input class="form-control @if(strpos(Session::get('error'), 'name_on_card') !== false) is-invalid @endif" size='8' type='text' name="name_on_card">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay</button>
                                </div>
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
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/subscription.js') }}"></script>
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
