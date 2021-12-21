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
                        <a href="{{route('events.edit', $event->id)}}" class="link-muted">Edit</a>
                        <a href="" class="link-muted ml-1">Delete</a>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@endif