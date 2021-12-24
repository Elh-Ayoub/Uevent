<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit event - {{env('APP_NAME')}}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/createEvent.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png')}}"/>
</head>
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">
    @include('layouts.navbar')
    @include('layouts.sidebar')
    @php
        $categories = App\Models\Category::all();
    @endphp
    <div class="content-wrapper pb-3">
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit {{$event->title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Edit event</a></li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
        <section class="content">
            <form action="{{route('events.update', $event->id)}}" method="POST" class="container" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row justify-content-around align-items-start">
                    <div class="col-md-5">
                        <article class="card-style2 mb-3">
                            <div class="card-img">
                                <img class="w-100" src="{{$event->poster}}" alt="...">
                                <div class="date"><span>{{ date('d', strtotime($event->begins_at))}}</span>{{date('M', strtotime($event->begins_at))}}</div>
                            </div>
                        </article>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Update event poster</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center upload-container mb-2">
                                    <input type="file" id="poster" name="poster" class="d-none">
                                    <label for="poster" class="col-sm-8 d-flex justify-content-center align-items-center" style="cursor: pointer;"><i class="fas fa-upload mr-2"></i><span id="upload-container-label">Event Poster</span></label>
                                </div>
                            </div>
                        </div>
                        @if($event->published === 'no')
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Publish schedule</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <label for="publish_at" class="col-sm-4 sample_label">Publish at: </label>
                                    <div class="form-group input-container mt-4" id="publish_at_container">
                                        <label for="publish_at" class="col-sm-8 sample_label">Select date and time to publish (GMT): </label>
                                        <input type="datetime-local" name="publish_at" id="publish_at" class="form-control" value="{{date('Y-m-d\TH:i:s', strtotime($event->publish_at))}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Publish schedule</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="d-flex align-items-center">
                                        <label for="" class="col-4 sample_label">Promo code: </label>
                                        <a class="btn btn-info btn-sm" id="add_promo_code">Add</a>
                                    </div>
                                    @foreach ($promo_codes as $code)
                                    <div class="row justify-content-center mt-2">
                                        <input type="text" name="code[]" class="form-control col-md-5" value="{{$code->code}}" readonly>
                                        <input type="number" id="percentage" min="1" max="100" placeholder="Percentage (%)" value="{{$code->percentage}}" name="percentage[]" class="form-control container__input col-md-5" required>
                                        <a class="btn btn-danger btn-sm" onclick="$(this).parent().remove();"><i class="fas fa-trash"></i></a>
                                    </div>
                                    @endforeach
                                    <div class="mt-2" id="promo_code_container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card card-info position-relative">
                            <div class="card-header">
                                <h3 class="card-title">General</h3>
                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group input-container">
                                    <input type="text" id="title" placeholder="Event title" name="title" class="form-control container__input" value="{{$event->title}}" required>
                                    <label class="container__label" for="title">Event title</label>
                                </div>
                                <div class="form-group input-container">
                                    <textarea id="description" name="description" placeholder="Description" class="form-control container__input" maxlength="500" required>{{$event->description}}</textarea>
                                    <label class="container__label" for="description">Description</label>
                                </div>
                                <div class="form-group input-container">
                                    <input type="text" id="location" placeholder="Event Location" name="location" class="form-control container__input" value="{{$event->location}}" required>
                                    <label class="container__label" for="location">Event Location</label>
                                </div>
                                <div class="form-group row align-items-center col-12 p-2 m-auto" style="border: 1px solid rgba(173, 172, 172, 0.5); border-radius: 3px;">
                                    <label for="begins_at" class="col-sm-4 text-muted">Event begins at: </label>
                                    <input type="datetime-local" name="begins_at" id="begins_at" class="form-control col-sm-8" value="{{date('Y-m-d\TH:i:s', strtotime($event->begins_at))}}">
                                </div>
                                <div class="form-group col-12 p-0 mt-3">
                                    <select name="category" id="" class="form-control container__input col-12">
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}" @if($event->category === $category->id) selected @endif>{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Tickets</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-container col-12 d-flex align-items-center">
                                    <label class="col-4 sample_label">Tickets: </label>
                                    <div class="d-flex justify-content-center align-items-center col-6">
                                        <div>
                                            <input type="radio" name="tickets_limited" id="limited" value="yes" class="publish_radio d-none" @if($event->tickets_limited === 'yes') checked @endif>
                                            <label class="publish_radio_label" for="limited">Limited</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="tickets_limited" id="unlimited" value="no" class="publish_radio d-none" @if($event->tickets_limited === 'no') checked @endif>
                                            <label class="publish_radio_label" for="unlimited">Unlimited</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group input-container mt-2" id="ticket_num_container"  @if(!$event->tickets_number) style="display: none"  @endif>
                                    <input type="number" min="1" placeholder="Tickets number" id="tickets_number" name="tickets_number" class="form-control container__input" @if($event->tickets_number) value="{{$event->tickets_number}}" @endif>
                                    <label class="col-6 container__label" for="tickets_number" style="width: fit-content">Tickets number</label>
                                </div>
                                <div class="form-group input-container mt-2">
                                    <input type="number" min="0" placeholder="Ticket price (USD)" id="ticket_price" name="ticket_price" value="{{$event->ticket_price}}" class="form-control container__input" required>
                                    <label class="col-6 container__label" style="width: fit-content">Ticket price (USD)</label>
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Notification & visitors</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group mt-3">
                                    <label for="inputreceive_notif" class="col-12 sample_label">Receive notifications about new visitors ?</label>
                                    <div>
                                        <input type="radio" name="receive_notif" class="radio-input" id="option_yes" value="yes" @if($event->receive_notif == 'yes') checked @endif>
                                        <label for="option_yes">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="receive_notif" class="radio-input" id="option_no" value="no" @if($event->receive_notif == 'no') checked @endif>
                                        <label for="option_no">No</label>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="inputcan_see_visitors" class="col-12 sample_label">Who can see visitors list ? </label>
                                    <div>
                                        <input type="radio" name="can_see_visitors" id="option_Everyone" class="radio-input" value="Everyone" @if($event->can_see_visitors == 'Everyone') checked @endif>
                                        <label for="option_Everyone">Everyone</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="can_see_visitors" id="option_visitors" class="radio-input" value="Event visitors" @if($event->can_see_visitors == 'Event visitors') checked @endif>
                                        <label for="option_visitors">Event visitors</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="can_see_visitors" id="option_nobody" class="radio-input" value="No body" @if($event->can_see_visitors == 'No body') checked @endif>
                                        <label for="option_nobody">No body</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body bg-gradient-light">
                        <div class="row justify-content-around w-100">
                            <a type="button" href="/home"  class="btn btn-default mt-1 mb-1">Cancel</a>
                            <button type="submit" class="btn btn-warning mt-1 mb-1">Save changes</button>
                        </div>
                    </div>
                </div>
            </form>
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
