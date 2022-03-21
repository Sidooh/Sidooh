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
                <div class="card-body position-relative" data-chart-name="acc-time-series">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Timeseries</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <fieldset class="col-auto d-none d-sm-flex align-items-center chart-actions"></fieldset>
                    </div>
                    <div id="accounts-time-series-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <div class="card-body position-relative" data-chart-name="acc-cumulative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Cumulative</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <fieldset class="col-auto d-none d-sm-flex align-items-center chart-actions"></fieldset>
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
                <div class="card-body position-relative" data-chart-name="trans-time-series">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Timeseries</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <fieldset class="col-auto d-none d-sm-flex align-items-center chart-actions"></fieldset>
                    </div>
                    <div id="transactions-time-series-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <div class="card-body position-relative" data-chart-name="trans-cumulative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Cumulative</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <fieldset class="col-auto d-none d-sm-flex align-items-center chart-actions"></fieldset>
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
                <div class="card-body position-relative" data-chart-name="rev-time-series">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Timeseries</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <fieldset class="col-auto d-none d-sm-flex align-items-center chart-actions"></fieldset>
                    </div>
                    <div id="revenue-time-series-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <div class="card-body position-relative" data-chart-name="rev-cumulative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Cumulative</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <fieldset class="col-auto d-none d-sm-flex align-items-center chart-actions"></fieldset>
                    </div>
                    <div id="revenue-cumulative-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('vendors/chartisan/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/chartisan/chartisan.umd.js') }}"></script>
    <script src="{{ asset('js/analytics.js') }}"></script>

    <script>
        window.charts = {
            'acc-time-series': new Chartisan({
                el: '#accounts-time-series-chart',
                url: "@chart('time-series.accounts')",
                hooks: new ChartisanHooks()
                    .custom(({data, merge}) => merge(data, mergeOptions()))
                    .responsive()
                    .datasets([
                        {
                            type: 'line', fill: true,
                            backgroundColor: chartGradient([14, 120, 210]),
                            borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                            borderWidth: 2,
                        }
                    ])
            }),
            'acc-cumulative': new Chartisan({
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
                            type: 'line', fill: true,
                            backgroundColor: chartGradient([14, 120, 210]),
                            borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                            borderWidth: 2,
                        }
                    ])
            }),

            'trans-time-series': new Chartisan({
                el: '#transactions-time-series-chart',
                url: "@chart('cumulative.transactions')",
                hooks: new ChartisanHooks()
                    .custom(({data, merge}) => merge(data, mergeOptions()))
                    .responsive()
                    .datasets([
                        {
                            type: 'line', fill: true,
                            backgroundColor: chartGradient([170, 10, 10]),
                            borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                            borderWidth: 2,
                        }
                    ])
            }),
            'trans-cumulative': new Chartisan({
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
                            type: 'line', fill: true,
                            backgroundColor: chartGradient([170, 10, 10]),
                            borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                            borderWidth: 2,
                        }
                    ])
            }),

            'rev-time-series': new Chartisan({
                el: '#revenue-time-series-chart',
                url: "@chart('time-series.revenue')",
                hooks: new ChartisanHooks()
                    .custom(({data, merge}) => merge(data, mergeOptions()))
                    .responsive()
                    .datasets([
                        {
                            type: 'line', fill: true,
                            backgroundColor: chartGradient([115, 232, 49]),
                            borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                            borderWidth: 2,
                        }
                    ])
            }),
            'rev-cumulative': new Chartisan({
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
                            type: 'line', fill: true,
                            backgroundColor: chartGradient([115, 232, 49]),
                            borderColor: localStorage.getItem('theme') === 'dark' ? 'rgba(10, 23, 39, .3)' : 'rgba(255, 255, 255, .7)',
                            borderWidth: 2,
                        }
                    ])
            })
        }
    </script>
@endpush
@endsection
