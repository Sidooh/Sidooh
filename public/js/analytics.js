const mergeOptions = (data, config = {}) => ({
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
                    const label = data.datasets[tooltipItem.datasetIndex].label;

                    if (label.toLowerCase() === 'revenue') {
                        const currency = new Intl.NumberFormat('en-GB', {style: 'currency', currency: 'KES'})
                            .format(tooltipItem.yLabel);
                        return `Amount: ${currency}`;
                    }

                    return `${tooltipItem.yLabel} ${label}`;
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
        },
        ...config
    }
});


/*  ________________________________________________________    DEFINE GLOBALS
* */
const chartActions = $('.chart-actions');


/*  ________________________________________________________    SET UP CHART ACTIONS
* */
const createSelect = className => $(document.createElement('select')).prop({
    name: 'chart_filter',
    class: `form-select form-select-sm me-1 chart-filter ${className}`
});


const actionSelectOptions = [
    {title: 'Today', value: 'today', frequencies: [{title: 'Hourly', value: 'hourly'}]},
    {title: 'Last 7 Days', value: 'last_7_days', frequencies: [{title: 'Daily', value: 'daily'}]},
    {
        title: 'Last 30 Days', value: 'last_30_days', frequencies: [
            {title: 'Daily', value: 'daily'},
            {title: 'Weekly', value: 'weekly'},
        ]
    },
    {
        title: 'Last 3 Months', value: 'last_3_months', frequencies: [
            {title: 'Weekly', value: 'weekly'},
            {title: 'Monthly', value: 'monthly'},
        ]
    },
    {title: 'Last 6 Months', value: 'last_6_months', frequencies: [{title: 'Monthly', value: 'monthly'}]},
    {
        title: 'YTD', value: 'ytd', frequencies: [
            {title: 'Monthly', value: 'monthly'},
            {title: 'Quarterly', value: 'quarterly'},
        ]
    },
];

const periodSelect = createSelect('period')
    .append(actionSelectOptions.map(option => $(document.createElement('option')).prop({
        value: option.value,
        text: option.title,
    })));
const defaultFrequencies = actionSelectOptions.find(opt => opt.value === 'last_30_days').frequencies;
const frequencySelect = createSelect('frequency')
    .append(defaultFrequencies.map(option => $(document.createElement('option')).prop({
        value: option.value,
        text: option.title
    })));

chartActions.append(
    $(document.createElement('button')).prop({
        class: 'btn btn-sm btn-outline-primary me-1 refresh-chart',
        title: 'Update chart'
    }).append($(document.createElement('i')).prop({class: 'fas fa-sync'}))
).append(periodSelect).append(frequencySelect);

/*  ________________________________________________________    UPDATE CHART ON EVENT
* */
const updateChart = chartCardBody => {
    const chartName = chartCardBody.data('chartName');
    const chartInstanceUrl = window.charts[chartName].options.url;

    chartCardBody.find(chartActions).attr('disabled', true);

    const queryString = $.param({
        period: chartCardBody.find($('.period')).val(),
        frequency: chartCardBody.find($('.frequency')).val(),
    });

    window.charts[chartName].update({
        url: `${chartInstanceUrl}?${queryString}`,
    });

    window.charts[chartName].options.url = chartInstanceUrl;

    chartCardBody.find(chartActions).attr('disabled', false);
};

$(document).on('click', '.refresh-chart', function () {
    const chartCardBody = $(this).closest('.card-body.position-relative');

    updateChart(chartCardBody);
});

$(document).on('change', 'select.period', function () {
    const period = this.value;
    const frequencies = actionSelectOptions.find(opt => opt.value === period).frequencies;
    const frequencySelect = this.nextElementSibling;

    $(frequencySelect).html(frequencies.map(option => $(document.createElement('option')).prop({
        value: option.value,
        text: option.title
    })));

    $(frequencySelect).attr('disabled', ['today', 'last_7_days', 'last_6_months'].includes(period));
});

$(document).on('change', '.chart-filter', function () {
    const chartCardBody = $(this).closest('.card-body.position-relative');

    updateChart(chartCardBody);
});


/*  ________________________________________________________    SET DEFAULTS
* */
$(() => {
    const periodSelectElements = document.querySelectorAll('.chart-actions .period');
    const frequencySelectElements = document.querySelectorAll('.chart-actions .frequency');

    periodSelectElements.forEach(element => element.value = 'last_30_days');
    frequencySelectElements.forEach(element => element.value = 'daily');
});
