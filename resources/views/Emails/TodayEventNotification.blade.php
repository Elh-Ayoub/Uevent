<style>body{font-family:'Open Sans',sans-serif; border-radius: 20px; box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; width: 100%; height: fit-content;}
</style>
<body>
    <div style="text-align: center; padding: 10px;">
        <h2><strong>Notification</strong></h2>
        <p style="font-size: medium">{{$msg}}</p>
        <div class="modal-body" style="width: 75%; margin: auto;">
            <p style="display: flex; justify-content: space-between; font-size: medium;"><strong>Event Title :</strong><span>{{$event->title}}</span></p>
            <p style="display: flex; justify-content: space-between; font-size: medium;"><strong>Event description :</strong><span>{{($event->description) ? ($event->description) : ("No description")}}</span></p>
            <p style="display: flex; justify-content: space-between; font-size: medium;"><strong>Location :</strong><span>{{$event->location}}</span></p>
        </div>
        <p>To go to event page to check detail again:</p>
        <a href="{{route('event.details', $event->id)}}" style="padding: 10px 15px; background-color: #2d529d; color: white; text-align: center; border-radius: 15px; font-size: 18px; margin-top: 10px; text-decoration: none;">Event details</a>    
    </div>
    <div style="padding: 10px;">
        <p class="text-bold">Visitor information: </p>
        <p>Full name: <b>{{$user->full_name}}</b></p>
        <p>Email: <b>{{$user->email}}</b></p>
    </div>
    <div style="background-color: #2d529d; color: white; padding: 10px;">
        <p>Respectfully,<br><a href="https://github.com/Elh-Ayoub" style="color: white; text-decoration: none; cursor: pointer;">Ayoub El-Haddadi</a><br>Ucode<br></p>
    </div>
</body>