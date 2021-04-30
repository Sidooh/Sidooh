@extends('admin.layouts.app')

@section('content')

    <div class="card mb-3" id="customersTable"
         data-list='{"valueNames":["name","email","phone","status","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Transactions</h5>
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
                    <tbody class="list" id="table-customers-body">

                    @foreach($transactions as $transaction)

                        <tr class="btn-reveal-trigger">
                            <td class="align-middle" style="width: 28px;">
                                <div class="form-check mb-0 d-flex align-items-center">
                                    <input class="form-check-input"
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

                                    @if(strtolower($transaction->payment->status) === 'complete')
                                        <span class="badge badge rounded-pill badge-soft-success">
                                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                                    @elseif(strtolower($transaction->payment->status) === 'failed')
                                                <span class="badge badge rounded-pill badge-soft-warning">
                                            <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>

                                    @elseif(strtolower($transaction->payment->status) === 'pending')
                                                        <span class="badge badge rounded-pill badge-soft-primary">
                                            <span class="ms-1 fas fa-redo" data-fa-transform="shrink-2"></span>
                                    @else
                                                                <span
                                                                    class="badge badge rounded-pill badge-soft-secondary">
                                            <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>

                                    @endif
                                                                    {{ $transaction->payment->status }}
                                    </span>

                                    @endif
                            </td>
                            <td class="align-middle text-center fs-0 white-space-nowrap payment">

                                @if(strtolower($transaction->status) === 'completed' || strtolower($transaction->status) === 'success')
                                    <span class="badge badge rounded-pill badge-soft-success">
                                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                                @elseif(strtolower($transaction->status) === 'failed')
                                            <span class="badge badge rounded-pill badge-soft-warning">
                                        <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>

                                @elseif(strtolower($transaction->status) === 'pending')
                                                    <span class="badge badge rounded-pill badge-soft-primary">
                                        <span class="ms-1 fas fa-redo" data-fa-transform="shrink-2"></span>
                                @else
                                                            <span class="badge badge rounded-pill badge-soft-secondary">
                                        <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>

                                @endif
                                                                {{ $transaction->status }}
                                </span>
                            </td>
                            <td class="align-middle text-end amount">{{ local_date($transaction->updated_at, 'd/m/Y H:i') }}</td>

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
