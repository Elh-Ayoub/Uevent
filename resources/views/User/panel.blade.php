<h3 class="text-info">Subscriptions to your events</h3><br>
<div class="col-12 row justify-content-around align-items-stretch">
    <div class="card card-info col-12 p-0">
        <div class="card-header">
            <h3 class="card-title">Today</h3>
        </div>
        <div class="card-body">
        <div class="chart">
            <div id="today" data-info="{{json_encode($today_subs)}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
        </div>
        </div>
    </div> 
</div>
<div class="card card-info col-5 p-0">
    <div class="card-header">
        <h3 class="card-title">This week</h3>
    </div>
    <div class="card-body">
        <div class="chart">
            <div id="this_week" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
        </div>
    </div>
</div>
