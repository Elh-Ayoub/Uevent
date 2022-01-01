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
                <div class="text-center mb-3">
                    {{-- <h5 class="text-primary h6">Our Blog</h5> --}}
                    <h2 class="display-20 display-md-18 display-lg-16">Most recent event</h2>
                </div>
                <div class="pull-right inline-block margin-top-xs row mb-3">
                    <span class="ml-2 mr-2 mt-1 text-muted text-bold">Sort by:</span>
                    <form id="branch-sort" class="form-inline">
                        <span class="sortBy btn btn-outline-info" type="button">
                            Title
                            <span class="js-icon-dsc light margin-left-xs">
                                <i id="branch-sort-icon" class="fa fa-chevron-down xs"></i>
                            </span>
                        </span>
                        <input id="NameSortOrder" type="hidden" value="AtoZ">
                        <input id="js-sort-numberShowing" type="hidden" value="">
                    </form>
                    <form id="price-sort" class="form-inline ml-2">
                        <span class="sortBy btn btn-outline-info" type="button">
                            Price
                            <span class="js-icon-dsc light margin-left-xs">
                                <i id="price-sort-icon" class="fa fa-chevron-down xs"></i>
                            </span>
                        </span>
                        <input id="PriceSortOrder" type="hidden" value="AtoZ">
                        <input id="js-sort-numberShowing" type="hidden" value="">
                    </form>
                    <form id="begins-sort" class="form-inline ml-2">
                        <span class="sortBy btn btn-outline-info" type="button">
                            Begining date
                            <span class="js-icon-dsc light margin-left-xs">
                                <i id="begins-sort-icon" class="fa fa-chevron-down xs"></i>
                            </span>
                        </span>
                        <input id="BeginsSortOrder" type="hidden" value="AtoZ">
                        <input id="js-sort-numberShowing" type="hidden" value="">
                    </form>
                </div>
                <div class="row align-items-start">
                    <div class="col-md-2 card p-3">
                        <div class="col-12">
                            <h6 class="mb-0 text-lg text-bold text-info">Categories</h6>
                        </div>
                        <hr>
                        <div>
                            <input type="checkbox" class="cat-check d-none" name="all-categories" id="all-categories" checked>
                            <label class="cat-check-label px-2 py-1" for="all-categories">All</label>
                        </div>
                        @foreach (App\Models\Category::all() as $category)
                        <div>
                            <input type="checkbox" name="categories" class="cat-check d-none" value="{{$category->id}}" id="{{$category->id}}">
                            <label class="cat-check-label px-2 py-1" for="{{$category->id}}">{{$category->title}}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="row all-events col-md-10">
                    @foreach ($events as $event)
                        <div class="col-lg-4 col-md-6 mb-3 event-container" data-branch-name="{{$event->title}}" data-branch-price="{{$event->ticket_price}}" data-branch-begins="{{strtotime($event->begins_at)}}" data-category="{{$event->category}}">
                            <article class="card card-style2">
                                <div class="card-img">
                                    <img class="w-100" src="{{$event->poster}}" alt="...">
                                    <div class="date"><span>{{ date('d', strtotime($event->begins_at))}}</span>{{date('M', strtotime($event->begins_at))}}</div>
                                </div>
                                <div class="card-body">
                                    <h3 class="h5"><a href="{{route('event.details', $event->id)}}" class="event-title">{{$event->title}}</a></h3>
                                    <p class="display-30">{{$event->description}}</p>
                                    <p style="color: #004975"><span class="text-xl text-bold"> @if($event->ticket_price == 0) Free @else {{($event->ticket_price)}}<i class="fas fa-dollar-sign text-lg"></i>@endif</span></p>
                                    <a href="{{route('event.details', $event->id)}}" class="read-more">More details</a>
                                </div>
                                <div class="card-footer">
                                    @php
                                        $author = App\Models\User::find($event->author);
                                        $company = App\Models\Company::find($author->company_id);
                                    @endphp
                                    <ul>
                                        <li><a href="#!"><i class="fas fa-user"></i>@if($event->behalf_of_company == "yes" && $company){{$company->name}} @else {{$author->username}} @endif</a></li>
                                        <li><a href="#!"><i class="far fa-comment-dots"></i><span>{{count(App\Models\Comment::where('event_id', $event->id)->get())}}</span></a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    @endforeach
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
