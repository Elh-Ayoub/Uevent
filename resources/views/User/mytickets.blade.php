<h3 class="text-info">My Tickets</h3>
<div class="col-12 row align-items-center">
    @foreach ($my_tickets as $ticket)
        @php
            $event = App\Models\Event::find($ticket->event_id);
            if (!$event) {
                continue;
            }
            $strtime = strtotime($event->begins_at);
        @endphp
            <article class="card-ticket  col-sm-5 mx-2 mb-0">
                <section class="date px-2">
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
                    <a href="" data-toggle="modal" class="fl-right mt-2 " data-target="#preview-ticket-{{$ticket->id}}">Preview</a>
                </section>
            </article>
    @endforeach
</div>