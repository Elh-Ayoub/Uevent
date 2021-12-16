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
            range: [0, Math.max(...data[1]) * 1.5],
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
