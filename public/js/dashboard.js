const globalHooks = () => {
    return new ChartisanHooks()
        .responsive()
        .legend({position: 'bottom'})
}

const chartFreqOptions = [
    {title: 'Daily', value: 'daily'},
    {title: 'Weekly', value: 'weekly'},
    {title: 'Monthly', value: 'monthly'},
    {title: 'Yearly', value: 'yearly'},
    {title: 'All time', value: 'all-time'}
];

const chartConfigSelects = () => {
    return `<select name="revenue" class="form-select form-select-sm ms-2" id="chart-freq" aria-label="">`
        + chartFreqOptions.map(opt => {
            return (`<option ${opt.value === 'daily' ? 'selected' : ''} value=${opt.value}>${opt.title}</option>`)
        }) + `
            </select>
`;
}

// $('.chart-config.select').append(chartConfigSelects())

axios.get(`/admin/statistics`).then(({data}) => {
    InitCountUp(document.getElementById('total-today'), data.totalToday, {prefix: 'KSH.'})
    InitCountUp(document.getElementById('total-yesterday'), data.totalYesterday, {prefix: 'KSH.'})
    InitCountUp(document.getElementById('total-accounts'), data.totalAccounts)
    InitCountUp(document.getElementById('total-accounts-today'), data.totalAccountsToday)
    InitCountUp(document.getElementById('total-transactions'), data.totalTransactions)
    InitCountUp(document.getElementById('total-transactions-today'), data.totalTransactionsToday)
    InitCountUp(document.getElementById('total-revenue'), data.totalRevenue)
    InitCountUp(document.getElementById('total-revenue-today'), data.totalRevenueToday)
    InitCountUp(document.getElementById('total-users-today'), data.totalUsersToday)

    //  TODO: uncomment this when ready to handle multiple unnecessary requests.
    const minutes = 7

    // setInterval(() => {
    //     revenueChart.update()
    // }, minutes * 60 * 1000)
})

const updateChart = () => {
    const chartInstanceUrl = revenueChart.options.url

    const queryString = $.param({
        frequency: $('#chart-freq').val(),
        paymentStatus: $('#chart-status').val()
    });

    revenueChart.update({
        url: `${chartInstanceUrl}?${queryString}`,
    })

    revenueChart.options.url = chartInstanceUrl
}

$(document).on('click', '.refresh-chart', updateChart)
$(document).on('change', '#chart-freq', updateChart)
$(document).on('change', '#chart-status', updateChart)
