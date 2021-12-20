<style>body{font-family:'Open Sans',sans-serif; border-radius: 20px; box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; width: 100%; height: fit-content;}
</style>

<body>
    <div style="text-align: center; padding: 10px;">
        <h2><strong>Notification</strong></h2>
        <p style="font-size: medium">Hello, you have subscribed successfully to an event.</p>
        <div class="modal-body" style="width: 75%; margin: auto;">
            <p style="display: flex; justify-content: space-between; font-size: medium;"><strong>Title :</strong><span>{{$event->title}}</span></p>
            <p style="display: flex; justify-content: space-between; font-size: medium;"><strong>Description :</strong><span>{{($event->description) ? ($event->description) : ("No description")}}</span></p>
            <p style="display: flex; justify-content: space-between; font-size: medium;"><strong>Start at :</strong><span>{{$event->begins_at}}</span></p>
        </div>
        <p>Your ticket:</p>
        <div style="width: 60%; margin: auto;">
            <article style="display: table-row;width: 60%;background-color: #fff;color: #989898;margin-bottom: 10px;font-family: 'Oswald', sans-serif;text-transform: uppercase;border-radius: 4px;position: relative; margin: 0 10px;">
                <section class="date px-3" style="display: table-cell;width: 30%;position: relative;text-align: center;border-right: 2px dashed #dadde6;">
                    <time style="display: block;position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);-ms-transform: translate(-50%, -50%);transform: translate(-50%, -50%);">
                        <span style="display: block; font-weight: bold;">{{date('d', strtotime($event->begins_at))}}</span><span>{{date('M', strtotime($event->begins_at))}}</span>
                    </time>
                </section>
                <section class="card-cont" style="display: table-cell;width: 75%;font-size: 85%;padding: 10px 10px 30px 50px;">
                    <small>{{$event->id}} -- {{$ticket->id}}</small>
                    <h3 style="color: #3C3C3C;font-size: 130%">{{$event->title}}</h3>
                    <div class="row ml-2">
                        <div>
                            <span><i class="fa fa-calendar"></i> {{date('D  d  M  Y ', strtotime($event->begins_at))}}</span><br>
                            <span><i class="fa fa-clock"></i> At: {{date('H:i', strtotime($event->begins_at))}}</span>
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
        <p>You can check ticket in your account:</p>
        <a href="{{route('user.account')}}" style="padding: 10px 15px; background-color: #2d529d; color: white; text-align: center; border-radius: 15px; font-size: 18px; margin-top: 10px; text-decoration: none;">My account</a>
    </div>
    <div style="padding: 10px;">
        <p>Full name: <b>{{$user->full_name}}</b></p>
        <p>Email: <b>{{$user->email}}</b></p>
    </div>
    <div style="background-color: #2d529d; color: white; padding: 10px;">
        <p>Respectfully,<br><a href="https://github.com/Elh-Ayoub" style="color: white; text-decoration: none; cursor: pointer;">Ayoub El-Haddadi</a><br>Ucode<br></p>
    </div>
</body>
