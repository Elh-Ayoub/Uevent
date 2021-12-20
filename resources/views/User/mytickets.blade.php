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
            <article class="card card-ticket  col-sm-5 mx-2">
                <section class="date px-3">
                    <time>
                        <span>{{date('d', $strtime)}}</span><span>{{date('M', $strtime)}}</span>
                    </time>
                </section>
                <section class="card-cont">
                    <small>{{$event->id}} -- {{$ticket->id}}</small>
                    <h3>{{$event->title}}</h3>
                    <div class="row ml-2">
                        <div>
                            <span><i class="fa fa-calendar"></i> {{date('D  d  M  Y ', $strtime)}}</span><br>
                            <span><i class="fa fa-clock"></i> At: {{date('H:i', $strtime)}}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p>
                            <i class="fa fa-map-marker"></i>
                            {{$event->location}}
                        </p>
                    </div>
                    <a href="" data-toggle="modal" data-target="#preview-ticket-{{$ticket->id}}">Preview</a>
                </section>
            </article>
            <div id="preview-ticket-{{$ticket->id}}" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-info">
                            <h5 class="modal-title">Ticket to {{$event->title}}</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body row justify-content-center">
                            <article class="card card-ticket  col-11 mx-2">
                                <section class="date px-3">
                                    <time>
                                        <span>{{date('d', $strtime)}}</span><span>{{date('M', $strtime)}}</span>
                                    </time>
                                </section>
                                <section class="card-cont">
                                    <small>{{$event->id}} -- {{$ticket->id}}</small>
                                    <h3>{{$event->title}}</h3>
                                    <div class="row ml-2">
                                        <div>
                                            <span><i class="fa fa-calendar"></i> {{date('D  d  M  Y ', $strtime)}}</span><br>
                                            <span><i class="fa fa-clock"></i> At: {{date('H:s', $strtime)}}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <p>
                                            <i class="fa fa-map-marker"></i>
                                            {{$event->location}}
                                        </p>
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
</div>