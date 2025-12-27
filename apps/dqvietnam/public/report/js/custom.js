$(function () {
    var ctx = document.getElementById("barChart").getContext("2d");
    let dataChartPoint = [0, 0, 0, 0, 0, 0, 0, 0];

    dataPoint = JSON.parse(dataPoint);
    Object.keys(dataPoint).map((e, i) => {
        const number = Number(dataPoint[e]);
        if (number >= 80) {
            dataChartPoint[e - 1] = number + (150 - number) / 2 + 10;
        } else if (number >= 60) {
            dataChartPoint[e - 1] = number + (120 - number) / 2 + 10;
        } else if (number >= 40) {
            dataChartPoint[e - 1] = number + (90 - number) / 2 + 10;
        } else {
            dataChartPoint[e - 1] = number + (40 - number) / 2 + 10;
        }
    });


    const pointLink = [
        '/report/detail/1',
        '/report/detail/2',
        '/report/detail/3',
        '/report/detail/4',
        '/report/detail/5',
        '/report/detail/6',
        '/report/detail/7',
        '/report/detail/8',
    ];
    console.log("HIIH", ChartDataLabels)
    const myChart = new Chart(ctx, {
        type: 'radar',
        plugins: [ChartDataLabels],
        data: {
            labels: [['Quản lý thời gian', 'tiếp xúc màn hình'],
                ['Quản lý bắt nạt', 'trên mạng'], ['Quản lý quền', 'riêng tư'],
                ['Danh tính công dân', 'kỹ thuật số'], ['Quản lý', 'anh ninh mạng'],
                ["Quản lý dấu", 'chân kỹ thuật số'],
                ['Tư duy', 'phản biện'], ['Cảm thông', 'kỹ thuật số']],
            datasets: [
                {
                    label: false,
                    data: dataChartPoint,
                    backgroundColor: "rgba(255,255,255,0.17)",
                    borderColor: "rgba(255,255,255,0.83)",
                    pointBackgroundColor: "#fff",
                    borderWidth: 1,
                },
                {
                    label: false,
                    "backgroundColor": "#ee4646",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [60, 60, 60, 60, 60, 60, 60, 60]
                },
                {
                    label: false,
                    "backgroundColor": "#f4773e",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [90, 90, 90, 90, 90, 90, 90, 90]
                },
                {
                    label: false,
                    "backgroundColor": "#f7d155",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [120, 120, 120, 120, 120, 120, 120, 120]
                },
                {
                    label: false,
                    "backgroundColor": "#477ce6",
                    "pointRadius": 0,
                    "borderWidth": 0,
                    lineTension: 0.3,
                    "data": [150, 150, 150, 150, 150, 150, 150, 150]
                }
            ]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {

                    font: {
                        size: 15,
                        family: "\"Roboto\", sans-serif",
                        weight: 500
                    },
                    align: 'end',
                    anchor: 'end',
                    offset: function (context) {
                        var offset = (context.chart.height / 2.5) * ((100 - context.dataset.data[context.dataIndex]) * 0.01);
                        return offset;
                    },
                    formatter: function (value, context) {
                        return context.chart.data.labels[context.dataIndex];
                    },
                    color: function () {
                        return 'transparent';
                    },

                    listeners: {
                        enter: function (context) {
                            context.hovered = true;
                            return true;
                        },
                        leave: function (context) {
                            context.hovered = false;
                            return true;
                        },
                        click: function (context) {
                            var target = context.chart.data.labels[context.dataIndex] + '';
                            target = target.replace(' ', '-').toLowerCase();
                            var fadeSpeed = 150;
                            window.location.href = pointLink[context.dataIndex];
                            return true;
                        }
                    },
                }
            },
            scales: {

                r: {
                    min: 0,
                    max: 150,
                    stepSize: 25,
                    beginAtZero: true,
                    grid: {
                        circular: true,
                        color: "transparent",
                    },
                    ticks: {
                        display: false,
                        stepSize: 30
                    },
                    textStrokeColor: 'rgb(54, 162, 235)',
                    color: 'rgba(240, 240, 240, 0.5)',
                    backdropColor: 'rgb(47, 56, 62)',
                    angleLines: {
                        backgroundColor: 'rgb(255,255,255)',
                    },
                    pointLabels: {
                        color: ["#ee4646", "#f4773e", "#f7d155", "#477ce6"],
                        font: {
                            size: 15,
                            family: "\"Roboto\", sans-serif",
                            weight: 500
                        }
                    },
                },
            },
            title: {
                "display": false
            },
        }
    });

    $('#download_report').on("click", function () {

        let content = document.getElementById('content');

        html2canvas(content, {
            onrendered: function (canvas) {
                var img = canvas.toDataURL("image/png");
                var anchor = document.createElement("a");
                anchor.href = img;
                anchor.download = "report.png";
                anchor.click();
            }
        });
    })

    setTimeout(() => {

    }, 3000)
});
