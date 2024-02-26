//tire injury
if ($("#chart-tire-cause-damage").length > 0) {
    const tireInjuryOptions = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "bar",
            height: 460,
            stacked: true,
            stackType: "100%",
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "55%",
                dataLabels: {
                    position: "top",
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
            formatter: function (value, { seriesIndex, dataPointIndex, w }) {
                return w.config.series[seriesIndex].data[dataPointIndex] || 0;
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
            // colors: ["#FFF","#000","#000","#000","#000","#000",],
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
            shared: true,
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
        document.querySelector("#chart-tire-cause-damage"),
        tireInjuryOptions
    );
    tire_scrap_injury.render();

    const url = $("#chart-tire-cause-damage").data("url");

    $.getJSON(url, (response) => {
        tire_scrap_injury.updateOptions({
            series: [...response.data],
            yaxis: [
                {
                    // seriesName: '27.00R49',
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
                categories: response.xaxis,
                tickPlacement: "on",
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

if ($("#chart-tire-cause-damage-injury").length > 0) {
    const tireInjuryOptions = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "donut",
            height: 460,
            stacked: true,
            stackType: "100%",
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
            formatter: function (value, { seriesIndex, dataPointIndex, w }) {
                return (w.config.series[seriesIndex] || 0) + " : " + value.toFixed(1) + "%";
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
            // colors: ["#FFF","#000","#000","#000","#000","#000",],
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
            shared: true,
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
        document.querySelector("#chart-tire-cause-damage-injury"),
        tireInjuryOptions
    );
    tire_scrap_injury.render();

    const url = $("#chart-tire-cause-damage-injury").data("url");

    $.getJSON(url, (response) => {
        tire_scrap_injury.updateOptions({
            series: [...response.data.map(a=>parseFloat(a))],
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
            labels: response.xaxis,
            noData: {
                text: "No Data",
            },
        });
    });
}
