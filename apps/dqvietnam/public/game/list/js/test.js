var ctx = $("#myChart");

var colors = {
    red: "#DF3312",
    black: "#232F3E",
};

var chart = new Chart(ctx, {
    type: "radar",
    data: {
        labels: ["Leadership", "Business Case", "Consensus", "Accountability", "Urgency", "Importance", "Capability"],
        datasets: [{
            label: false,
            data: [65, 59, 90, 81, 56, 55, 40],
            fill: false,
            pointRadius: 4,
            backgroundColor: colors.red,
            borderColor: colors.red,
            pointBackgroundColor: colors.red,
            pointBorderColor: "transparent",
            pointHoverBackgroundColor: colors.red,
            pointHoverBorderColor: colors.red,
        }]
    },
    options: {
        plugins: {
            datalabels: {
                color: function (context) {
                    return context.hovered ? colors.red : colors.black;
                },
                font: {
                    family: 'Amazon Ember',
                    size: 13,
                    style: 'normal'
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
                        $('.info.active').fadeOut(fadeSpeed, function () {
                            $('.info.active').removeClass('active');
                            $('#' + target).fadeIn(fadeSpeed, function () {
                                $('#' + target).addClass('active');
                            });
                        });
                        return true;
                    }
                },
            }
        },
        legend: {
            display: false
        },

        scale: {
            angleLines: {
                display: true,
                color: colors.black,
                lineWidth: 1,
            },
            gridLines: {
                lineWidth: 1,
                color: colors.black,
            },
            pointLabels: {
                display: false,
                fontColor: colors.black,
                fontFamily: 'Amazon Ember',
                fontSize: 14,
                callback: function (label) {
                    return label;
                },
            },
            ticks: {
                display: false,		// toggle this on hover!
                fontColor: colors.red,
                fontFamily: 'Amazon Ember',
                fontSize: 14,
                backdropPaddingX: 0,
                backdropPaddingY: 0,
                beginAtZero: true,
                min: 0,
                max: 100,
                stepSize: 20,
                showLabelBackdrop: false,
            },
        },
        elements: {
            line: {
                tension: 0,
                borderWidth: 1
            }
        },
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 30,
                right: 30,
                top: 30,
                bottom: 30
            }
        }
    },
});
