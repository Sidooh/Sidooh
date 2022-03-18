@extends('admin.layouts.app')
@section('content')

    <div class="row g-3 mb-3">
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-1.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Today</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-light me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="revenue-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card rounded-3 overflow-hidden mb-3">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-1.png') }} );"></div>
                <div class="card-body position-relative">
                    <div class="row align-items-center g-0">
                        <div class="col light">
                            <h4 class=" mb-0">Today</h4>
                            <p class="fs--1 fw-semi-bold ">Yesterday</p>
                        </div>
                        <div class="col-auto d-none d-sm-flex align-items-center chart-config select">
                            <button class="btn btn-sm btn-outline-light me-2 refresh-chart" type="button" title="Update Chart">
                                <i class="fas fa-sync"></i>
                            </button>
                            <select class="form-select form-select-sm" id="chart-status" aria-label="">
                                <option value="successful" selected="selected">Successful Payments</option>
                                <option value="other">Other Payments</option>
                            </select>
                        </div>
                    </div>
                    <div id="revenue-chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="{{ asset('vendors/chartisan/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/chartisan/chartisan.umd.js') }}"></script>

    <script>
        const revenueChart = new Chartisan({
            el: '#revenue-chart',
            url: "@chart('revenue')",
            hooks: new ChartisanHooks()
                .custom(({data, merge, server}) => {
                    return merge(data, {
                        data: {
                            datasets: [{
                                borderColor: localStorage.getItem('theme') === 'dark' ? utils.getColors().primary : utils.settings.chart.borderColor,
                                borderWidth: 2,
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
                })
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([44, 123, 229]),
                        borderColor: localStorage.getItem('theme') === 'dark' ? utils.getColors().primary : utils.settings.chart.borderColor,
                        borderWidth: 2,
                    }, {
                        label: 'yesterday',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([170, 10, 10]),
                        borderColor: `rgb(170, 10, 10)`,
                        borderWidth: 2,
                    }
                ])
        });
    </script>
@endpush
@endsection
