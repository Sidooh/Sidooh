const mergeOptions = (config = {}) => ({
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
                label: (tooltipItem, data) => {
                    return `${data.datasets[tooltipItem.datasetIndex].label} - @KES ${tooltipItem.yLabel}`;
                }
            }
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [
                {
                    scaleLabel: {
                        show: true,
                        labelString: 'Month'
                    },
                    ticks: {
                        fontColor: utils.rgbaColor('#000', 0.7),
                        fontStyle: 600
                    },
                    gridLines: {
                        color: utils.rgbaColor('rgb(44, 123, 229)', 0.1),
                        zeroLineColor: utils.rgbaColor('#000', 0.1),
                        lineWidth: 1
                    }
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        }
    }
});


/*  ________________________________________________________    SET UP CHART ACTIONS
* */
const createSelect = () => $(document.createElement('select')).prop({
    name: 'pets',
    class: 'form-select form-select-sm me-1 chart-filter'
});
const createOptions = option => $(document.createElement('option')).prop({
    value: option,
    text: option.charAt(0).toUpperCase() + option.slice(1)
});

const periodSelectOptions = [
    'Today', 'Last 7 Days', 'Last 30 Days', 'Last 3 Months', 'Last 6 Months', 'YTD'
].map(createOptions);
const frequencySelectOptions = ['Daily', 'Weekly', 'Monthly', 'Quarterly'].map(createOptions);

const periodSelect = createSelect().append(periodSelectOptions);
const frequencySelect = createSelect().append(frequencySelectOptions);

$('.chart-actions').append(
    $(document.createElement('button')).prop({
        class: 'btn btn-sm btn-outline-primary me-1 refresh-chart',
        title: 'Update chart'
    }).append($(document.createElement('i')).prop({class: 'fas fa-sync'}))
).append(periodSelect).append(frequencySelect);


/*  ________________________________________________________    UPDATE CHART ON EVENT
* */
$(document).on('click', '.refresh-chart', function () {
    const chartName = $(this).closest('.card-body.position-relative').data('chartName');

    window.charts[chartName].update();
});

$(document).on('change', '.chart-filter', function () {
    const chartCardBody = $(this).closest('.card-body.position-relative');
    const chartName = chartCardBody.data('chartName'),
        chartInstance = chart[chartName],
        chartInstanceUrl = chartInstance.options.url;

    chartInstance.update({
        url: `${chartInstanceUrl}?frequency=${$(this).val()}`,
    });

    chartInstance.options.url = chartInstanceUrl;
});
