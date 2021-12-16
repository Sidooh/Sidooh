@extends('admin.layouts.app')

@section('content')
    <?php
    function statusPill(string $status): array {
        return match (strtolower($status)) {
            'complete', 'completed', 'success' => [
                'icon'  => 'check',
                'color' => 'success'
            ],
            'failed' => [
                'icon'  => 'ban',
                'color' => 'warning'
            ],
            'pending' => [
                'icon'  => 'redo',
                'color' => 'primary'
            ],
            default => [
                'icon'  => 'stream',
                'color' => 'secondary'
            ]
        };
    }
    ?>

    {{--    <div class="card shadow-lg">--}}
    {{--        <div class="card-header d-flex justify-content-between">--}}
    {{--            <h5>Revenue</h5>--}}
    {{--            <div class="chart-config select d-flex align-items-center"></div>--}}
    {{--        </div>--}}
    {{--        <div class="card-body">--}}
    {{--            <div data-chart-name="revenue" id="revenue-chart" style="height: 300px;"></div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="card rounded-3 overflow-hidden mb-3">
        <div class="card-body bg-line-chart-gradient">
            <div class="row align-items-center g-0">
                <div class="col light">
                    <h4 class="text-white mb-0">Today <span id="total-today">0</span></h4>
                    <p class="fs--1 fw-semi-bold text-white">
                        Yesterday <span id="total-yesterday" class="opacity-50">0</span>
                    </p>
                </div>
                <div class="col-auto d-none d-sm-flex align-items-center">
                    <button class="btn btn-sm btn-outline-light me-2 refresh-chart" type="button" title="Update Chart">
                        <i class="fas fa-sync"></i>
                    </button>
                    <select class="form-select form-select-sm" id="dashboard-chart-select" aria-label="">
                        <option value="all">All Payments</option>
                        <option value="successful" selected="selected">Successful Payments</option>
                        <option value="failed">Failed Payments</option>
                    </select>
                </div>
            </div>
            <div id="revenue-chart" style="height: 250px;"></div>
        </div>
    </div>

    {{--<div class="card rounded-3 overflow-hidden mb-3">
        <div class="card-body bg-line-chart-gradient">
            <div class="row align-items-center g-0">
                <div class="col light">
                    <h4 class="text-white mb-0">Today <span id="total-today">0</span></h4>
                    <p class="fs--1 fw-semi-bold text-white">
                        Yesterday <span id="total-yesterday" class="opacity-50">0</span>
                    </p>
                </div>
                <div class="col-auto d-none d-sm-flex align-items-center">
                    <button class="btn btn-sm btn-outline-light me-2 refresh-chart" type="button" title="Update Chart">
                        <i class="fas fa-sync"></i>
                    </button>
                    <select class="form-select form-select-sm" id="dashboard-chart-select" aria-label="">
                        <option value="all">All Payments</option>
                        <option value="successful" selected="selected">Successful Payments</option>
                        <option value="failed">Failed Payments</option>
                    </select>
                </div>
            </div>
            <canvas class="mw-100 rounded" id="chart-line" width="1618" height="375" aria-label="Line chart"
                    role="img"></canvas>
        </div>
    </div>--}}
    {{--    <div class="card bg-light mb-3">--}}
    {{--        <div class="card-body p-3">--}}
    {{--            <p class="fs--1 mb-0"><a href="javascript:void(0)><span class="fas fa-exchange-alt me-2"--}}
    {{--                                                     data-fa-transform="rotate-90"></span>A payout for--}}
    {{--                    <strong>$921.42 </strong>was deposited 13 days ago</a>. Your next deposit is expected on <strong>Tuesday,--}}
    {{--                    March 13.</strong></p>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-1.png') }} );"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Accounts<span
                            class="badge badge-soft-warning rounded-pill ms-2" id="total-accounts-today">0</span>
                    </h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" id="total-accounts">0</div>
                    <a class="fw-semi-bold fs--1 text-nowrap" href="{{ route('admin.accounts.index') }}">See all<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-2.png') }} );"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Transactions
                        <span class="badge badge-soft-info rounded-pill ms-2" id="total-transactions-today">0</span>
                    </h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" id="total-transactions">0</div>
                    <a class="fw-semi-bold fs--1 text-nowrap" href="{{ route('admin.transactions.index', ['all']) }}">All
                        transactions<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('images/icons/spot-illustrations/corner-3.png') }} );"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>
                        Revenue <span class="badge badge-soft-success rounded-pill ms-2" id="total-revenue-today">0</span>
                    </h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif" id="total-revenue">0</div>
                    <a class="fw-semi-bold fs--1 text-nowrap" href="#">Statistics<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3" id="pendingTransactionsTable"
         data-list='{"valueNames":["name","phone","product","amount","payment","status","Date"],"page":8,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Pending Transactions</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div class="d-none" id="table-purchases-actions">
                        <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                                <option selected="">Bulk actions</option>
                                <option value="Refund">Refund</option>
                                <option value="Delete">Delete</option>
                                <option value="Archive">Archive</option>
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
                        </div>
                    </div>
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" onclick="window.location.reload()">
                            <span class="fas fa-reload"
                                  data-fa-transform="shrink-3 down-2"></span>
                            <span
                                class="d-none d-sm-inline-block ms-1">Refresh</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm fs--1 mb-0 overflow-hidden">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>
                            <div class="form-check mb-0 d-flex align-items-center">
                                <input class="form-check-input" aria-label
                                       id="checkbox-bulk-purchases-select"
                                       type="checkbox"
                                       data-bulk-select='{"body":"table-purchase-body","actions":"table-purchases-actions","replacedElement":"table-purchases-replace-element"}'/>
                            </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Customer</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">Phone</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="product">Product</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Amount</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="payment">Payment
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="date">Date</th>
                        <th class="no-sort pe-1 align-middle data-table-row-action"></th>
                    </tr>
                    </thead>
                    <tbody class="list" id="table-purchase-body">
                    @foreach($data['pendingTransactions'] as $transaction)
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle" style="width: 28px;">
                                <div class="form-check mb-0 d-flex align-items-center">
                                    <input class="form-check-input" aria-label
                                           type="checkbox"
                                           id="recent-purchase-{{ $transaction->id }}"
                                           data-bulk-select-row="data-bulk-select-row"/>
                                </div>
                            </td>
                            <th class="align-middle white-space-nowrap name">
                                <a href="{{ $transaction->account->user ? route('admin.users.show', $transaction->account->user ) : route('admin.accounts.show', $transaction->account ) }}">{{ $transaction->account->user ? $transaction->account->user->name : $transaction->account->phone }}</a>
                            </th>
                            <td class="align-middle white-space-nowrap phone">
                                <a href="{{ route('admin.accounts.show', $transaction->account ) }}">{{ $transaction->account->phone }}</a>
                            </td>
                            <td class="align-middle white-space-nowrap product">
                                <a href="{{ route('admin.transactions.show', $transaction ) }}">{{ $transaction->description }}</a>
                            </td>
                            <td class="align-middle text-end amount">{{ format_cur($transaction->amount) }}</td>

                            <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                @if($transaction->payment)
                                    <?php
                                    $payment = statusPill($transaction->payment->status)
                                    ?>

                                    <span class="badge badge rounded-pill d-block badge-soft-{{ $payment['color'] }}">
										<?= ucwords($transaction->payment->status) ?>
										<span class="ms-1 fas fa-{{ $payment['icon'] }}"
                                              data-fa-transform="shrink-2"></span>
									</span>

                                @endif
                            </td>
                            <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                <?php
                                $status = statusPill($transaction->status)
                                ?>

                                <span class="badge badge rounded-pill d-block badge-soft-{{ $status['color'] }}">
                                    <?= ucwords($transaction->status) ?>
                                    <span class="ms-1 fas fa-{{ $status['icon'] }}"
                                          data-fa-transform="shrink-2"></span>
                                </span>
                            </td>
                            <td class="align-middle text-end date">{{ local_date($transaction->updated_at, 'd/m/Y H:i') }}</td>

                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown font-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                                            type="button" id="dropdown0" data-bs-toggle="dropdown"
                                            data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                            class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-2"
                                         aria-labelledby="dropdown0">
                                        <a class="dropdown-item"
                                           href="{{ route('admin.transactions.show', $transaction) }}">View</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        <a
                                            class="dropdown-item" href="javascript:void(0)">Refund</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-warning" href="javascript:void(0)">Archive</a><a
                                            class="dropdown-item text-danger" href="javascript:void(0)">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="pagination d-none"></div>
                <div class="col">
                    <p class="mb-0 fs--1">
                        <span class="d-none d-sm-inline-block me-2"
                              data-list-info="data-list-info"> </span>
                        <span
                            class="d-none d-sm-inline-block me-2">&mdash;  </span>
                        <a class="fw-semi-bold" href="javascript:void(0)"
                           data-list-view="*">View all
                            <span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                        </a>
                        {{--                        TODO: Find a way to collapse as well --}}
                        {{--                        <a class="fw-semi-bold" href="javascript:void(0)--}}
                        {{--                           data-list-view="10">--}}
                        {{--                            <span class="fas fa-angle-left ms-1" data-fa-transform="down-1"></span>--}}
                        {{--                            Collapse--}}
                        {{--                        </a>--}}
                    </p>
                </div>
                <div class="col-auto d-flex">
                    <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev">
                        <span>Previous</span></button>
                    <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3" id="recentPurchaseTable"
         data-list='{"valueNames":["name","phone","product","amount","payment","status","Date"],"page":8,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Recent Transactions</h5>
                </div>
                <div class="col-6 col-sm-auto ms-auto text-end ps-0">
                    <div class="d-none" id="table-purchases-actions">
                        <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                                <option selected="">Bulk actions</option>
                                <option value="Refund">Refund</option>
                                <option value="Delete">Delete</option>
                                <option value="Archive">Archive</option>
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
                        </div>
                    </div>
                    <div id="table-purchases-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button" onclick="window.location.reload()">
                            <span class="fas fa-reload"
                                  data-fa-transform="shrink-3 down-2"></span>
                            <span
                                class="d-none d-sm-inline-block ms-1">Refresh</span>
                        </button>
                        {{--                        <button class="btn btn-falcon-default btn-sm" type="button">--}}
                        {{--                            <span class="fas fa-plus"--}}
                        {{--                                  data-fa-transform="shrink-3 down-2"></span>--}}
                        {{--                            <span--}}
                        {{--                                class="d-none d-sm-inline-block ms-1">New</span>--}}
                        {{--                        </button>--}}
                        {{--                        <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter"--}}
                        {{--                                                                                               data-fa-transform="shrink-3 down-2"></span><span--}}
                        {{--                                class="d-none d-sm-inline-block ms-1">Filter</span></button>--}}
                        {{--                        <button class="btn btn-falcon-default btn-sm" type="button"><span--}}
                        {{--                                class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span--}}
                        {{--                                class="d-none d-sm-inline-block ms-1">Export</span></button>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 py-0">
            <div class="table-responsive scrollbar">
                <table class="table table-sm fs--1 mb-0 overflow-hidden">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>
                            <div class="form-check mb-0 d-flex align-items-center">
                                <input class="form-check-input" aria-label
                                       id="checkbox-bulk-purchases-select"
                                       type="checkbox"
                                       data-bulk-select='{"body":"table-purchase-body","actions":"table-purchases-actions","replacedElement":"table-purchases-replace-element"}'/>
                            </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Customer</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">Phone</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="product">Product</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Amount</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="payment">Payment
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="date">Date</th>
                        <th class="no-sort pe-1 align-middle data-table-row-action"></th>
                    </tr>
                    </thead>
                    <tbody class="list" id="table-purchase-body">
                    @foreach($data['recentTransactions'] as $transaction)

                        <tr class="btn-reveal-trigger">
                            <td class="align-middle" style="width: 28px;">
                                <div class="form-check mb-0 d-flex align-items-center">
                                    <input class="form-check-input" aria-label
                                           type="checkbox"
                                           id="recent-purchase-{{ $transaction->id }}"
                                           data-bulk-select-row="data-bulk-select-row"/>
                                </div>
                            </td>
                            <th class="align-middle white-space-nowrap name">
                                <a href="{{ $transaction->account->user ? route('admin.users.show', $transaction->account->user ) : route('admin.accounts.show', $transaction->account ) }}">{{ $transaction->account->user ? $transaction->account->user->name : $transaction->account->phone }}</a>
                            </th>
                            <td class="align-middle white-space-nowrap phone">
                                <a href="{{ route('admin.accounts.show', $transaction->account ) }}">{{ $transaction->account->phone }}</a>
                            </td>
                            <td class="align-middle white-space-nowrap product">
                                <a href="{{ route('admin.transactions.show', $transaction ) }}">{{ $transaction->description }}</a>
                            </td>
                            <td class="align-middle text-end amount">{{ format_cur($transaction->amount) }}</td>

                            <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                @if($transaction->payment)
                                    <?php
                                    $payment = statusPill($transaction->payment->status)
                                    ?>

                                    <span class="badge badge rounded-pill d-block badge-soft-{{ $payment['color'] }}">
										<?= ucwords($transaction->payment->status) ?>
										<span class="ms-1 fas fa-{{ $payment['icon'] }}"
                                              data-fa-transform="shrink-2"></span>
									</span>

                                @endif
                            </td>
                            <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                <?php
                                $status = statusPill($transaction->status)
                                ?>

                                <span class="badge badge rounded-pill d-block badge-soft-{{ $status['color'] }}">
                                    <?= ucwords($transaction->status) ?>
                                    <span class="ms-1 fas fa-{{ $status['icon'] }}"
                                          data-fa-transform="shrink-2"></span>
                                </span>
                            </td>
                            <td class="align-middle text-end date">{{ local_date($transaction->updated_at, 'd/m/Y H:i') }}</td>

                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown font-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                                            type="button" id="dropdown0" data-bs-toggle="dropdown"
                                            data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                            class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-2"
                                         aria-labelledby="dropdown0">
                                        <a class="dropdown-item"
                                           href="{{ route('admin.transactions.show', $transaction ) }}">View</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0)">Refund</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-warning" href="javascript:void(0)">Archive</a>
                                        <a class="dropdown-item text-danger" href="javascript:void(0)">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="pagination d-none"></div>
                <div class="col">
                    <p class="mb-0 fs--1">
                        <span class="d-none d-sm-inline-block me-2"
                              data-list-info="data-list-info"> </span>
                        <span
                            class="d-none d-sm-inline-block me-2">&mdash;  </span>
                        <a class="fw-semi-bold" href="javascript:void(0)"
                           data-list-view="*">View all
                            <span
                                class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                        </a>
                        {{--                        TODO: Find a way to collapse as well --}}
                        {{--                        <a class="fw-semi-bold" href="javascript:void(0)--}}
                        {{--                           data-list-view="10">--}}
                        {{--                            <span class="fas fa-angle-left ms-1" data-fa-transform="down-1"></span>--}}
                        {{--                            Collapse--}}
                        {{--                        </a>--}}
                    </p>
                </div>
                <div class="col-auto d-flex">
                    <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev">
                        <span>Previous</span></button>
                    <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-4 pe-lg-2">
            <div class="card h-100 bg-line-chart-gradient">
                <div class="card-header bg-transparent light">
                    <h5 class="text-white">Total Users Today</h5>
                    <div class="real-time-user display-1 fw-normal text-white" id="total-users-today">0</div>
                </div>
                {{--                <div class="card-body text-white fs--1 light">--}}
                {{--                    <p class="border-bottom pb-2" style="border-color: rgba(255, 255, 255, 0.15) !important">Page views--}}
                {{--                        per second</p>--}}
                {{--                    <canvas class="max-w-100" id="real-time-user" width="10" height="4"></canvas>--}}
                {{--                    <div class="list-group-flush mt-4">--}}
                {{--                        <div--}}
                {{--                            class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1 fw-semi-bold border-top-0"--}}
                {{--                            style="border-color: rgba(255, 255, 255, 0.15)">--}}
                {{--                            <p class="mb-0">Top Active Pages</p>--}}
                {{--                            <p class="mb-0">Active Users</p>--}}
                {{--                        </div>--}}
                {{--                        <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1"--}}
                {{--                             style="border-color: rgba(255, 255, 255, 0.05)">--}}
                {{--                            <p class="mb-0">/bootstrap-themes/</p>--}}
                {{--                            <p class="mb-0">3</p>--}}
                {{--                        </div>--}}
                {{--                        <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1"--}}
                {{--                             style="border-color: rgba(255, 255, 255, 0.05)">--}}
                {{--                            <p class="mb-0">/tags/html5/</p>--}}
                {{--                            <p class="mb-0">3</p>--}}
                {{--                        </div>--}}
                {{--                        <div class="list-group-item bg-transparent d-xxl-flex justify-content-between px-0 py-1 d-none"--}}
                {{--                             style="border-color: rgba(255, 255, 255, 0.05)">--}}
                {{--                            <p class="mb-0">/</p>--}}
                {{--                            <p class="mb-0">2</p>--}}
                {{--                        </div>--}}
                {{--                        <div class="list-group-item bg-transparent d-xxl-flex justify-content-between px-0 py-1 d-none"--}}
                {{--                             style="border-color: rgba(255, 255, 255, 0.05)">--}}
                {{--                            <p class="mb-0">/preview/falcon/dashboard/</p>--}}
                {{--                            <p class="mb-0">2</p>--}}
                {{--                        </div>--}}
                {{--                        <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-1"--}}
                {{--                             style="border-color: rgba(255, 255, 255, 0.05)">--}}
                {{--                            <p class="mb-0">/100-best-themes...all-time/</p>--}}
                {{--                            <p class="mb-0">1</p>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="card-footer text-end bg-transparent border-top light"--}}
                {{--                     style="border-color: rgba(255, 255, 255, 0.15) !important"><a class="text-white" href="javascript:void(0)>Real-time--}}
                {{--                        report<span class="fa fa-chevron-right ms-1 fs--1"></span></a></div>--}}
            </div>
        </div>
        <div class="col-lg-8 ps-lg-2">
            {{--            <div class="card h-100 mt-3 mt-lg-0">--}}
            {{--                <div class="card-header bg-light d-flex flex-between-center">--}}
            {{--                    <h5 class="mb-0">Active users</h5>--}}
            {{--                    <div class="dropdown font-sans-serif btn-reveal-trigger">--}}
            {{--                        <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"--}}
            {{--                                type="button" id="modules" data-bs-toggle="dropdown" data-boundary="viewport"--}}
            {{--                                aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span>--}}
            {{--                        </button>--}}
            {{--                        <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="modules"><a--}}
            {{--                                class="dropdown-item" href="javascript:void(0)>Edit</a><a class="dropdown-item" href="javascript:void(0)>Move</a><a--}}
            {{--                                class="dropdown-item" href="javascript:void(0)>Resize</a>--}}
            {{--                            <div class="dropdown-divider"></div>--}}
            {{--                            <a class="dropdown-item text-warning" href="javascript:void(0)>Archive</a><a--}}
            {{--                                class="dropdown-item text-danger" href="javascript:void(0)>Delete</a>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--                <div class="card-body h-100 p-0">--}}
            {{--                    <div class="h-100 bg-white" id="map" style="min-height: 300px;"></div>--}}
            {{--                </div>--}}
            {{--                <div class="card-footer bg-light">--}}
            {{--                    <div class="row justify-content-between">--}}
            {{--                        <div class="col-auto"><select class="form-select form-select-sm">--}}
            {{--                                <option value="week" selected="selected">Last 7 days</option>--}}
            {{--                                <option value="month">Last month</option>--}}
            {{--                                <option value="year">Last year</option>--}}
            {{--                            </select></div>--}}
            {{--                        <div class="col-auto"><a class="btn btn-falcon-default btn-sm" href="javascript:void(0)><span--}}
            {{--                                    class="d-none d-sm-inline-block me-1">Location</span>overview<span--}}
            {{--                                    class="fa fa-chevron-right ms-1 fs--1"></span></a></div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('vendors/chartisan/chart.min.js') }}"></script>
    <script src="{{ asset('vendors/chartisan/chartisan.umd.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

    <script>
        const chart = new Chartisan({
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
                                        return `${data.datasets[tooltipItem.datasetIndex].label} - @KSH.${tooltipItem.yLabel}`;
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
                    })
                })
                .responsive()
                .datasets([
                    {
                        label: 'today',
                        type: 'line', fill: true,
                        backgroundColor: chartGradient([255, 255, 225]),
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
            /*hooks: new ChartisanHooks()
                .responsive()
                .legend({display: false})
                .beginAtZero()
                .tooltip({
                    mode: 'x-axis',
                    xPadding: 20,
                    yPadding: 10,
                    displayColors: false,
                    callbacks: {
                        label: (tooltipItem, data) => {
                            let dataset = data.datasets[tooltipItem.datasetIndex];
                            let currentValue = dataset.data[tooltipItem.index];

                            return new Intl.NumberFormat('en-GB', {
                                style: 'currency',
                                currency: 'KES'
                            }).format(currentValue)
                        }
                    }
                })
                .datasets([{
                    type: 'line',
                    fill: true,
                    backgroundColor: gradientColor([255, 255, 255]),
                    borderColor: localStorage.getItem('theme') === 'dark' ? utils.getColors().primary : utils.settings.chart.borderColor,
                    borderWidth: 2
                }])
                .options({
                    options: {
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
                                show: false,
                                display: false,
                                gridLines: {
                                    display: false,
                                    show: false
                                }
                            }]
                        }
                    }
                })*/
        });
    </script>
@endsection
