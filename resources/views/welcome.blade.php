<!DOCTYPE html>
<!--[if lt IE 9 ]>
<html class="no-js oldie" lang="en"> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--<![endif]-->

<head>
    <!--- basic page needs
   ================================================== -->
    <meta charset="utf-8">
    <meta name="author" content="Sidooh">
    <meta name="description" content="Sidooh">

    <title>{{ config('app.name', 'Sidooh') }}</title>

    <!-- mobile specific metas
       ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Avenir" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/modernizr.js') }}"></script>
    <script src="{{ asset('js/pace.min.js') }}"></script>

    <!-- favicons
        ================================================== -->
    <link rel="shortcut icon" href="https://demos.onepagelove.com/html/dazzle/favicon.ico" type="image/x-icon">
    <link rel="icon" href="https://demos.onepagelove.com/html/dazzle/favicon.ico" type="image/x-icon">

</head>
<body>

<div id="preloader">
    <div id="loader"></div>
</div>

<!-- home
   ================================================== -->
<section id="home" data-parallax="scroll" data-image-src="{{ asset('img/illustrations/4.png') }}"
         data-natural-width=3000 data-natural-height=2000>

    <div class="overlay"></div>
    <div class="home-content">

        <div class="row contents">
            <div class="home-content-left">

                <h3 data-aos="fade-up">Welcome to {{ config('app.name') }}</h3>

                <h1 data-aos="fade-up">
                    {{ config('services.sidooh.tagline') }}
                </h1>

                <div class="buttons" data-aos="fade-up">
                    <a href="https://player.vimeo.com/video/14592941?title=0&amp;byline=0&amp;portrait=0&amp;color=39b54a"
                       data-lity class="button stroke">
                        <span class="icon-phone" aria-hidden="true"></span>
                        Buy Airtime
                    </a>
                </div>

            </div>

            <div class="home-image-right">
                <img src="https://demos.onepagelove.com/html/dazzle/images/iphone-app-470.png"
                     srcset="images/iphone-app-470.png 1x, images/iphone-app-940.png 2x"
                     data-aos="fade-up">
            </div>
        </div>

    </div> <!-- end home-content -->

    <ul class="home-social-list">
        <li>
            <a href="#"><i class="fa fa-facebook-square"></i></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-twitter"></i></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </li>
        <li>
            <a href="#"><i class="fa fa-youtube-play"></i></a>
        </li>
    </ul>
    <!-- end home-social-list -->

    <div class="home-scrolldown">
        <a href="#about" class="scroll-icon smoothscroll">
            {{--            <span>Scroll Down</span>--}}
            {{--            <i class="icon-arrow-right" aria-hidden="true"></i>--}}
        </a>
    </div>


</section> <!-- end home -->


{{--<div class="col-four md-1-2 tab-full footer-subscribe">--}}

<h4>Our Newsletter</h4>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
    aliqua.</p>

<style>
    input:invalid {
        border: red solid 3px;
    }
</style>

<div class="subscribe-form">

    {{--        TODO: Add checkbox for number is same as mpesa --}}
    <form method="POST" action="{{ route('airtime.purchase') }}">
        @csrf

        <input type="tel" name="recipient" placeholder="Recipient's Number" required
               @error('recipient') is-invalid @enderror" value="{{ old('recipient') }}">
        @error('recipient')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <input type="number" name="amount" placeholder="Amount" required min="10" max="2000"
               @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
        @error('amount')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <input type="tel" name="mpesa_number" required @error('mpesa_number') is-invalid
               @enderror value="{{ old('mpesa_number') }}" placeholder="Mpesa Number" title="254/07/7 123 12345"
               pattsern="^(?:254|\+254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$">
        @error('mpesa_number')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror

        <button type="submit">Send</button>

    </form>

</div>

{{--</div>--}}

{{--<form method="POST" action="{{ route('login') }}">--}}
{{--    @csrf--}}

{{--    <div class="form-group row">--}}
{{--        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--        <div class="col-md-6">--}}
{{--            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--            @error('email')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group row">--}}
{{--        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--        <div class="col-md-6">--}}
{{--            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--            @error('password')--}}
{{--            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group row">--}}
{{--        <div class="col-md-6 offset-md-4">--}}
{{--            <div class="form-check">--}}
{{--                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                <label class="form-check-label" for="remember">--}}
{{--                    {{ __('Remember Me') }}--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group row mb-0">--}}
{{--        <div class="col-md-8 offset-md-4">--}}
{{--            <button type="submit" class="btn btn-primary">--}}
{{--                {{ __('Login') }}--}}
{{--            </button>--}}

{{--            @if (Route::has('password.request'))--}}
{{--                <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                    {{ __('Forgot Your Password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}


<!-- Java Script
    ================================================== -->
<script data-cfasync="false"
        src="https://demos.onepagelove.com/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
