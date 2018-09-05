/**
 * Created by max on 26.05.17.
 */
$( document ).ready(function() {

    // $('.fa').removeClass('fa-fa');

    var ctx7 = $("#myChart7");
    var ctx30 = $("#myChart30");
    var ctx365 = $("#myChart365");
    var labels7 = [],values7 =[];
    var labels30 = [],values30 =[];
    var labels365 = [],values365 =[];
    //console.log(1);
    $.each(graph['7'],function (index,val) {
        labels7.push(val['data']);
        values7.push(val['val']);
    });

    // labels7.push('dsadsads');
    // values7.push(4000);
    // labels7.push('dobavil100');
    // values7.push(100);

    $.each(graph['30'],function (index,val) {
        labels30.push(val['data']);
        values30.push(val['val']);
    });

    $.each(graph['365'],function (index,val) {
        labels365.push(val['data']);
        values365.push(val['val']);
    });

    var myNewChart7 = new Chart(ctx7 , {
        type: "line",
        data: {
            labels:labels7,
            datasets: [
                {
                    label: label_text7,
                    fill: true,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: values7,
                    spanGaps: false,

                }
            ]
        },
        options:{
            maintainAspectRatio	: false,
            scales:
                {
                    yAxes:
                        [
                            {
                                ticks: { min: 0, beginAtZero: true, max: values7.max }
                            }
                        ]
                }

        }
    });

    var myNewChart30 = new Chart(ctx30 , {
        type: "line",
        data: {
            labels: labels30,
            datasets: [
                {
                    label: label_text30,
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: values30,
                    spanGaps: false,
                }
            ]
        },
        options:{
            maintainAspectRatio	: false,
            scales:
                {
                    yAxes:
                        [
                            {
                                ticks: { min: 0, beginAtZero: true, max: values30.max }
                            }
                        ]
                }

        }
    });

    var myNewChart365 = new Chart(ctx365 , {
        type: "line",
        data: {
            labels: labels365,
            datasets: [
                {
                    label: label_text365,
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: values365,
                    spanGaps: false,
                }
            ]
        },
        options:{
            maintainAspectRatio	: false,
            scales:
                {
                    yAxes:
                        [
                            {
                                ticks: { min: 0, beginAtZero: true, max: values365.max }
                            }
                        ]
                }

        }
    });

    $('.days_7').on('click',function () {
        $('.days li button').removeClass('active');
        $(this).addClass('active');
        $('#myChart7').css({'display':'block'});
        $('#myChart30').css({'display':'none'});
        $('#myChart365').css({'display':'none'});
    });
    $('.days_30').on('click',function () {
        $('.days li button').removeClass('active');
        $(this).addClass('active');
        $('#myChart7').css({'display':'none'});
        $('#myChart30').css({'display':'block'});
        $('#myChart365').css({'display':'none'});
    });
    $('.days_365').on('click',function () {
        $('.days li button').removeClass('active');
        $(this).addClass('active');
        $('#myChart7').css({'display':'none'});
        $('#myChart30').css({'display':'none'});
        $('#myChart365').css({'display':'block'});
    });
});