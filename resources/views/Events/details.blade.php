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
  <link rel="stylesheet" href="{{ asset('css/comments.css') }}">
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
                        <article class="card-style2 mb-3">
                            <div class="card-img">
                                <img class="w-100" src="{{$event->poster}}" alt="...">
                                <div class="date"><span>{{ date('d', strtotime($event->begins_at))}}</span>{{date('M', strtotime($event->begins_at))}}</div>
                            </div>
                        </article>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-0 text-lg text-bold sample_label">Subscription</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row justify-content-between align-items-center">
                                    @if($subscribe)
                                        <div class="col-sm-12 mt-2">
                                            <a href="#" class="btn btn-outline-success disabled"><i class="fas fa-check mr-2"></i>Subscribed</a>
                                        </div>
                                    @elseif(($event->tickets_number) && ($event->tickets_number - count($event_subs) == 0))
                                    <div class="col-sm-12 mt-2">
                                        <a href="#" class="btn btn-outline-secondary disabled"><i class="fas fa-times mr-2"></i>Unavailable tickets</a>
                                    </div>
                                    @else
                                    <div class="col-sm-12 mt-2">
                                        <a href="{{route('events.sub.view', $event->id)}}" class="btn btn-info"><i class="fas fa-plus-circle mr-2"></i>Subscribe to event</a>
                                    </div>
                                    @endif
                                    @if($notif_sub)
                                        <div class="col-sm-12 mt-2">
                                            <a class="btn btn-outline-secondary" href="{{route('events.sub.notif', $event->id)}}"><i class="fas fa-check mr-2"></i>Unubscribe to notifications</a>
                                        </div> 
                                    @else
                                        <div class="col-sm-12 mt-2">
                                            <a class="btn btn-secondary" href="{{route('events.sub.notif', $event->id)}}"><i class="far fa-flag mr-2"></i>Subscribe to notifications from author</a>
                                        </div> 
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(($event->can_see_visitors == 'Everyone') || (($event->can_see_visitors == 'Event visitors') && ($subscribe)))
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 row justify-content-around align-items-center">
                                        <h6 class="mb-0 text-lg text-bold sample_label">Visitors</h6>
                                        @if($subscribe)
                                        <select name="show_name" id="show_name" class="col-6 form-control" data-url="{{ route('events.subscribe.update', $subscribe->id) }}">
                                            <option value="yes" @if($subscribe->show_name == 'yes') selected @endif> Show my name in list</option>
                                            <option value="no" @if($subscribe->show_name == 'no') selected @endif>Don't show my name in list</option>
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    @foreach ($event_subs as $sub)
                                        @if($sub->show_name == 'yes')
                                            <div class="col-md-8 row justify-content-lg-start">
                                                <img src="{{App\Models\User::find($sub->author)->profile_photo}}" class="img-fluid img-circle img-sm" alt="User-Image" style="border: 1px solid grey;">
                                                <span class="ml-2 text-lg">{{App\Models\User::find($sub->author)->username}}</span>
                                            </div>
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- similar events --}}
                        @if(count($similar_events) > 1)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 row justify-content-around align-items-center">
                                        <h6 class="mb-0 text-lg text-bold sample_label">Similar events</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    @foreach ($similar_events as $se)
                                        @if ($se->id != $event->id)
                                        <div class="col-md-8 row align-items-center">
                                            <img src="{{$se->poster}}" class="img-fluid img-md" alt="User-Image">
                                            <span class="ml-2 text-lg"><a class="link-info text-info" href="{{route('event.details', $se->id)}}">{{$se->title}}</a></span>
                                        </div>
                                        <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-12">
                                    <h6 class="mb-0 text-lg text-bold sample_label">Author / Organizer</h6>
                                </div>
                                </div>
                                <hr>
                                <div class="row align-items-center">
                                    @php
                                        $author = App\Models\User::find($event->author);
                                        $company = App\Models\Company::find($author->company_id);
                                    @endphp
                                    @if($event->behalf_of_company == "yes" && $company)
                                        <img src="{{$company->logo}}" class="img-fluid img-circle img-md" alt="User-Image" style="border: 1px solid grey;">
                                        <span class="ml-2 text-lg">{{$company->name}}</span>
                                    @else
                                        <img src="{{$author->profile_photo}}" class="img-fluid img-circle" alt="User-Image" style="border: 1px solid grey;">
                                        <span class="ml-2 text-lg">{{$author->username}}</span>
                                    @endif
                                </div>
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
                                      <h6 class="mb-0 text-info">Begins at:  </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ date('D  d  M  Y H:i:s', strtotime($event->begins_at))}}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0 text-info">Number of Tickets:  </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary @if($event->tickets_limited === 'yes') row justify-content-around @endif">
                                        @if($event->tickets_limited === 'yes')
                                        <span class="col-6">{{$event->tickets_number}}</span>
                                        <div class="col-6">
                                          <span class="text-info">( Available: </span>
                                            {{$event->tickets_number - count($event_subs)}} )
                                        </div>
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
                                <div class="row">
                                    <div class="col-sm-3">
                                      <h6 class="mb-0 text-info">Category: </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{App\Models\Category::find($event->category)->title}} 
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
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDidlLcVi1QvFXiSpp3FgATAtoKiiwkqZ0&q={{str_replace(" ", "+", $event->location)}}"></iframe>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-0 text-lg text-bold sample_label">Comments ({{count($comments)}})</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="blog-comment col-12">
                                    @foreach ($comments as $comment)
                                    <ul class="row comments w-100">
                                        <li class="row col-12">
                                            <div class="event-comments col-12">
                                                <img src="{{\App\Models\User::find($comment->author)->profile_photo}}" class="img-circle img-md" alt="avatar">
                                                <p class="meta">{{$comment->created_at}} <a href="#" class="mx-1">{{\App\Models\User::find($comment->author)->username}}</a> says :
                                                    @if($comment->author === Auth::id()) 
                                                    <i class="float-right">
                                                        <a href="#" class="link-muted" data-toggle="modal" data-target="#modal-editComment-{{$comment->id}}">Edit</a>
                                                        <a href="#" class="link-muted ml-2" data-toggle="modal" data-target="#modal-deleteComment-{{$comment->id}}">Delete</a>
                                                    </i>
                                                    @endif
                                                </p>
                                                <p>
                                                    {{$comment->content}}
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                    {{-- edit comment modal --}}
                                    <div class="modal fade" id="modal-editComment-{{$comment->id}}">
                                        <div class="modal-dialog">
                                          <div class="modal-content bg-warning">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Edit a comment</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <form action="{{route('events.comment.update', $comment->id)}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <textarea type="text" name="content" class="form-control bg-gradient-warning">{{$comment->content}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-light">Save</button>
                                                </div>
                                            </form>
                                          </div>
                                        </div>
                                    </div>
                                    {{-- delete comment modal --}}
                                    <div class="modal fade" id="modal-deleteComment-{{$comment->id}}">
                                        <div class="modal-dialog">
                                          <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Confirmation</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <p>You are about to delete a comment. Are you sure? </p>
                                            </div>
                                            <form action="{{route('events.comment.delete', $comment->id)}}" method="POST">
                                              @csrf
                                              @method('DELETE')
                                              <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-outline-light">Delete</button>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <form action="{{route('events.comment', $event->id)}}" method="POST" class="form-group col-12 row">
                                    @csrf
                                    <input type="text" class="form-control col-10" name="comment" maxlength="500" placeholder="Type a comment ..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    <button class="btn btn-outline-info text-center" style="border-top-left-radius: 0; border-bottom-left-radius: 0;"><i class="fas fa-paper-plane"></i></button>
                                </form>
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
<script src="{{ asset('js/update-sub.js') }}"></script>
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
