if ($("#chart-tire-new-movement").length > 0) {
    const tireInjuryOptions = {
        series: [], 
        legend: {
            position: "top",
        },
        chart: {
            type: "bar",
            height: 460,
            stacked: true,
        },
        plotOptions: {
            bar: {
                horizontal: false, 
                columnWidth: "55%",
            },
        },
        noData: {
            text: "Loading...",
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ["#000"],
            },
            formatter: function (value, { seriesIndex, dataPointIndex, w }) {
                return w.config.series[seriesIndex].data[dataPointIndex] || 0;
            },
        },
        xaxis: {
            categories: [], 
            title: {
                text: "Units",
            },
        },
        yaxis: {
            title: {
                text: "Total Usage per Month",
            },
        },
        fill: {
            opacity: 1,
            type: "gradient",
            gradient: {
                shade: "light",
                type: "vertical",
                shadeIntensity: 0.4,
                opacityFrom: 0.9,
                opacityTo: 0.8,
                stops: [0, 100],
            },
        },
        tooltip: {
            shared: true,
            y: {
                formatter: function (val) {
                    return val;
                },
            },
        },
    };

    const tire_scrap_injury = new ApexCharts(
        document.querySelector("#chart-tire-new-movement"),
        tireInjuryOptions
    );
    tire_scrap_injury.render();

    const url = $("#chart-tire-new-movement").data("url");

    $.getJSON(url, (response) => {
        tire_scrap_injury.updateOptions({
            series: response.data,
            xaxis: {
                categories: response.xaxis, 
            },
            noData: {
                text: "No Data",
            },
        });
    });
}
