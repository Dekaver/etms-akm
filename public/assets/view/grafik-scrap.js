//tire injury
if ($("#chart-tire-scrap-injury").length > 0) {
    const tireInjuryOptions = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "bar",
            height: 460,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "55%",
                dataLabels: {
                    position: 'top',
                  },
                // endingShape: 'rounded'
            },
        },
        noData: {
            text: "Loading...",
        },
        dataLabels: {
            enabled: true,
            textAnchor: "middle",
            style: {
                colors: ["#000"],
            },
            formatter: function (val) {
                return val;
            },
            offsetX: 0,
            // dropShadow: {
            //     enabled: true,
            // },
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {},

        fill: {
            opacity: 1,
            // // colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
            type: "gradient",
            gradient: {
                shade: "light",
                type: "vertical",
                shadeIntensity: 0.4,
                inverseColors: false,
                opacityFrom: 0.9,
                opacityTo: 0.8,
                stops: [0, 100],
            },
        },
        // // colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
        tooltip: {
            y: [
                {
                    formatter: function (val) {
                        return val;
                    },
                },
            ],
        },
    };

    const tire_scrap_injury = new ApexCharts(
        document.querySelector("#chart-tire-scrap-injury"),
        tireInjuryOptions
    );
    tire_scrap_injury.render();

    var url = $("#chart-tire-scrap-injury").data("url");

    $.getJSON(url, (response) => {
        tire_scrap_injury.updateOptions({
            series: [{
                name: "Cost",
                type: "bar",
                data: response.value,
            }],
            yaxis: [
                {
                    title: {
                        text: "Total",
                    },
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                    },
                    min: 0,
                    float: false,
                },
            ],
            xaxis: {
                labels: {
                    rotate: -30,
                    rotateAlways: true,
                    trim: false,
                    minHeight: 100,
                },
                categories: response.damage,
                tickPlacement: "on",
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

if($("#chart-tire-scrap-injury-cause").length > 0) {
    //tire injury cause
    var tireInjuryOptions = {
        series: [],
        chart: {
            type: "donut",
            height: 460,
        },
        plotOptions: {
            pie: {
            donut: {
                // size: 35,
                labels: {
                  show: true,
                  name: {
                      show: true,
                  },
                  value: {
                      show: true,
                  },
                  total: {
                      show: true,
                      // showAlways: true,
                      label: "Total",
                  },
                },
            },
            },
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            style: {
                colors: ['#fff'],
                fontSize: '12pt',
            },
            formatter: function (val, opt) {
                // console.log(opt)
                return   opt.w.globals.series[opt.seriesIndex]+" : " + val.toFixed(0)+ " %"
            },
            offsetX: 0,
              dropShadow: {
                enabled: true
            }
        },
    };

    var tire_scrap_injury_cause = new ApexCharts(
        document.querySelector("#chart-tire-scrap-injury-cause"),
        tireInjuryOptions
    );
    tire_scrap_injury_cause.render();

    var url = $("#chart-tire-scrap-injury-cause").data("url");

    $.getJSON(url, (response) => {
        console.log(response);
        tire_scrap_injury_cause.updateOptions({
            series: response.data,
            labels: response.xaxis,
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200,
                        },
                        legend: {
                            position: "bottom",
                        },
                    },
                },
            ],
        });
    });
}


