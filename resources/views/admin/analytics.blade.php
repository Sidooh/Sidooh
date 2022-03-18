@extends('admin.layouts.app')
@section('content')

    <div class="row g-3 mb-3">
        <div class="col-12 position-relative mt-4">
            <hr class="bg-300"/>
            <div class="divider-content-center bg-body fs-2">Accounts</div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-1.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Timeseries</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-primary me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="accounts-time-series-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Cumulative</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-primary me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="accounts-cumulative-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 position-relative mt-4">
            <hr class="bg-300"/>
            <div class="divider-content-center bg-body fs-2">Transactions</div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-1.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Timeseries</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-primary me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="transactions-time-series-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Cumulative</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-primary me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="transactions-cumulative-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 position-relative mt-4">
            <hr class="bg-300"/>
            <div class="divider-content-center bg-body fs-2">Revenue</div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-1.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Timeseries</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-primary me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="revenue-time-series-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Cumulative</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-primary me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="revenue-cumulative-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('vendors/chartisan/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/chartisan/chartisan.umd.js') }}"></script>

    <script>
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
                    xAxes: [{
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
                    }],
                    yAxes: [{
                        display: false
                    }]
                }
            }
        })

        const accountsTimeSeriesChart = new Chartisan({
            el: '#accounts-time-series-chart',
            url: "@chart('time-series.accounts')",
            hooks: new ChartisanHooks()
                .custom(({data, merge}) => merge(data, mergeOptions()))
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([14, 120, 210]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                        borderWidth: 2,
                    }
                ])
        });

        const accountsCumulativeChart = new Chartisan({
            el: '#accounts-cumulative-chart',
            url: "@chart('cumulative.accounts')",
            hooks: new ChartisanHooks()
                .custom(({data, merge}) => {
                    const timeSeries = data.data.datasets[0].data
                    data.data.datasets[0].data = timeSeries.reduce((a, b, i) => i === 0 ? [b] : [...a, b + a[i - 1]], []);

                    return merge(data, mergeOptions())
                })
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([14, 120, 210]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                        borderWidth: 2,
                    }
                ])
        });

        const transactionsTimeSeriesChart = new Chartisan({
            el: '#transactions-time-series-chart',
            url: "@chart('cumulative.transactions')",
            hooks: new ChartisanHooks()
                .custom(({data, merge}) => merge(data, mergeOptions()))
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([170, 10, 10]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                        borderWidth: 2,
                    }
                ])
        });

        const transactionsCumulativeChart = new Chartisan({
            el: '#transactions-cumulative-chart',
            url: "@chart('cumulative.transactions')",
            hooks: new ChartisanHooks()
                .custom(({data, merge}) => {
                    const timeSeries = data.data.datasets[0].data
                    data.data.datasets[0].data = timeSeries.reduce((a, b, i) => i === 0 ? [b] : [...a, b + a[i - 1]], []);

                    return merge(data, mergeOptions())
                })
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([170, 10, 10]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                        borderWidth: 2,
                    }
                ])
        });

        const revenueTimeSeriesChart = new Chartisan({
            el: '#revenue-time-series-chart',
            url: "@chart('time-series.revenue')",
            hooks: new ChartisanHooks()
                .custom(({data, merge}) => merge(data, mergeOptions()))
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([115, 232, 49]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                        borderWidth: 2,
                    }
                ])
        });

        const revenueCumulativeChart = new Chartisan({
            el: '#revenue-cumulative-chart',
            url: "@chart('cumulative.revenue')",
            hooks: new ChartisanHooks()
                .custom(({data, merge}) => {
                    const timeSeries = data.data.datasets[0].data
                    data.data.datasets[0].data = timeSeries.reduce((a, b, i) => i === 0 ? [b] : [...a, b + a[i - 1]], []);

                    return merge(data, mergeOptions())
                })
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([115, 232, 49]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                        borderWidth: 2,
                    }
                ])
        });
    </script>
@endpush
@endsection
