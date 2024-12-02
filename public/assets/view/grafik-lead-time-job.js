if ($("#chart-lead-time-job").length > 0) {
    const leadTimeOptions = {
        series: [],
        legend: {
            position: "top",
        },
        chart: {
            type: "bar",
            height: 690,
            stacked: false,  // Pastikan grafik tidak bertumpukan
        },
        plotOptions: {
            bar: {
                horizontal: true,  // Grafik horizontal (jangan diubah setelah inisialisasi)
                columnWidth: "50%",  // Lebar kolom lebih tebal agar grafik lebih jelas
                borderRadius: 10, // Optional: membuat sudut kolom lebih halus
                borderWidth: 2, // Menambahkan border di sekitar kolom agar lebih tebal
            },
        },
        noData: {
            text: "Loading...",
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ["#000"],
                // fontSize: "12px", // Ukuran font yang lebih besar agar angka terlihat jelas
            },
            formatter: function (value, { seriesIndex, dataPointIndex, w }) {
                const timeInSeconds = w.config.series[seriesIndex].data[dataPointIndex];
                return formatTime(timeInSeconds * 1000); // Format ke menit:detik:milidetik
            },
            dropShadow: {
                enabled: false,
                top: 1,
                left: 1,
                blur: 3,
                opacity: 0.4,
            },
            offsetX: 50, // Jarak label ke kanan dari kolom
            offsetY: 0,  // Mengatur jarak vertikal label agar lebih rapat
        },
        xaxis: {
            title: {
                text: "Time (Minutes)", // Mengganti sumbu X untuk waktu (menit)
            },
            labels: {
                formatter: function (value) {
                    return formatTime(value * 1000);  // Format waktu menjadi menit:detik:milidetik
                }
            },
        },
        yaxis: {
            categories: [], // Ini akan diisi dengan nama bulan
            title: {
                text: "Month", // Mengganti sumbu Y untuk bulan
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
                    return formatTime(val * 1000);  // Format waktu di tooltip menjadi menit:detik:milidetik
                },
            },
        },
    };

    const leadTimeChart = new ApexCharts(
        document.querySelector("#chart-lead-time-job"),
        leadTimeOptions
    );
    leadTimeChart.render();

    const url = $("#chart-lead-time-job").data("url");

    // Ambil data dari URL yang diberikan
    $.getJSON(url, (response) => {
        // Convert total time (dalam detik) menjadi menit
        const totalMinutesData = response.data[0].data.map(timeInSeconds => timeInSeconds / 60);

        // Convert average time (dalam detik) menjadi menit
        const averageMinutesData = response.data[1].data.map(timeInSeconds => timeInSeconds / 60);

        leadTimeChart.updateOptions({
            series: [
                { name: 'Total Time (minutes)', data: totalMinutesData },
                { name: 'Average Time (minutes)', data: averageMinutesData }
            ],
            xaxis: {
                categories: response.xaxis, // Bulan yang diambil dari server
            },
            noData: {
                text: "No Data", // Pesan jika tidak ada data
            },
        });
    });

    // Fungsi untuk memformat waktu (milidetik) menjadi menit:detik:milidetik tanpa koma
    function formatTime(milliseconds) {
        const minutes = Math.floor(milliseconds / 60000); // Mengambil menit
        const seconds = Math.floor((milliseconds % 60000) / 1000); // Mengambil detik
        const millisecondsLeft = Math.floor(milliseconds % 1000); // Mengambil milidetik

        // Format waktu dalam bentuk "menit:detik:milidetik" dengan 2 digit untuk milidetik
        return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(millisecondsLeft).padStart(2, '0')}`;
    }
}
