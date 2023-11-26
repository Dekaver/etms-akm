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
            fontSize: "12px",
            colors: ["#304758"],
        },
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
                formatter(val) {
                    return val;
                },
            },
            {
                formatter(val) {
                    return val;
                },
            },
        ],
    },
};

if ($("#chart-tire-inventory").length > 0) {
    const tire_inventory = new ApexCharts(
        document.querySelector("#chart-tire-inventory"),
        tireoptions
    );
    tire_inventory.render();

    var url = $("#chart-tire-inventory").data("url");

    $.getJSON(url, (response) => {
        tire_inventory.updateSeries(response.value);
        tire_inventory.updateOptions({
            series: response.value,
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
                    max: response.max,
                },
            ],
            noData: {
                text: "No Data",
            },
        });
    });
}

//


if ($("#chart-brand-usage").length > 0) {
    var brandusageoptions = {
        chart: {
            type: "bar",
            height: 380,
            zoom: {
                enabled: true,
                type: "x",
                resetIcon: {
                    offsetX: -10,
                    offsetY: 0,
                    fillColor: "#fff",
                    strokeColor: "#37474F",
                },
                selection: {
                    background: "#90CAF9",
                    border: "#0D47A1",
                },
            },
        },
        plotOptions: {
            bar: {
                horizontal: true,
                dataLabels: {
                    position: "top", // top, center, bottom
                },
            },
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ["#333"],
            },
            offsetX: -1,
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
    var chart_brand_usage = new ApexCharts(
        document.querySelector("#chart-brand-usage"),
        brandusageoptions
    );
    chart_brand_usage.render();

    var url = $("#chart-brand-usage").data("url");
    $.getJSON(url, (response) => {
        chart_brand_usage.updateOptions({
            chart: {
                height:
                    (response.length == 0 ? 10 : response.length) * 30 + 100,
            },
            series: [
                {
                    data: response,
                },
            ],
            noData: {
                text: "No Data",
            },
        });
        // chart_brand_usage.render();
    });
}

// tire fitment chart
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
            fontSize: "12px",
            colors: ["#304758"],
        },
    },
    stroke: {
        show: true,
        width: 2,
        // colors: ["transparent"],
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
    // colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
    tooltip: {
        shared: true,
        // y: [
        //     {
        //         formatter(val) {
        //             return val;
        //         },
        //     },
        //     {
        //         formatter(val) {
        //             return val;
        //         },
        //     },
        // ],
    },
};
if ($("#chart-tire-fitment").length > 0) {
    const tire_fitments = new ApexCharts(
        document.querySelector("#chart-tire-fitment"),
        tireoptions
    );
    tire_fitments.render();
    var url = $("#chart-tire-fitment").data("url");

    $.getJSON(url, (response) => {
        tire_fitments.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_fitments.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

if ($("#chart-tire-fitment-month").length > 0) {
    const tire_fitments_month = new ApexCharts(
        document.querySelector("#chart-tire-fitment-month"),
        tireoptions
    );
    tire_fitments_month.render();
    var url = $("#chart-tire-fitment-month").data("url");

    $.getJSON(url, (response) => {
        tire_fitments_month.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_fitments_month.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}
if ($("#chart-tire-fitment-week").length > 0) {
    const tire_fitments_week = new ApexCharts(
        document.querySelector("#chart-tire-fitment-week"),
        tireoptions
    );
    tire_fitments_week.render();
    var url = $("#chart-tire-fitment-week").data("url");

    $.getJSON(url, (response) => {
        tire_fitments_week.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_fitments_week.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

// tire removed chart
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
            fontSize: "12px",
            colors: ["#304758"],
        },
    },
    stroke: {
        show: true,
        width: 2,
        // colors: ["transparent"],
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
    // colors: [vihoAdminConfig.primary, vihoAdminConfig.secondary],
    // tooltip: {
    //     shared: true,
    //     y: [
    //         {
    //             formatter(val) {
    //                 return val;
    //             },
    //         },
    //         {
    //             formatter(val) {
    //                 return val;
    //             },
    //         },
    //     ],
    // },
};
if ($("#chart-tire-removed").length > 0) {
    const tire_removeds = new ApexCharts(
        document.querySelector("#chart-tire-removed"),
        tireoptions
    );
    tire_removeds.render();
    var url = $("#chart-tire-removed").data("url");

    $.getJSON(url, (response) => {
        tire_removeds.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_removeds.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

if ($("#chart-tire-removed-month").length > 0) {
    const tire_removeds_month = new ApexCharts(
        document.querySelector("#chart-tire-removed-month"),
        tireoptions
    );
    tire_removeds_month.render();
    var url = $("#chart-tire-removed-month").data("url");

    $.getJSON(url, (response) => {
        tire_removeds_month.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_removeds_month.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}
if ($("#chart-tire-removed-week").length > 0) {
    const tire_removeds_week = new ApexCharts(
        document.querySelector("#chart-tire-removed-week"),
        tireoptions
    );
    tire_removeds_week.render();
    var url = $("#chart-tire-removed-week").data("url");

    $.getJSON(url, (response) => {
        tire_removeds_week.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_removeds_week.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

// tire removed chart

if ($("#chart-tire-removed").length > 0) {
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
                fontSize: "12px",
                colors: ["#304758"],
            },
        },
        stroke: {
            show: true,
            width: 1,
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
                    formatter(val) {
                        return val;
                    },
                },
                {
                    formatter(val) {
                        return val;
                    },
                },
            ],
        },
    };
    const tire_removed = new ApexCharts(
        document.querySelector("#chart-tire-removed"),
        tireoptions
    );
    tire_removed.render();
    var url = $("#chart-tire-removed").data("url");

    $.getJSON(url, (response) => {
        tire_removed.updateSeries(response.value);
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_removed.updateOptions({
            series: response.value,
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
                    max: dynamicMax,
                },
            ],
            xaxis: {
                categories: response.xaxis,
            },
            noData: {
                text: "No Data",
            },
        });
    });
}

// Brand Usages

if ($("#chart-brand-usage").length > 0) {
    var brandusageoptions = {
        chart: {
            type: "bar",
            height: 380,
            zoom: {
                enabled: true,
                type: "x",
                resetIcon: {
                    offsetX: -10,
                    offsetY: 0,
                    fillColor: "#fff",
                    strokeColor: "#37474F",
                },
                selection: {
                    background: "#90CAF9",
                    border: "#0D47A1",
                },
            },
        },
        plotOptions: {
            bar: {
                horizontal: true,
                dataLabels: {
                    position: "top", // top, center, bottom
                },
            },
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ["#333"],
            },
            offsetX: -1,
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
    var chart_brand_usage = new ApexCharts(
        document.querySelector("#chart-brand-usage"),
        brandusageoptions
    );
    chart_brand_usage.render();

    var url = $("#chart-brand-usage").data("url");
    $.getJSON(url, (response) => {
        chart_brand_usage.updateOptions({
            chart: {
                height: (response.length == 0 ? 10 : response.length) * 30 + 100,
            },
            series: [
                {
                    data: response,
                },
            ],
            noData: {
                text: "No Data",
            },
        });
        // chart_brand_usage.render();
    });
}
