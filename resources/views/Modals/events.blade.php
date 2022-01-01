@foreach ($my_events as $event)
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
                    <input type="text" placeholder="Notification content" name="content" class="form-control container__input" required>
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
                    <input type="password" placeholder="Password..." name="password" class="form-control container__input" required>
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