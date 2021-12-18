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
<div class="col-12 row justify-content-between">
    <div class="card card-info card-outline col-5">
        <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
                This week
            </h3>
        </div>
        <div class="card-body">
        <div id="bar-week" data-week="{{json_encode($week_subs)}}" style="height: 300px;"></div>
        </div>
    </div>   
    <div class="card card-info card-outline col-sm-6">
        <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
                This year
            </h3>
        </div>
        <div class="card-body">
            <div id="bar-year" data-year="{{json_encode($year_subs)}}" style="height: 300px;"></div>
        </div>
    </div> 
</div>
