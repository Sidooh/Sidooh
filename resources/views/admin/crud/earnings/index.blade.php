@extends('admin.layouts.app')

@section('content')

    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('img/illustrations/corner-1.png') }} );"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Self Earnings<span
                            class="badge badge-soft-warning rounded-pill ms-2">{{ $data['totalSelfToday'] }}</span>
                    </h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"
                         data-countup='{"endValue":{{ $data['totalSelf'] }},"decimalPlaces":2,"prefix":"KES ","suffix":""}'>
                        0
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('img/illustrations/corner-2.png') }} );"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Referral Earnings<span
                            class="badge badge-soft-info rounded-pill ms-2">{{ $data['totalReferralToday'] }}</span>
                    </h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"
                         data-countup='{"endValue":{{ $data['totalReferral'] }},"decimalPlaces":2,"prefix":"KES ","suffix":""}'>
                        0
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card"
                     style="background-image:url( {{ asset('img/illustrations/corner-3.png') }} );"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>System Earnings<span
                            class="badge badge-soft-success rounded-pill ms-2">{{ $data['totalSystemToday'] }}</span>
                    </h6>
                    <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif"
                         data-countup='{"endValue":{{ $data['totalSystem'] }},"decimalPlaces":2,"prefix":"KES "}'>0
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3" id="customersTable"
         data-list='{"valueNames":["account","transaction","earning","type","date"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Earnings</h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">
                    <div class="d-none" id="table-customers-actions">
                        <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                                <option selected="">Bulk actions</option>
                                <option value="Refund">Refund</option>
                                <option value="Delete">Delete</option>
                                <option value="Archive">Archive</option>
                            </select>
                            <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
                        </div>
                    </div>
                    <div id="table-customers-replace-element">
                        <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus"
                                                                                          data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">New</span></button>
                        <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter"
                                                                                               data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">Filter</span></button>
                        <button class="btn btn-falcon-default btn-sm" type="button"><span
                                class="fas fa-external-link-alt" data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">Export</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped fs--1 mb-0">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>
                            <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                <input class="form-check-input"
                                       id="checkbox-bulk-customers-select"
                                       type="checkbox"
                                       data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}'/>
                            </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="account">Account</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="transaction">Transaction</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-end" data-sort="earning">Earning</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="type">Type</th>
                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="date">Date</th>
                        <th class="no-sort pe-1 align-middle data-table-row-action"></th>
                    </tr>
                    </thead>
                    <tbody class="list" id="table-customers-body">

                    @foreach($data['recentEarnings'] as $earning)

                        <tr class="btn-reveal-trigger">
                            <td class="align-middle" style="width: 28px;">
                                <div class="form-check mb-0 d-flex align-items-center">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="recent-purchase-{{ $earning->id }}"
                                           data-bulk-select-row="data-bulk-select-row"/>
                                </div>
                            </td>
                            <th class="align-middle white-space-nowrap account">
                                <a href="{{ $earning->account ? route('admin.accounts.show', $earning->account ) : '' }}">
                                    {{ $earning->account ? $earning->account->phone : '' }}
                                </a>
                            </th>
                            <td class="align-middle white-space-nowrap transaction">
                                <a href="{{ route('admin.transactions.show', $earning->transaction ) }}">{{ $earning->transaction->description }}</a>
                            </td>
                            <td class="align-middle text-end earning">{{ format_cur($earning->earnings, 4) }}</td>

                            <td class="align-middle text-center fs-0 white-space-nowrap type">

                                @if($earning->type === 'SELF')
                                    <span class="badge badge rounded-pill badge-soft-success">
                                            <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                                    @elseif($earning->type === 'REFERRAL')
                                            <span class="badge badge rounded-pill badge-soft-primary">
                                            <span class="ms-1 fas fa-redo" data-fa-transform="shrink-2"></span>

                                    @else
                                                    <span class="badge badge rounded-pill badge-soft-secondary">
                                            <span class="ms-1 fas fa-globe" data-fa-transform="shrink-2"></span>

                                    @endif
                                                        {{ $earning->type }}
                                    </span>

                            </td>

                            <td class="align-middle text-end date">{{ local_date($earning->created_at, 'd/m/Y H:i') }}</td>

                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown font-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                                            type="button" id="dropdown0" data-bs-toggle="dropdown"
                                            data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                            class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-2"
                                         aria-labelledby="dropdown0"><a
                                            class="dropdown-item" href="#!">View</a><a class="dropdown-item"
                                                                                       href="#!">Edit</a><a
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
        <div class="card-footer d-flex align-items-center justify-content-center">
            <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous"
                    data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
            <ul class="pagination mb-0"></ul>
            <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next">
                <span class="fas fa-chevron-right"></span></button>
        </div>
    </div

@endsection
