//tire consumption by model unit
function generateHeightChart(length_size) {
    let height_chart = 120;
    if (length_size > 1) {
        for (let i = 0; i < length_size; i++) {
            height_chart += 100;
        }
    }
    return height_chart;
}
var tireoptions = {
    series: [],
    legend: {
        position: "top",
    },
    chart: {
        type: "bar",
        // height: 460,
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
                position: "top",
            },
            columnWidth: "100%",
        },
    },
    noData: {
        text: "Loading...",
    },
    dataLabels: {
        enabled: true,
        style: {
            colors: ["#333"],
        },
        offsetX: 25,
    },
    legend: {
        show: true,
    },
    stroke: {
        show: true,
        // width: 10,
        colors: ["transparent"],
    },
    // xaxis: {},
    xaxis: {
        show: false,
        labels: {
            show: false,
        },
        // axisBorder: {
        //   show: false
        // },
        // axisTicks: {
        //   show: false
        // }
    },
    yaxis: {
        show: true,
        showAlways: true,
    },

    // fill: {
    //     opacity: 1,
    //     colors: [vihoAdminConfig.primary, "#dc3545"],
    //     type: "gradient",
    //     gradient: {
    //         shade: "light",
    //         type: "vertical",
    //         shadeIntensity: 0.4,
    //         inverseColors: false,
    //         opacityFrom: 0.9,
    //         opacityTo: 0.8,
    //         stops: [0, 100],
    //     },
    // },
    colors: ["#35dc45", "#dc3545"],
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

//tire average
if ($("#chart-tire-lifetime").length > 0) {
    const optionTireAverage = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "line",
            height: 720,
            stacked:false
        },

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "60%",
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            },
        },
        noData: {
            text: "No Data",
        },

        // dataLabels: {
        //     enabled: true,
        //     offsetY: -20,
        //     style: {
        //         fontSize: "12px",
        //         colors: ["#304758"],
        //     },
        // },
        dataLabels: {
            enabled: true,
            textAnchor: "middle",
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
        stroke: {
            show: true,
            width: 2,
            curve: "smooth"
        },
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

    const tire_lifetime_average = new ApexCharts(
        document.querySelector("#chart-tire-lifetime"),
        optionTireAverage
        // tireoptions
    );
    tire_lifetime_average.render();

    var url = $("#chart-tire-lifetime").data("url");

    $.getJSON(url, (response) => {
        const dynamicMax = Math.max(
            ...response.value.map((item) => Math.max(...item.data))
        );
        tire_lifetime_average.updateSeries(response.value);
        tire_lifetime_average.updateOptions({
            series: response.value,
            yaxis: [
                {
                    seriesName: "KM",
                    title: {
                        text: "KM",
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
                {
                    opposite: true,
                    seriesName: "HM",
                    title: {
                        text: "Hours",
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
                    rotate: -55,
                    rotateAlways: false,
                    // hideOverlappingLabels: false,
                    style: {
                        fontSize: "9px",
                    },
                    maxHeight: 650,
                    trim: false,
                    // height: 440,
                },
                categories: response.xaxis,
                tickPlacement: "on",
            },
        });
    });
}

//consumption model unit
if ($("#chart-tire-consumption-by-model-unit").length > 0) {
    var tire_consumption_by_model_unit = new ApexCharts(
        document.querySelector("#chart-tire-consumption-by-model-unit"),
        tireoptions
    );
    tire_consumption_by_model_unit.render();

    var url = $("#chart-tire-consumption-by-model-unit").data("url");

    $.getJSON(url, function (response) {
        // console.log(response)
        // console.log(response["model"].length)
        let generate_height = generateHeightChart(response["model"].length);
        tire_consumption_by_model_unit.updateSeries();
        tire_consumption_by_model_unit.updateOptions({
            series: [
                {
                    name: "Running",

                    data: response["value"]["running"],
                },
            ],

            xaxis: [
                {
                    // seriesName: '27.00R49',
                    title: {
                        text: "Tire Consumption",
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
            xaxis: {
                labels: {
                    rotate: -30,
                    rotateAlways: true,
                    trim: false,
                    minHeight: 100,
                },
                categories: response["model"],
                tickPlacement: "on",
            },
            // chart: {
            //     height: generate_height,
            // },
            noData: {
                text: "No Data",
            },
        });
    });
}

//tire cost per (hm or km)
if ($("#chart-tire-cost-perhm").length > 0) {
    var tireCostOption = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "bar",
            height: 460,
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
                // columnWidth: "60%",
                dataLabels: {
                    position: "top", // top, center, bottom
                },
            },
        },
        noData: {
            text: "Loading...",
        },
        dataLabels: {
            enabled: true,
            textAnchor: "middle",
            style: {
                fontSize: "10px",
                colors: ["#000"],
            },
            formatter: function (val) {
                return "Rp. " + val;
            },
            offsetX: 28,
            // dropShadow: {
            //     enabled: true,
            // },
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        // xaxis: {},
        xaxis: {
            labels: {
                trim: false,
                minHeight: 100,
            },

            tickPlacement: "on",
        },
        yaxis: {
            show: true,
            showAlways: true,
            labels: {
                show: true,
                // align: 'right',
                trim: false,
                minWidth: 0,
                maxWidth: 400,
                style: {
                    // colors: [],
                    fontSize: "10px",
                    fontFamily: "Helvetica, Arial, sans-serif",
                    fontWeight: 400,
                    cssClass: "apexcharts-yaxis-label",
                },
            },
        },
        fill: {
            opacity: 1,
            // colors: [vihoAdminConfig.primary, vihoAdminConfig.danger],
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
                        return "Rp. " + val;
                    },
                },
            ],
        },
    };

    var tire_cost_per_hm = new ApexCharts(
        document.querySelector("#chart-tire-cost-perhm"),
        tireCostOption
    );
    tire_cost_per_hm.render();

    var url = $("#chart-tire-cost-perhm").data("url");

    $.getJSON(url, function (response) {
        tire_cost_per_hm.updateSeries([
            {
                name: "Cost",
                // type: "bar",
                data: response["value"],
            },
        ]);

        tire_cost_per_hm.updateOptions({
            noData: {
                text: "no Data",
            },
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
                    max: response["max"],
                },
            ],
            xaxis: {
                labels: {
                    rotate: -30,
                    rotateAlways: true,
                    trim: false,
                    minHeight: 100,
                },
                categories: response["model"],
                tickPlacement: "on",
            },
        });
    });

    var tire_cost_per_km = new ApexCharts(
        document.querySelector("#chart-tire-cost-perkm"),
        tireCostOption
    );
    tire_cost_per_km.render();

    var url = $("#chart-tire-cost-perkm").data("url");

    $.getJSON(url, function (response) {
        tire_cost_per_km.updateSeries([
            {
                name: "Cost",
                data: response["value"],
            },
        ]);

        tire_cost_per_km.updateOptions({
            noData: {
                text: "no Data",
            },
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
                    max: response["max"],
                },
            ],
            xaxis: {
                labels: {
                    rotate: -30,
                    rotateAlways: true,
                    trim: false,
                    minHeight: 100,
                },
                categories: response["model"],
                tickPlacement: "on",
            },
        });
    });
}

