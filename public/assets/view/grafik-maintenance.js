// Archivment check pressure
var options = {
    series: [],
    chart: {
        type: "bar",
        height: 360,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "rounded",
        },
    },
    noData: {
        text: "Loading...",
    },
    dataLabels: {
        enabled: true,
        textAnchor: "middle",
        style: {
            colors: ["#000", "#000", "#f00"],
        },
        formatter: function (val, {seriesIndex, seriesName, w}) {
            if (seriesIndex == 2) {
                return val + "%";
            }else{
                return val;
            }
        },
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [],
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
            opacityTo: 0.8,
            stops: [0, 100],
        },
    },
    colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
    tooltip: {
        shared : true,
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
            {
                formatter: function (val) {
                    return val + " %";
                },
            },
        ],
    },
};

var chart_pressure_check_hd = new ApexCharts(
    document.querySelector("#chart-pressure-hd-check"),
    options
);
chart_pressure_check_hd.render();

var url = $("#chart-pressure-hd-check").data("url");

$.getJSON(url, function (response) {
    chart_pressure_check_hd.updateSeries([
        {
            name: "Target",
            type: "column",
            data: response["target"],
        },
        {
            name: "Act",
            type: "column",
            data: response["act"],
        },
        {
            name: "Acv",
            type: "line",
            data: response["acv"],
        },
    ]);
    chart_pressure_check_hd.updateOptions({
        noData: {
            text: "No Data",
        },
        xaxis: {
            categories: response['label'],
        },
        yaxis: [
            {
                seriesName: "Target",
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
            {
                seriesName: "Act",
                show: false,
                min: 0,
                float: false,
                max: response["max"],
            },
            {
                opposite: true,
                seriesName: "Acv",
                title: {
                    text: "Percentage",
                },
                axisTicks: {
                    show: true,
                },
                float: false,
                axisBorder: {
                    show: true,
                },
            },
        ],
    });
});
var chart_pressure_check_support = new ApexCharts(
    document.querySelector("#chart-check-rtd"),
    options
);
chart_pressure_check_support.render();

var url = $("#chart-check-rtd").data("url");

$.getJSON(url, function (response) {
    chart_pressure_check_support.updateSeries([
        {
            name: "Target",
            type: "column",
            data: response["target"],
        },
        {
            name: "Act",
            type: "column",
            data: response["act"],
        },
        {
            name: "Acv",
            type: "line",
            data: response["acv"],
        },
    ]);
    chart_pressure_check_support.updateOptions({
        noData: {
            text: "No Data",
        },
        xaxis: {
            categories: response['label'],
        },
        yaxis: [
            {
                seriesName: "Target",
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
            {
                seriesName: "Act",
                show: false,
                min: 0,
                float: false,
                max: response["max"],
            },
            {
                opposite: true,
                seriesName: "Acv",
                title: {
                    text: "Percentage",
                },
                axisTicks: {
                    show: true,
                },
                float: false,
                axisBorder: {
                    show: true,
                },
            },
        ],
    });
    // chart_pressure_check_support.render();
});