@extends('admin.layouts.app')

@section('content')

    <div class="card mb-3" id="customersTable"
         data-list='{"valueNames":["type","content","to","status","created"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">User Notifications</h5>
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
                        <a href="{{ route('admin.user-notifications.create') }}" class="btn btn-falcon-default btn-sm"
                           type="button"><span class="fas fa-plus"
                                               data-fa-transform="shrink-3 down-2"></span><span
                                class="d-none d-sm-inline-block ms-1">New</span></a>
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
                            <div class="form-check fs-0 mb-0 d-flex align-items-center"><input class="form-check-input"
                                                                                               id="checkbox-bulk-customers-select"
                                                                                               type="checkbox"
                                                                                               data-bulk-select='{"body":"table-customers-body","actions":"table-customers-actions","replacedElement":"table-customers-replace-element"}'/>
                            </div>
                        </th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="type">Type</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="content">Content</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="to">To</th>
                        <th class="sort pe-1 align-middle white-space-nowrap ps-5" data-sort="status">Status</th>
                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="created">Created</th>
                        <th class="align-middle no-sort"></th>
                    </tr>
                    </thead>
                    <tbody class="list" id="table-customers-body">

                    @foreach($userNotifications as $userNotification)

                        <tr class="btn-reveal-trigger">
                            <td class="align-middle py-2" style="width: 28px;">
                                <div class="form-check fs-0 mb-0 d-flex align-items-center">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="customer-0"
                                           data-bulk-select-row="data-bulk-select-row"/>
                                </div>
                            </td>
                            <td class="type align-middle white-space-nowrap py-2">
                                {{ $userNotification->type }}
                            </td>
                            <td class="content align-middle white-space-nowrap py-2">
                                {{ $userNotification->content }}
                            </td>
                            <td class="to align-middle white-space-nowrap py-2">
                                @foreach($userNotification->to as $to)
                                    <span class="badge rounded-pill badge-soft-success fs--2">
                                        {{ $to }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="status align-middle white-space-nowrap py-2">
                                {{ $userNotification->status }}
                            </td>

                            <td class="joined align-middle py-2">{{ local_date($userNotification->created_at, 'd/m/Y H:i') }}</td>

                            <td class="align-middle white-space-nowrap py-2 text-end">
                                <div class="dropdown font-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                            type="button"
                                            id="customer-dropdown-0" data-bs-toggle="dropdown" data-boundary="window"
                                            aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-ellipsis-h fs--1"></span></button>
                                    <div class="dropdown-menu dropdown-menu-end border py-0"
                                         aria-labelledby="customer-dropdown-0">
                                        <div class="bg-white py-2">
                                            <a class="dropdown-item"
                                               href="{{ route('admin.user-notifications.show', $userNotification) }}">View
                                            </a>
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
