<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create event - {{env('APP_NAME')}}</title>
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
                    <h1 class="m-0">Create an event</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Create event</a></li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container">
                <form action="{{route('events.store')}}" class="card card-info h-100 position-relative" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Create event</h3><span class="small ml-2">(All fields are required)</span>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group input-container">
                            <input type="text" id="title" placeholder="Event title" name="title" class="form-control container__input" required>
                            <label class="container__label" for="title">Event title</label>
                        </div>
                        <div class="form-group input-container">
                            <textarea id="description" name="description" placeholder="Description" class="form-control container__input" maxlength="500" required></textarea>
                            <label class="container__label" for="description">Description</label>
                        </div>
                        <div class="form-group input-container">
                            <input type="text" id="location" placeholder="Event Location" name="location" class="form-control container__input" required>
                            <label class="container__label" for="location">Event Location</label>
                        </div>
                        <div class="form-group row align-items-center col-12 p-2 m-auto" style="border: 1px solid rgba(173, 172, 172, 0.5); border-radius: 3px;">
                            <label for="begins_at" class="col-sm-3 text-muted">Event begins at: </label>
                            <input type="datetime-local" name="begins_at" id="begins_at" class="form-control col-sm-4">
                        </div>
                        <div class="form-group col-12 p-0 mt-3">
                            <select name="category" id="" class="form-control container__input col-12">
                                <option selected disabled>Select event category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 row justify-content-lg-around align-items-center mx-auto py-3 mt-3" style="border: 1px solid rgba(173, 172, 172, 0.5); border-radius: 3px;">
                            <div class="col-md-5 flex-column">
                                <div class="d-flex justify-content-center align-items-center upload-container mb-2">
                                    <input type="file" id="poster" name="poster" class="d-none">
                                    <label for="poster" class="col-sm-8 d-flex justify-content-center align-items-center" style="cursor: pointer;"><i class="fas fa-upload mr-2"></i><span id="upload-container-label">Event Poster</span></label>
                                </div>
                                <div class="input-container mt-4 col-12 d-flex align-items-center">
                                    <label class="col-4 sample_label">Tickets: </label>
                                    <div class="d-flex justify-content-center align-items-center col-6">
                                        <div>
                                            <input type="radio" name="tickets_limited" id="limited" value="yes" class="publish_radio d-none">
                                            <label class="publish_radio_label" for="limited">Limited</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="tickets_limited" id="unlimited" value="no" class="publish_radio d-none" checked>
                                            <label class="publish_radio_label" for="unlimited">Unlimited</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group input-container mt-4" id="ticket_num_container" style="display: none">
                                    <input type="number" min="1" placeholder="Tickets number" id="tickets_number" name="tickets_number" class="form-control container__input">
                                    <label class="col-6 container__label" for="tickets_number">Tickets number</label>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="inputreceive_notif" class="col-12 sample_label">Receive notifications about new visitors ?</label>
                                    <div>
                                        <input type="radio" name="receive_notif" class="radio-input" id="option_yes" value="yes">
                                        <label for="option_yes">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="receive_notif" class="radio-input" id="option_no" value="no">
                                        <label for="option_no">No</label>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="d-flex align-items-center">
                                        <label for="" class="col-4 sample_label">Promo code: </label>
                                        <a class="btn btn-info btn-sm" id="add_promo_code">Add</a>
                                    </div>
                                    <div class="col-10 mt-2" id="promo_code_container"></div>
                                </div>
                            </div>
                            <div class="col-md-5 flex-column">
                                <div class="form-group d-flex align-items-center">
                                    <label for="publish_at" class="col-sm-4 sample_label">Publish at: </label>
                                    <div class="d-flex justify-content-center align-items-center col-6">
                                        <div>
                                            <input type="radio" name="publish_at_selector" id="publish_now" value="now" class="publish_radio d-none" checked>
                                            <label class="publish_radio_label" for="publish_now">Now</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="publish_at_selector" id="publish_Scheduled" value="Scheduled" class="publish_radio d-none">
                                            <label class="publish_radio_label" for="publish_Scheduled">Scheduled</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group input-container mt-4" id="publish_at_container" style="display: none">
                                    <label for="publish_at" class="col-sm-8 sample_label">Select date and time to publish: </label>
                                    <input type="datetime-local" name="publish_at" id="publish_at" class="form-control">
                                </div>
                                <div class="form-group input-container mt-4">
                                    <input type="number" min="0" placeholder="Ticket price (USD)" id="ticket_price" name="ticket_price" class="form-control container__input" required>
                                    <label class="col-6 container__label">Ticket price (USD)</label>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="inputcan_see_visitors" class="col-12 sample_label">Who can see visitors list ? </label>
                                    <div>
                                        <input type="radio" name="can_see_visitors" id="option_Everyone" class="radio-input" value="Everyone">
                                        <label for="option_Everyone">Everyone</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="can_see_visitors" id="option_visitors" class="radio-input" value="Event visitors">
                                        <label for="option_visitors">Event visitors</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="can_see_visitors" id="option_nobody" class="radio-input" value="No body">
                                        <label for="option_nobody">No body</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-around bg-gray-light pt-2 pb-2 pr-0 pl-0 m-0 w-100">
                            <a type="button" href="/home"  class="btn btn-default mt-1 mb-1">Cancel</a>
                            <button type="submit" class="btn btn-primary mt-1 mb-1">Create</button>
                        </div>
                    </div>
                </form>
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
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/create-event.js') }}"></script>
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
