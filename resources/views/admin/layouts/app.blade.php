<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.includes.header')

<body>
{{--        @include('admin.includes.preloader')--}}

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <div class="container" data-layout="container">
        <script>
            let isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                let container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>

        @include('admin.includes.sidenav')

        <div class="content">

            @include('admin.includes.navbar')

            @yield('content')

            <footer>
                <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                    <div class="col-12 col-sm-auto text-center">
                        <p class="mb-0 text-600">Sidash <span class="d-none d-sm-inline-block">| </span><br
                                class="d-sm-none"/> 2021 &copy; <a href="{{ route('home') }}">Sidooh</a></p>
                    </div>
                    <div class="col-12 col-sm-auto text-center">
                        <p class="mb-0 text-600">v1 <span class="d-none d-sm-inline-block">| </span><br
                                class="d-sm-none"/> {{ session('timezone') }}</p>
                    </div>
                </div>
            </footer>
        </div>

        {{--        <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">--}}
        {{--            <div class="modal-dialog mt-6" role="document">--}}
        {{--                <div class="modal-content border-0">--}}
        {{--                    <div class="modal-header px-5 position-relative modal-shape-header bg-shape">--}}
        {{--                        <div class="position-relative z-index-1 light">--}}
        {{--                            <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>--}}
        {{--                            <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>--}}
        {{--                        </div><button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>--}}
        {{--                    </div>--}}
        {{--                    <div class="modal-body py-4 px-5">--}}
        {{--                        <form>--}}
        {{--                            <div class="mb-3"><label class="form-label" for="modal-auth-name">Name</label><input class="form-control" type="text" id="modal-auth-name" /></div>--}}
        {{--                            <div class="mb-3"><label class="form-label" for="modal-auth-email">Email address</label><input class="form-control" type="email" id="modal-auth-email" /></div>--}}
        {{--                            <div class="row gx-3">--}}
        {{--                                <div class="mb-3 col-sm-6"><label class="form-label" for="modal-auth-password">Password</label><input class="form-control" type="password" id="modal-auth-password" /></div>--}}
        {{--                                <div class="mb-3 col-sm-6"><label class="form-label" for="modal-auth-confirm-password">Confirm Password</label><input class="form-control" type="password" id="modal-auth-confirm-password" /></div>--}}
        {{--                            </div>--}}
        {{--                            <div class="form-check"><input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" /><label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label></div>--}}
        {{--                            <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button></div>--}}
        {{--                        </form>--}}
        {{--                        <div class="position-relative mt-5">--}}
        {{--                            <hr class="bg-300" />--}}
        {{--                            <div class="divider-content-center">or register with</div>--}}
        {{--                        </div>--}}
        {{--                        <div class="row g-2 mt-2">--}}
        {{--                            <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>--}}
        {{--                            <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </div>
</main>
<!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

@include('admin.includes.settings')

@include('admin.includes.scripts')
@yield('js')

</body>
</html>
