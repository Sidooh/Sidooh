@extends('admin.layouts.app')

@section('content')

    <form class="card" method="POST" action="{{ route('admin.user-notifications.store') }}">
        @csrf
        <div class="card-header bg-light">
            <h5 class="float-start mb-0">New message</h5>
            <a href="{{ route('admin.user-notifications.index') }}" class="btn btn-secondary float-end">back</a>
        </div>
        <div class="card-body p-0">
            <div class="border border-top-0 border-200">

                <select class="form-select border-0 rounded-0 outline-none px-card" id="type" name="type" required>
                    <option disabled>Select message type...</option>
                    <option value="SMS" selected>SMS</option>
                    <option value="EMAIL" disabled>EMAIL</option>
                    <option value="ALL" disabled>ALL</option>
                </select>

            </div>
            <div class="border border-top-0 border-200">

                <select class="form-select js-choice border-0 rounded-0 outline-none px-card" id="recipients"
                        multiple="multiple" size="1" name="recipients[]" required
                        data-options='{"removeItemButton":true,"placeholder":true}'>
                    <option disabled value="">Select recipients...</option>
                    <option value="ALL">ALL</option>
                    @foreach($accounts as $account)
                        <option value="{{$account->phone}}">{{$account->phone}}</option>
                    @endforeach
                </select>

            </div>

            <div class="border border-y-0 border-200 msin-vh-50">
                <textarea name="message"
                          class="form-control border-0 rounded-0 outline-none px-card min-vh-50" id="message"
                          type="text"
                          aria-describedby="message" placeholder="Message" required>Message</textarea>

            </div>
            {{--            <div class="min-vh-50">--}}
            {{--                <textarea class="tinymce d-none" name="content"></textarea>--}}
            {{--            </div>--}}
            {{--            <div class="bg-light px-card py-3">--}}
            {{--                <div class="d-inline-flex flex-column">--}}
            {{--                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1">--}}
            {{--                        <span class="fs-1 far fa-image"></span><span class="ms-2">winter.jpg (873kb)</span><a--}}
            {{--                            class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right"--}}
            {{--                            title="Detach"><span class="fas fa-times"></span></a></div>--}}
            {{--                    <div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1">--}}
            {{--                        <span class="fs-1 far fa-file-archive"></span><span class="ms-2">coffee.zip (342kb)</span><a--}}
            {{--                            class="text-300 p-1 ms-6" href="#!" data-bs-toggle="tooltip" data-bs-placement="right"--}}
            {{--                            title="Detach"><span class="fas fa-times"></span></a></div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
        <div class="card-footer border-top border-200 d-flex flex-between-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-primary btn-sm px-5 me-2" type="submit">Send</button>
                {{--                <input class="d-none" id="email-attachment" type="file"/><label--}}
                {{--                    class="me-2 btn btn-light btn-sm mb-0 cursor-pointer" for="email-attachment"--}}
                {{--                    data-bs-toggle="tooltip" data-bs-placement="top" title="Attach files"><span--}}
                {{--                        class="fas fa-paperclip fs-1" data-fa-transform="down-2"></span></label><input class="d-none"--}}
                {{--                                                                                                       id="email-image"--}}
                {{--                                                                                                       type="file"--}}
                {{--                                                                                                       accept="image/*"/><label--}}
                {{--                    class="btn btn-light btn-sm mb-0 cursor-pointer" for="email-image" data-bs-toggle="tooltip"--}}
                {{--                    data-bs-placement="top" title="Attach images"><span class="fas fa-image fs-1"--}}
                {{--                                                                        data-fa-transform="down-2"></span></label>--}}
            </div>
            {{--            <div class="d-flex align-items-center">--}}
            {{--                <div class="dropdown font-sans-serif me-2 btn-reveal-trigger">--}}
            {{--                    <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none"--}}
            {{--                            id="email-options" type="button" data-bs-toggle="dropdown" data-boundary="viewport"--}}
            {{--                            aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-v"--}}
            {{--                                                                             data-fa-transform="down-2"></span></button>--}}
            {{--                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="email-options"><a--}}
            {{--                            class="dropdown-item" href="#!">Print</a><a class="dropdown-item" href="#!">Check--}}
            {{--                            spelling</a><a class="dropdown-item" href="#!">Plain text mode</a>--}}
            {{--                        <div class="dropdown-divider"></div>--}}
            {{--                        <a class="dropdown-item" href="#!">Archive</a>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            <button class="btn btn-light btn-sm" type="reset" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Delete"><span class="fas fa-trash"></span></button>
        </div>
        </div>
    </form>

@endsection

@section('js')

    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

@endsection
