var tireoptions = {
    series: [],
    legend: {
        position: "top",
    },
    chart: {
        type: "bar",
        height: 360,
    },
    // plotOptions: {
    //     bar: {
    //         horizontal: false,
    //         columnWidth: "60%",
    //         dataLabels: {
    //             position: 'top', // top, center, bottom
    //         },
    //     },
    // },
    noData: {
        text: "No Data",
    },
    dataLabels: {
        enabled: true,
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    stroke: {
        show: true,
        width: 10,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [
            "<10000",
            "10001-20000",
            "20001-30000",
            "30001-40000",
            "40001-50000",
            "60000<",
        ],
    },

    fill: {
        opacity: 1,
        // colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
        type: "gradient",
        gradient: {
            shade: "light",
            type: "vertical",
            shadeIntensity: 0.4,
            inverseColors: false,
            opacityFrom: 0.9,
            opacityTo: 1,
            stops: [0, 100],
        },
    },
    // // colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
    tooltip: {
        shared: true,
        y: [
            {
                formatter: function (val) {
                    return val;
                },
            },
            {
                formatter: function (val) {
                    return val;
                },
            },
        ],
    },
};

var tire_inventory = new ApexCharts(
    document.querySelector("#chart-tire-inventory"),
    tireoptions
);
tire_inventory.render();

var url = $("#chart-tire-inventory").data("url");

$.getJSON(url, function (response) {
    tire_inventory.updateSeries(response['value']);
    tire_inventory.updateOptions({

        series: response['value'],
        yaxis: [
            {
                // seriesName: "27.00R49",
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
                max: response["max"],
            },
        ],
        noData: {
            text: "No Data",
        },
    });
});

//

var brandusageoptions = {
    chart: {
        type: 'bar',
        height: 380,
        zoom: {
            enabled: true,
            type: 'x',
            resetIcon: {
                offsetX: -10,
                offsetY: 0,
                fillColor: '#fff',
                strokeColor: '#37474F'
            },
            selection: {
                background: '#90CAF9',
                border: '#0D47A1'
            }
        }
    },
    plotOptions: {
        bar: {
            horizontal: true,
            dataLabels: {
                position: 'top', // top, center, bottom
            },
        },

    },
    dataLabels: {
        enabled: true,
        style: {
            colors: ['#333']
        },
        offsetX: -1
    },
    // dataLabels: {
    //     enabled: true,
    //     textAnchor: 'start',
    //     style: {
    //         colors: '#000',
    //         fontSize: '9pt',
    //     },
    //     offsetX: 30,
    // },
    series: [],

};

var chart_brand_usage = new ApexCharts(document.querySelector("#chart-brand-usage"), brandusageoptions);
chart_brand_usage.render();

var url = $("#chart-brand-usage").data("url");
$.getJSON(url, function (response) {
    chart_brand_usage.updateOptions({
        chart: {
            height: (response.length == 0 ? 10 : response.length) * 30 + 100
        },
        series: [{
            data: response,
        }],
        noData: {
            text: "No Data",
        },
    });
    // chart_brand_usage.render();
});
