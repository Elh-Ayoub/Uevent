@if(count($my_events) == 0)
        <h3 class="text-info"><i class="fas fa-exclamation-triangle mr-2"></i>No events created yet</h3>
        <p><a href="{{route('events.create')}}" class="link-muted"><i class="fas fa-plus mr-1"></i>Create event</a></p>
@else
<h3 class="text-info">My events</h3>
<ul class="event-list clearfix">
    @foreach ($my_events as $event)
        <li class="col-md-5">
            <div class="event-item">
                <div class="event-img"><img src="{{$event->poster}}" alt="" /></div>
                <div class="event-info row justify-content-between">
                    <div>
                      <h4 class="ml-3"><a href="{{route('event.details', $event->id)}}" class="myevent-link">{{$event->title}}</a></h4>  
                    </div>
                    <div class="small">
                        <a href="#" class="link-muted mr-2" data-toggle="modal" data-target="#notify-{{$event->id}}">Notify visitors</a>
                        <a href="{{route('events.edit', $event->id)}}" class="link-muted">Edit</a>
                        <a href="#" class="link-muted ml-2" data-toggle="modal" data-target="#delete-{{$event->id}}">Delete</a>
                    </div>
                </div>
            </div>
        </li>
        <div id="notify-{{$event->id}}" class="modal fade">
            <form action="{{route('events.notification', $event->id)}}" method="POST" class="modal-dialog">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-gradient-info">
                        <h5 class="modal-title">Send notification to "{{$event->title}}" visitors</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row justify-content-center">
                        <div class="form-group input-container col-12">
                            <input type="text" id="title" placeholder="Notification content" name="content" class="form-control container__input" required>
                            <label class="container__label" for="title">Notification content</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Send</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="delete-{{$event->id}}" class="modal fade">
            <form action="{{route('event.destroy', $event->id)}}" method="POST" class="modal-dialog">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-gradient-danger">
                        <h5 class="modal-title">Delete event</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body row justify-content-center">
                        <p class="text-bold text-lg-center text-danger">You're about to delete your event! To confirm input password.</p>
                        <div class="form-group input-container col-12">
                            <input type="password" id="pass" placeholder="Password..." name="password" class="form-control container__input" required>
                            {{-- <label class="container__label" for="pass">Password</label> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
</ul>
@endif