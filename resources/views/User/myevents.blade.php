<ul class="event-list clearfix">
    @foreach ($my_events as $event)
        <li>
            <div class="event-item">
                <div class="event-img"><img src="{{$event->poster}}" alt="" /></div>
                <div class="event-info row justify-content-between">
                    <div>
                      <h4 class="ml-3"><a href="{{route('event.details', $event->id)}}" class="myevent-link">{{$event->title}}</a></h4>  
                    </div>
                    <div class="small">
                        <a href="" class="link-muted">Edit</a>
                        <a href="" class="link-muted ml-1">Delete</a>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
</ul>
