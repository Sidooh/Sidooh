@extends('admin.layouts.app')

@section('content')

    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
             style="background-image:url({{ asset('img/illustrations/corner-4.png') }});opacity: 0.7;">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <h5>Transaction Details: #{{ $transaction->id }}</h5>
            <p class="fs--1">{{ local_date($transaction->created_at, 'M d, Y, h:m A') }}</p>
            <div>
                <strong class="me-2">Status: </strong>
                {{--                TODO: Use status class to decide colour of pill instead of if statement--}}

                {{--                <div class="badge rounded-pill badge-soft-success fs--2">--}}
                {{--                    {{ $transaction->status }}--}}
                {{--                    <span class="fas fa-check ms-1" data-fa-transform="shrink-2"></span>--}}
                {{--                </div>--}}
                @if($transaction->status === 'completed')
                    <div class="badge rounded-pill badge-soft-success fs--2">
                        {{ $transaction->status }}
                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                        @elseif($transaction->status === 'failed')
                            <div class="badge rounded-pill badge-soft-secondary fs--2">
                                {{ $transaction->status }}
                                <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>

                                @else
                                    <div class="badge rounded-pill badge-soft-warning fs--2">
                                        {{ $transaction->status }}
                                        <span class="ms-1 fas fa-stream" data-fa-transform="shrink-2"></span>

                                        @endif

                                    </div>
                            </div>
                    </div>

                    @if(strtolower($transaction->status) === 'pending' && strtolower($transaction->payment->status) === 'complete')
                        <div class="dropdown font-sans-serif">
                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end"
                                    type="button" id="dropdown0" data-bs-toggle="dropdown" data-boundary="window"
                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                    class="fas fa-ellipsis-h fs--1"></span></button>
                            <div class="dropdown-menu dropdown-menu-end border py-2">

                                <form method="POST"
                                      action="{{ route('admin.transactions.refund', $transaction) }}">
                                    @csrf
                                    <button
                                        class="dropdown-item"
                                        type="submit">
                                        <span class="fas fa-sync me-1" data-fa-transform="shrink-3"></span>
                                        Refund
                                    </button>
                                </form>

                                <div class="dropdown-divider"></div>
                                <form method="POST"
                                      action="{{ route('admin.transactions.payments.status.mark_payment_complete', $transaction->payment) }}">
                                    @csrf
                                    <button
                                        class="dropdown-item text-warning"
                                        type="submit">
                                        <span class="fas fa-correct me-1" data-fa-transform="shrink-3"></span>
                                        Mark Payment Complete
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.transactions.status.mark_complete', $transaction) }}">
                                    @csrf
                                    <button
                                        class="dropdown-item text-warning"
                                        type="submit">
                                        <span class="fas fa-correct me-1" data-fa-transform="shrink-3"></span>
                                        Mark Transaction Complete
                                    </button>
                                </form>

                                <div class="dropdown-divider"></div>
                                <form method="POST"
                                      action="{{ route('admin.transactions.status.mark_both_complete', $transaction) }}">
                                    @csrf
                                    <button
                                        class="dropdown-item text-warning"
                                        type="submit">
                                        <span class="fas fa-correct me-1" data-fa-transform="shrink-3"></span>
                                        Mark Both Complete
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endif

            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <h5 class="mb-3 fs-0">Account</h5>
                            <h6 class="mb-2">
                                <a href="{{ $transaction->account->user ? route('admin.users.show', $transaction->account->user ) : route('admin.accounts.show', $transaction->account ) }}">
                                    {{ $transaction->account->user ? $transaction->account->user->name : $transaction->account->phone }}
                                </a>
                            </h6>
                            {{--                            <p class="mb-1 fs--1">2393 Main Avenue<br/>Penasauka, New Jersey 87896</p>--}}
                            <p class="mb-0 fs--1"><strong>Email: </strong><a
                                    href="mailto:{{ $transaction->account->user ? $transaction->account->user->email : null }}">{{ $transaction->account->user ? $transaction->account->user->email : null }}</a>
                            </p>
                            <p class="mb-0 fs--1"><strong>Phone: </strong><a
                                    href="tel:{{ $transaction->account->phone }}">{{ $transaction->account->phone }}</a>
                            </p>
                        </div>
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <h5 class="mb-3 fs-0">Details</h5>
                            <h6 class="mb-2">{{ $transaction->description }}</h6>
                            <p class="mb-0 fs--1"><strong>Type: </strong>{{ $transaction->type }}</p>
                            <div class="fs--1"><strong>Amount: </strong>({{ format_cur($transaction->amount) }})</div>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="mb-3 fs-0">Payment</h5>
                            <div class="d-flex"><img class="me-3" src="{{ asset('img/icons/mpesa.png') }}" width="40"
                                                     height="30"
                                                     alt=""/>
                                <div class="flex-1">
                                    <h6 class="mb-0">{{ $transaction->payment->full_type }}</h6>
                                    <p class="mb-0 fs--1">
                                        <strong>Amount: </strong>{{ format_cur($transaction->amount) }}</p>
                                    <div class="fs--1"><strong>Status: </strong>
                                        {{--                TODO: Use status class to decide colour of pill instead of if statement--}}

                                        @if($transaction->payment->status === 'Complete')
                                            <div class="badge rounded-pill badge-soft-success fs--2">
                                                {{ $transaction->payment->status }}
                                                <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>

                                                @elseif($transaction->payment->status === 'Failed')
                                                    <div class="badge rounded-pill badge-soft-secondary fs--2">
                                                        {{ $transaction->payment->status }}
                                                        <span class="ms-1 fas fa-ban"
                                                              data-fa-transform="shrink-2"></span>

                                                        @else
                                                            <div class="badge rounded-pill badge-soft-warning fs--2">
                                                                {{ $transaction->payment->status }}
                                                                <span class="ms-1 fas fa-stream"
                                                                      data-fa-transform="shrink-2"></span>

                                                                @endif

                                                            </div>
                                                    </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($transaction->payment->type == 'MPESA')
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="table-responsive fs--1">
                                    <table class="table table-striped border-bottom">
                                        <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="border-0">Reference</th>
                                            <th class="border-0 text-center">Status</th>
                                            <th class="border-0">Result</th>
                                            <th class="border-0">Amount</th>
                                            <th class="border-0">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($transaction->payment->subtype == 'STK')

                                            <tr class="border-200">
                                                <td class="align-middle">
                                                    <h6 class="mb-0 text-nowrap">{{ $transaction->payment->stkRequest->reference }}</h6>
                                                    <p class="mb-0">{{ $transaction->payment->stkRequest->phone }}</p>
                                                </td>
                                                <td class="align-middle text-center">{{ $transaction->payment->stkRequest->status }}</td>
                                                <td class="align-middle">{{ $transaction->payment->stkRequest->response ? $transaction->payment->stkRequest->response->ResultDesc : null }}</td>
                                                <td class="align-middle">{{ format_cur($transaction->payment->stkRequest->amount) }}</td>
                                                <td class="align-middle">{{ local_date($transaction->payment->stkRequest->response ? $transaction->payment->stkRequest->response->created_at : $transaction->payment->stkRequest->created_at, 'M d, Y, h:m A') }}</td>

                                                <td>
                                                    @if($transaction->payment->stkRequest->status === 'Requested')
                                                        <form method="POST"
                                                              action="{{ route('admin.transactions.status.query') }}">
                                                            @csrf
                                                            <button
                                                                class="btn btn-falcon-default rounded-pill me-1 mb-1"
                                                                type="submit">
                                                            <span class="fas fa-sync me-1"
                                                                  data-fa-transform="shrink-3"></span>Query Status
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>

                                        @elseif($transaction->payment->subtype == 'B2C')

                                            <tr class="border-200">
                                                <td class="align-middle">
                                                    <h6 class="mb-0 text-nowrap">{{ $transaction->payment->b2cRequest->response ? $transaction->payment->b2cRequest->response->TransactionID : 'Requested' }}</h6>
                                                    <p class="mb-0">{{ $transaction->payment->b2cRequest->phone }}</p>
                                                </td>
                                                <td class="align-middle text-center">{{ $transaction->payment->b2cRequest->response ? $transaction->payment->b2cRequest->response->ResultCode : null }}</td>
                                                <td class="align-middle">{{ $transaction->payment->b2cRequest->response ? $transaction->payment->b2cRequest->response->ResultDesc : null }}</td>
                                                <td class="align-middle">{{ format_cur($transaction->payment->b2cRequest->amount) }}</td>
                                                <td class="align-middle">{{ local_date($transaction->payment->b2cRequest->response ? $transaction->payment->b2cRequest->response->created_at : $transaction->payment->b2cRequest->created_at, 'M d, Y, h:m A') }}</td>

                                                <td>
                                                    @if($transaction->payment->b2cRequest->status === 'Requested')
                                                        <form method="POST"
                                                              action="{{ route('admin.transactions.status.query') }}">
                                                            @csrf
                                                            <button
                                                                class="btn btn-falcon-default rounded-pill me-1 mb-1"
                                                                type="submit">
                                                            <span class="fas fa-sync me-1"
                                                                  data-fa-transform="shrink-3"></span>Query Status
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>

                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                                {{--                    <div class="row g-0 justify-content-end">--}}
                                {{--                        <div class="col-auto">--}}
                                {{--                            <table class="table table-sm table-borderless fs--1">--}}
                                {{--                                <tr class="border-top">--}}
                                {{--                                    <th class="text-900">Total Requested:</th>--}}
                                {{--                                    <td class="fw-semi-bold">{{ format_cur($transaction->payment->b2cRequest->response->Amount) }}</td>--}}
                                {{--                                </tr>--}}
                                {{--                            </table>--}}
                                {{--                        </div>--}}
                                {{--                    </div>--}}
                            </div>
                        </div>
                    @endif

                    @if($transaction->airtime)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="table-responsive fs--1">
                                    <table class="table table-striped border-bottom">
                                        <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="border-0">Request Message</th>
                                            <th class="border-0">Amount</th>
                                            <th class="border-0">Discount</th>
                                            <th class="border-0">Phone</th>
                                            <th class="border-0">Response Message</th>
                                            <th class="border-0 text-center">Status</th>
                                            <th class="border-0">Date</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="border-200">
                                            <td class="align-middle">
                                                {{ $transaction->airtime->errorMessage }}
                                            </td>
                                            <td class="align-middle">{{ $transaction->airtime->totalAmount }}</td>
                                            <td class="align-middle">{{ $transaction->airtime->totalDiscount }}</td>

                                            <td class="align-middle">{{ $transaction->airtime->response ? $transaction->airtime->response->phoneNumber : '' }}</td>
                                            <td class="align-middle">{{ $transaction->airtime->response ? $transaction->airtime->response->errorMessage : '' }}</td>
                                            <td class="align-middle text-center">{{ $transaction->airtime->response ? $transaction->airtime->response->status : '' }}</td>
                                            <td class="align-middle">{{ local_date($transaction->airtime->response ? $transaction->airtime->response->created_at : $transaction->airtime->created_at, 'M d, Y, h:m A') }}</td>

                                            <td>
                                                {{--                                                @if($transaction->airtime->descriptor->status === 'Requested')--}}
                                                {{--                                                    <form method="POST"--}}
                                                {{--                                                          action="{{ route('admin.transactions.status.query') }}">--}}
                                                {{--                                                        @csrf--}}
                                                {{--                                                        <button class="btn btn-falcon-default rounded-pill me-1 mb-1"--}}
                                                {{--                                                                type="submit">--}}
                                                {{--                                                            <span class="fas fa-sync me-1"--}}
                                                {{--                                                                  data-fa-transform="shrink-3"></span>Query Status--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    </form>--}}
                                                {{--                                                @endif--}}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($transaction->request)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="table-responsive fs--1">
                                    <table class="table table-striped border-bottom">
                                        <thead class="bg-200 text-900">
                                        <tr>
                                            <th class="border-0">ID</th>
                                            <th class="border-0">Amount</th>
                                            <th class="border-0">Provider</th>
                                            <th class="border-0">Destination</th>
                                            <th class="border-0">Message</th>
                                            <th class="border-0 text-center">Status</th>
                                            <th class="border-0">Date</th>
                                            <th class="border-0">Extra</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="border-200">
                                            <td class="align-middle">
                                                {{ $transaction->request->id }}
                                                {{--                                                <br>--}}
                                                {{--                                                <span class="text-info">({{ $transaction->request->receipt_number }})</span>--}}
                                            </td>
                                            <td class="align-middle">{{ $transaction->request->amount }}</td>
                                            <td class="align-middle">{{ $transaction->request->provider }}</td>

                                            <td class="align-middle">{{ $transaction->request->destination }}</td>
                                            <td class="align-middle">{{ $transaction->request->message }}</td>
                                            <td class="align-middle text-center">{{ $transaction->request->status }}</td>
                                            <td class="align-middle">{{ local_date($transaction->request->last_modified, 'M d, Y, h:m A') }}</td>

                                            <td>
                                                @if ($transaction->request->result)
                                                    @forelse($transaction->request->result as $value)
                                                        <div>
                                                            {{ $value['label'] }} - {{ $value['value'] }}
                                                        </div>
                                                    @empty

                                                    @endforelse
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->request->status === '000001')
                                                    <form method="POST"
                                                          action="{{ route('admin.transactions.request.status.query') }}">
                                                        @csrf
                                                        <button
                                                            class="btn btn-sm rounded-pill me-1 mb-1"
                                                            type="submit">
                                                            <span class="fas fa-sync me-1"
                                                                  data-fa-transform="shrink-3"></span>Check Status
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
    @endif

@endsection
