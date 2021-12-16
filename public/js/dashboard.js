/* -------------------------------------------------------------------------- */
/*                                 Line Chart                                 */
/* -------------------------------------------------------------------------- */

let chartLinePaymentInit = (chartData) => {
    let chartLine = document.getElementById('chart-line');

    if (chartLine) {
        let _document$querySelect;

        let getChartBackground = function getChartBackground(chart) {
            let ctx = chart.getContext('2d');

            if (localStorage.getItem('theme') === 'light') {
                let _gradientFill = ctx.createLinearGradient(0, 0, 0, 250);

                _gradientFill.addColorStop(0, 'rgba(255, 255, 255, 0.3)');

                _gradientFill.addColorStop(1, 'rgba(255, 255, 255, 0)');

                return _gradientFill;
            }

            let gradientFill = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
            gradientFill.addColorStop(0, utils.rgbaColor(utils.getColors().primary, 0.5));
            gradientFill.addColorStop(1, 'transparent');
            return gradientFill;
        };

        let dashboardLineChart = utils.newChart(chartLine, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    borderWidth: 2,
                    data: chartData.datasets,
                    borderColor: localStorage.getItem('theme') === 'dark' ? utils.getColors().primary : utils.settings.chart.borderColor,
                    backgroundColor: getChartBackground(chartLine)
                }]
            },
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    mode: 'x-axis',
                    xPadding: 20,
                    yPadding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function label(tooltipItem) {
                            return "".concat(chartData.labels[tooltipItem.index], " - ").concat(tooltipItem.yLabel, " KES");
                        },
                        title: function title() {
                            return null;
                        }
                    }
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            show: true,
                            labelString: 'Month'
                        },
                        ticks: {
                            fontColor: utils.rgbaColor('#fff', 0.7),
                            fontStyle: 600
                        },
                        gridLines: {
                            color: utils.rgbaColor('#fff', 0.1),
                            zeroLineColor: utils.rgbaColor('#fff', 0.1),
                            lineWidth: 1
                        }
                    }],
                    yAxes: [{
                        display: false
                    }]
                }
            }
        });
        (_document$querySelect = document.querySelector('#dashboard-chart-select')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.addEventListener('change', function (e) {
            let LineDB = {
                all: [4, 1, 6, 2, 7, 12, 4, 6, 5, 4, 5, 10].map(function (d) {
                    return (d * 3.14).toFixed(2);
                }),
                successful: [3, 1, 4, 1, 5, 9, 2, 6, 5, 3, 5, 8].map(function (d) {
                    return (d * 3.14).toFixed(2);
                }),
                failed: [1, 0, 2, 1, 2, 1, 1, 0, 0, 1, 0, 2].map(function (d) {
                    return (d * 3.14).toFixed(2);
                })
            };
            dashboardLineChart.data.datasets[0].data = LineDB[e.target.value];
            dashboardLineChart.update();
        }); // change chart color on theme change

        let changeChartThemeColor = function changeChartThemeColor(borderColor) {
            dashboardLineChart.data.datasets[0].borderColor = borderColor;
            dashboardLineChart.data.datasets[0].backgroundColor = getChartBackground(chartLine);
            dashboardLineChart.update();
        }; // event trigger


        let themeController = document.body;
        themeController.addEventListener('clickControl', function (_ref13) {
            let _ref13$detail = _ref13.detail,
                control = _ref13$detail.control,
                value = _ref13$detail.value;

            if (control === 'theme') {
                if (value === 'dark') {
                    changeChartThemeColor(utils.getColors().primary);
                } else {
                    changeChartThemeColor(utils.settings.chart.borderColor);
                }
            }
        });
    }
};

axios.get(`/admin/charts`).then(({data}) => {
    console.log(data)

    InitCountUp(document.getElementById('total-today'), data.total_today, {prefix: 'KSH.'})
    InitCountUp(document.getElementById('total-yesterday'), data.total_yesterday, {prefix: 'KSH.'})

    chartLinePaymentInit(data.main)
})

$(document).on('click', '.refresh-chart', function () {
    const chartName = $(this).closest('.card-header').siblings().children().first().data('chartName'),
        chartInstance = chart[chartName];

    chartInstance.update()
})
