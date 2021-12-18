/* * Today * */
$(function () {
    
    function getSize(elementId) {
      return {
        width: document.getElementById(elementId).offsetWidth,
        height: document.getElementById(elementId).offsetHeight,
      }
    }
    let data = $('#today').data('info')
    if(data.length == 0){
        data = [[$('#today').data('today')], [0]]
    }
    // data[0].forEach(element => {
    //     console.log(new Date(element * 1000));
    // });
    // console.log(data);

    const optstoday = {
        ... getSize('today'),
        scales: {
            x: {
                time: true,
                auto: false,
            },
            y: {
            range: [0, (Math.max(...data[1]) == 0) ? (2) : (Math.max(...data[1]) * 1.5)],
            },
        },
        series: [
            {},
            {
            fill: 'rgba(60,141,188,0.4)',
            width: 5,
            stroke: 'rgba(60,141,188,1)',
            },
        ],
    };

    let today = new uPlot(optstoday, data, document.getElementById('today'));

    window.addEventListener("resize", e => {
      today.setSize(getSize('today'));
    });
})

const monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"];
const dayNmaes = ["Monday", "Tuesday", "Wednesday", "Thursday ", "Friday", "Saturday", "Sunday"];

/* * This week * */

var bar_data = {
    data : $('#bar-week').data('week'),
    bars: { show: true }
}
$.plot('#bar-week', [bar_data], {
    grid  : {
        hoverable  : true,
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
    },
    series: {
        bars: {
            show: true, barWidth: 0.5, align: 'center',
        },
    },
    colors: ['#3c8dbc'],
    xaxis : {
        ticks: [[1,'Mon'], [2,'Tue'], [3,'Wed'], [4,'Thu'], [5,'Fri'],[6,'Sat'],[7,'Sun']]
    }
})

/* * This year * */
var bar_data2 = {
    data : $('#bar-year').data('year'),
    bars: { show: true }
}
$.plot('#bar-year', [bar_data2], {
    grid  : {
        hoverable  : true,
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
    },
    series: {
        bars: {
            show: true, barWidth: 0.5, align: 'center',
        },
    },
    colors: ['#3c8dbc'],
    xaxis : {
        ticks: [[1,'Jan'], [2,'Feb'], [3,'Mar'], [4,'Apr'], [5,'May'],[6,'Jun'],[7,'Jul'],[8,'Aug'],[9,'Sep'],[10,'Oct'],[11,'Nov'],[12,'Dec']]
    },
})
//Initialize tooltip on hover
$('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
    position: 'absolute',
    display : 'none',
    opacity : 0.8
  }).appendTo('body')
$('#bar-year').on('plothover', function (event, pos, item) {
    if (item) {
        var y = item.datapoint[1].toFixed(2)
        $('#line-chart-tooltip').html(monthNames[item.datapoint[0] - 1] + " : " + item.datapoint[1])
        .css({
            top : item.pageY + 5,
            left: item.pageX + 5
        })
        .fadeIn(200)
    } else {
        $('#line-chart-tooltip').hide()
    }

})
$('#bar-week').on('plothover', function (event, pos, item) {
    if (item) {
        var y = item.datapoint[1].toFixed(2)
        $('#line-chart-tooltip').html(dayNmaes[item.datapoint[0] - 1] + " : " + item.datapoint[1])
        .css({
            top : item.pageY + 5,
            left: item.pageX + 5
        })
        .fadeIn(200)
    } else {
        $('#line-chart-tooltip').hide()
    }

})
