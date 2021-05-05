@extends('admin.layouts.app')

@section('content')

    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
             style="background-image:url({{ asset('img/illustrations/corner-4.png') }});opacity: 0.7;"></div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <h5>Account Details: #{{ $account->id }}</h5>
            <p class="fs--1">{{ local_date($account->created_at, 'M d, Y, h:m A') }}</p>
            <div><strong class="me-2">Status: </strong>
                @if($account->active)
                    <div class="badge rounded-pill badge-soft-success fs--2">
                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                        @else
                            <div class="badge rounded-pill badge-soft-warning fs--2">
                                <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>

                                @endif
                                {{ $account->active ? 'active' : 'inactive' }}
                            </div>
                    </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3 fs-0">Account</h5>
                        <h6 class="mb-2">
                            <a
                                href="tel:{{ $account->phone }}">{{ $account->phone }}</a>
                        </h6>
                        {{--                            <p class="mb-1 fs--1">2393 Main Avenue<br/>Penasauka, New Jersey 87896</p>--}}
                        <p class="mb-0 fs--1"><strong>Email: </strong><a
                                href="mailto:{{ $account->user ? $account->user->email : null }}">{{ $account->user ? $account->user->email : null }}</a>
                        </p>
                        <p class="mb-0 fs--1"><strong>Phone: </strong><a
                                href="tel:{{ $account->phone }}">{{ $account->phone }}</a>
                        </p>
                    </div>
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <h5 class="mb-3 fs-0">User</h5>
                        <h6 class="mb-2">
                            <a href="{{ $account->user ? route('admin.users.show', $account->user ) : route('admin.accounts.show', $account ) }}">
                                {{ $account->user ? $account->user->name : $account->phone }}
                            </a>
                        </h6>
                        <p class="mb-0 fs--1"><strong>ID
                                Number: </strong>{{ $account->user ? $account->user->id_number : null }}
                        </p>
                        @if($account->user)
                            <div class="fs--1"><strong>Status: </strong>
                                @if($account->user->status == 'active')
                                    <div class="badge rounded-pill badge-soft-success fs--2">
                                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                                        {{ $account->user->status }}
                                    </div>
                                @else
                                    <div class="badge rounded-pill badge-soft-warning fs--2">
                                        <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>
                                        {{ $account->user->status }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <h5 class="mb-3 fs-0">Referrer</h5>
                        <div class="d-flex">
                            @if($account->referrer)
                                <div class="flex-1">
                                    <h6 class="mb-0">
                                        <a href="{{ route('admin.accounts.show', $account->referrer ) }}">
                                            {{ $account->referrer->phone }}
                                        </a>
                                    </h6>
                                    @if($account->referrer->user)
                                        <p class="mb-0 fs--1">
                                            <strong>User: </strong>
                                            <a href="{{ route('admin.users.show', $account->referrer->user ) }}">
                                                {{ $account->referrer->user->name }}
                                            </a>
                                        </p>
                                    @endif
                                    <p class="mb-0 fs--1">
                                        <strong>Status: </strong>
                                    @if($account->referrer->active)
                                        <div class="badge rounded-pill badge-soft-success fs--2">
                                            <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                                            active
                                        </div>
                                    @else
                                        <div class="badge rounded-pill badge-soft-warning fs--2">
                                            <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>
                                            inactive
                                        </div>
                                        @endif
                                        </p>
                                </div>
                            @else
                                <p class="mb-0 fs--1">
                                    <strong>Root-level User</strong>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-sm-6 col-md-4">
                <div class="card overflow-hidden" style="min-width: 12rem">
                    <div class="bg-holder bg-card"
                         style="background-image:url( {{ asset('img/illustrations/corner-1.png') }} );"></div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6>Referrals<span
                                class="badge badge-soft-warning rounded-pill ms-2">{{ $data['totalReferralsToday'] }}</span>
                        </h6>
                        <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                             data-countup='{"endValue":{{ $data['totalReferrals'] }},"decimalPlaces":0,"suffix":""}'>0
                        </div>
                        {{--                                <a class="fw-semi-bold fs--1 text-nowrap" href="{{ route('admin.accounts.index') }}">See all<span--}}
                        {{--                                        class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>--}}
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card overflow-hidden" style="min-width: 12rem">
                    <div class="bg-holder bg-card"
                         style="background-image:url( {{ asset('img/illustrations/corner-2.png') }} );"></div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6>Transactions<span
                                class="badge badge-soft-info rounded-pill ms-2">{{ $data['totalTransactionsToday'] }}</span>
                        </h6>
                        <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                             data-countup='{"endValue":{{ $data['totalTransactions'] }},"decimalPlaces":0,"suffix":""}'>
                            0
                        </div>
                        {{--                                <a class="fw-semi-bold fs--1 text-nowrap" href="{{ route('admin.transactions.index', ['all']) }}">All--}}
                        {{--                                    transactions<span--}}
                        {{--                                        class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card overflow-hidden" style="min-width: 12rem">
                    <div class="bg-holder bg-card"
                         style="background-image:url( {{ asset('img/illustrations/corner-3.png') }} );"></div>
                    <!--/.bg-holder-->
                    <div class="card-body position-relative">
                        <h6>Revenue<span
                                class="badge badge-soft-success rounded-pill ms-2">{{ $data['totalRevenueToday'] }}</span>
                        </h6>
                        <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif"
                             data-countup='{"endValue":{{ $data['totalRevenue'] }},"prefix":"KES "}'>0
                        </div>
                        {{--                                <a class="fw-semi-bold fs--1 text-nowrap" href="#">Statistics<span--}}
                        {{--                                        class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>--}}
                    </div>
                </div>
            </div>
        </div>

        @if(count($account->level_referrals))
            <div class="card mb-3">
                <div class="card-body">
                    <h6>Referrals</h6>
                    <div class="table-responsive fs--1">
                        <table class="table table-striped border-bottom">
                            <thead class="bg-200 text-900">
                            <tr>
                                <th class="border-0">Ripple</th>
                                <th class="border-0 text-center">Total</th>
                                <th class="border-0">Accounts</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($account->level_referrals as $level => $referrals)
                                <tr class="border-200">

                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">{{ $level }}</h6>
                                    </td>
                                    <td class="align-middle text-center">{{ count($referrals) }}</td>
                                    <td class="align-middle">

                                        @foreach($referrals as $referral)
                                            <a href="{{ route('admin.accounts.show', $referral) }}">
                                                    <span
                                                        class="badge badge-soft-primary rounded-pill ms-2 mb-2 fs--1">
                                                    {{ $referral->phone }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="border-200 border-top-2">
                                <td colspan="3" class="align-middle text-center">Total
                                    Referrals: {{ $account->total_level_referrals }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


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
                            <button class="btn btn-falcon-default btn-sm" type="button"
                                    onclick="window.location.reload()">
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
                                    <input class="form-check-input"
                                           id="checkbox-bulk-purchases-select"
                                           type="checkbox"
                                           data-bulk-select='{"body":"table-purchase-body","actions":"table-purchases-actions","replacedElement":"table-purchases-replace-element"}'/>
                                </div>
                            </th>
                            <th class="sort pe-1 align-middle white-space-nowrap" data-sort="product">Product</th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="amount">Amount
                            </th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="payment">
                                Payment
                            </th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">
                                Status
                            </th>
                            <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="date">Date</th>
                            <th class="no-sort pe-1 align-middle data-table-row-action"></th>
                        </tr>
                        </thead>
                        <tbody class="list" id="table-purchase-body">
                        @foreach($data['recentTransactions'] as $transaction)

                            <tr class="btn-reveal-trigger">
                                <td class="align-middle" style="width: 28px;">
                                    <div class="form-check mb-0 d-flex align-items-center">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="recent-purchase-{{ $transaction->id }}"
                                               data-bulk-select-row="data-bulk-select-row"/>
                                    </div>
                                </td>
                                <td class="align-middle white-space-nowrap product">
                                    <a href="{{ route('admin.transactions.show', $transaction ) }}">{{ $transaction->description }}</a>
                                </td>
                                <td class="align-middle text-end amount">{{ format_cur($transaction->amount) }}</td>

                                <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                    @if($transaction->payment)
                                        @if($transaction->payment->status === 'Complete')
                                            <span class="badge badge rounded-pill badge-soft-success">
                                            <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                                        @elseif($transaction->payment->status === 'Failed')
                                                    <span class="badge badge rounded-pill badge-soft-secondary">
                                                <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>

                                        @else
                                                            <span class="badge badge rounded-pill badge-soft-warning">
                                                <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>

                                        @endif
                                                                {{ $transaction->payment->status }}
                                        </span>
                                                            @else
                                                                No payment found
                                        @endif
                                </td>
                                <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                    @if($transaction->status === 'completed')
                                        <span class="badge badge rounded-pill badge-soft-success">
                                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                                @elseif($transaction->status === 'failed')
                                                <span class="badge badge rounded-pill badge-soft-secondary">
                                        <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>

                                @else
                                                        <span class="badge badge rounded-pill badge-soft-warning">
                                        <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>

                                @endif
                                                            {{ $transaction->status }}
                                </span>
                                </td>
                                <td class="align-middle text-end date">{{ local_date($transaction->updated_at, 'd/m/Y H:i') }}</td>

                                <td class="align-middle white-space-nowrap">
                                    <div class="dropdown font-sans-serif">
                                        <button
                                            class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                                            type="button" id="dropdown0" data-bs-toggle="dropdown"
                                            data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                class="fas fa-ellipsis-h fs--1"></span></button>
                                        <div class="dropdown-menu dropdown-menu-end border py-2"
                                             aria-labelledby="dropdown0">
                                            <a
                                                class="dropdown-item"
                                                href="{{ route('admin.transactions.show', $transaction ) }}">View</a>
                                            <a
                                                class="dropdown-item"
                                                href="#!">Edit</a>
                                            <a
                                                class="dropdown-item" href="#!">Refund</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-warning" href="#!">Archive</a><a
                                                class="dropdown-item text-danger" href="#!">Delete</a>
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
                            <a class="fw-semi-bold" href="#!"
                               data-list-view="*">View all
                                <span
                                    class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                            </a>
                            {{--                        TODO: Find a way to collapse as well --}}
                            {{--                        <a class="fw-semi-bold" href="#!"--}}
                            {{--                           data-list-view="10">--}}
                            {{--                            <span class="fas fa-angle-left ms-1" data-fa-transform="down-1"></span>--}}
                            {{--                            Collapse--}}
                            {{--                        </a>--}}
                        </p>
                    </div>
                    <div class="col-auto d-flex">
                        <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev">
                            <span>Previous</span></button>
                        <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next">
                            <span>Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0">
            <div class="col-md-4 col-lg-3 pe-lg-2">
                <div class="card h-100 bg-line-chart-gradient">
                    <div class="card-header bg-transparent light">
                        <h5 class="text-white">VOUCHER</h5>
                        <div class="real-time-user display-4 fw-normal text-white"
                             data-countup='{"endValue":{{ $account->voucher->balance }},"prefix":"KES ","decimalPlaces":"0"}'>
                            0.0
                        </div>
                    </div>
                </div>
            </div>
            @foreach($account->sub_accounts as $acc)
                <div class="col-md-4 col-lg-3 pe-lg-2">
                    <div class="card h-100 bg-line-chart-gradient">
                        <div class="card-header bg-transparent light">
                            <h5 class="text-white">{{ $acc->type }}</h5>
                            <div class="real-time-user display-4 fw-normal text-white"
                                 data-countup='{"endValue":{{ $acc->balance }},"prefix":"KES ","decimalPlaces":"4"}'>0.0
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

@endsection
