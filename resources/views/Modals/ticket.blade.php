@foreach ($my_tickets as $ticket)
    @php
        $event = App\Models\Event::find($ticket->event_id);
        if (!$event) {
            continue;
        }
        $strtime = strtotime($event->begins_at);
    @endphp
<div id="preview-ticket-{{$ticket->id}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title">Ticket to {{$event->title}}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body row justify-content-center px-0 mx-0"  style="background: #F4F6F9;">
                <article class="card card-ticket  col-11 mx-2">
                    <section class="date px-3">
                        <time>
                            <span>{{date('d', $strtime)}}</span><span>{{date('M', $strtime)}}</span>
                        </time>
                    </section>
                    <section class="card-cont col-12 pr-2">
                        <small>{{$event->id}} -- {{$ticket->id}}</small>
                        <h3>{{$event->title}}</h3>
                        <div class="row d-flex justify-content-between align-items-end">
                            <div  class="col-md-8">
                                <span><i class="fa fa-calendar"></i> {{date('D  d  M  Y ', $strtime)}}</span><br>
                                <span><i class="fa fa-clock"></i> At: {{date('H:i', $strtime)}}</span><br>
                                <span><i class="fa fa-map-marker"></i> {{$event->location}}</span>
                            </div>
                            <img src="{{$ticket->qr_code}}" class="col-md-4" class="img-fluid img-md" alt="">
                        </div>
                    </section>
                </article>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endforeach