//tire cost per pattern
if ($("#chart-tire-cost-pattern-by-hm").length > 0) {
    var tireCostPatternOption = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "bar",
            height: 460,
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
                columnWidth: "55%",
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
                return "Rp. " + val;
            },
            offsetX: 20,
            // dropShadow: {
            //     enabled: true,
            // },
        },
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {
            labels: {
                rotate: -30,
                rotateAlways: true,
                trim: false,
                minHeight: 100,
            },
        },

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
                        return "Rp. " + val;
                    },
                },
            ],
        },
    };

    var tire_cost_per_pattern_by_hm = new ApexCharts(
        document.querySelector("#chart-tire-cost-pattern-by-hm"),
        tireCostPatternOption
    );
    tire_cost_per_pattern_by_hm.render();

    var url = $("#chart-tire-cost-pattern-by-hm").data("url");

    $.getJSON(url, function (response) {
        generate_height = generateHeightChart(response["value"].length);
        tire_cost_per_pattern_by_hm.updateSeries([
            {
                name: "Cost",
                data: response["value"],
            },
        ]);

        tire_cost_per_pattern_by_hm.updateOptions({
            noData: {
                text: "no Data",
            },
            chart: {
                height: generate_height,
            },
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
                    max: response["max"],
                },
            ],
            xaxis: {
                labels: {
                    rotate: -30,
                    rotateAlways: true,
                    trim: false,
                },
                categories: response["pattern"],
                tickPlacement: "on",
            },
        });
    });
    var tire_cost_per_pattern_by_km = new ApexCharts(
        document.querySelector("#chart-tire-cost-pattern-by-km"),
        tireCostPatternOption
    );
    tire_cost_per_pattern_by_km.render();
}

if ($("#chart-tire-cost-pattern-by-km").length > 0) {
    var url = $("#chart-tire-cost-pattern-by-km").data("url");

    $.getJSON(url, function (response) {
        generate_height = generateHeightChart(response["value"].length);
        tire_cost_per_pattern_by_km.updateSeries([
            {
                name: "Cost",

                data: response["value"],
            },
        ]);

        tire_cost_per_pattern_by_km.updateOptions({
            noData: {
                text: "no Data",
            },
            chart: {
                height: generate_height,
            },
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
                    max: response["max"],
                },
            ],
            xaxis: {
                labels: {
                    rotate: -30,
                    rotateAlways: true,
                    trim: false,
                    minHeight: 100,
                },
                categories: response["pattern"],
                tickPlacement: "on",
            },
        });
    });
}
