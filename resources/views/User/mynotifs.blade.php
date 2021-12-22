<h3 class="text-info">My Notifications</h3>
<div class="col-12 row align-items-center">
    @foreach (DB::table('notifications')->where('send_to', Auth::id())->get() as $notification)
        <div class="col-12 position-relative row my-2">
            <div>
               <img src="{{\App\Models\User::find($notification->author)->profile_photo}}" class="img-circle img-md mr-2" alt="avatar">
            </div>
            <div class="p-2 bg-white">
                <p class="meta">{{$notification->created_at}} <a href="#" class="mx-1">{{\App\Models\User::find($notification->author)->username}}</a> notified :</p>
                <p class="">
                    {{$notification->data}}
                </p>  
            </div>
        </div>
    @endforeach
</div>
