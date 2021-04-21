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
    <meta name="description" content="{{ config('services.sidooh.tagline') }}">

    <title>{{ config('app.name', 'Sidooh') }} - Welcome!</title>

    <!-- mobile specific metas
       ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Avenir" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Proxima+Nova" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">


    <style>
        input {
            height: 5rem;
            margin-bottom: 1rem;
        }

        p {
            color: white;
        }

        .warning {
            line-height: unset;
            color: white;
            font-weight: bold;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/modernizr.js') }}"></script>
    <script src="{{ asset('js/pace.min.js') }}"></script>

    <!-- favicons
        ================================================== -->
    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/png">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-B5Q2DQ8JF2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-B5Q2DQ8JF2');
    </script>
</head>
<body id="top">

<!-- header
================================================== -->
<header id="header" class="row">

    <div class="header-logo">
        <a href="/">Sidooh</a>
    </div>

    {{--    <a class="header-menu-toggle" href="#"><span>Menu</span></a>--}}

</header> <!-- /header -->


<!-- home
================================================== -->
<section id="home">

    {{--    <div class="overlay"></div>--}}
    <div class="home-content">

        <div class="row contents">
            <div class="home-content-left">

                <h3 data-aos="fade-up" style="color: #0F1B4C;">Welcome to {{ config('app.name') }}</h3>

                <h1 data-aos="fade-up" style="color: #648381;">
                    {{ config('services.sidooh.tagline') }}
                </h1>

                <h4 data-aos="fade-up" style="color: #648381;">
                    {{ config('services.sidooh.about') }}
                </h4>

            </div>

            <div class="home-image-right mx-auto">
                <div class="row pt-5 mx-auto" style="background: #F5B700; border-radius: 1%">
                    <div class="mx-auto">

                        <h2 style="color: rgba(0, 0, 0, 0.8); font-size: 1.6rem;
                            line-height: 1.5;
                            text-transform: uppercase;
                            letter-spacing: .2rem;
                            margin-bottom: 2.4rem;">Buy Airtime</h2>

                        <hr>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('warning'))
                            <div class="alert alert-danger">
                                {{ session('warning') }}
                            </div>
                        @endif


                        @if(session('stk') && !session('payment'))
                            <span class="warning">
                                        The page will refresh in a few seconds.
                            </span>
                            <script>
                                // window.onload = function() {
                                setTimeout(function () {
                                    window.location.replace("{{ route('airtime.purchase.result') }}")
                                }, 10000);
                                // };
                            </script>
                        @endif

                        @if(session('payment'))
                            <span class="warning">
                                {{ session('payment_status') }} Payment
                            </span>

                            @if(session('payment_status') == 'Failed')
                                <p>Please try again.</p>
                            @elseif (session('payment_status') == 'Complete')
                                <p>Airtime purchase in progress, You will receive a confirmation SMS.</p>
                            @endif
                            {{ session(['payment' => null]) }}
                        @endif


                        <form method="POST" action="{{ route('airtime.purchase') }}">
                            @csrf
                            <div class="form-group">
                                <label for="recipient">Recipient</label>
                                <input type="tel" class="form-control" name="recipient" placeholder="Recipient's Number"
                                       required aria-describedby="recipientHelp" id="recipient"
                                       value="{{ old('recipient') }}">
                                @error('recipient')
                                <span class="warning">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>

                                <input type="number" name="amount" placeholder="Amount" required min="10" max="2000"
                                       id="amount" class="form-control" value="{{ old('amount') }}">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mpesa_number">Mpesa Number</label>
                                <input type="tel" name="mpesa_number" required value="{{ old('mpesa_number') }}"
                                       placeholder="Mpesa Number"
                                       title="254/07/7/01/1 123 12345" id="mpesa_number" class="form-control"
                                       pattern="^(?:254|\+254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$">

                                @error('mpesa_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="nominee_number"
                                       title="This number will be used to create an account and will be awarded earnings from the airtime transaction. Only Safaricom numbers are currently supported.">
                                    Nominee
                                    Number
                                    <span class="fa fa-info-circle"
                                          title="This number will be used to create an account and will be awarded earnings from the airtime transaction. Only Safaricom numbers are currently supported."></span>
                                </label>
                                <input type="tel" name="nominee_number" required value="{{ old('nominee_number') }}"
                                       placeholder="Nominee Number"
                                       title="254/07/7/01/1 123 12345" id="mpesa_number" class="form-control"
                                       pattern="^(?:254|\+254|0)?((?:(?:7(?:(?:[01249][0-9])|(?:5[789])|(?:6[89])))|(?:1(?:[1][0-5])))[0-9]{6})$">

                                @error('nominee_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <button type="submit" class="button button-primary">Proceed</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div> <!-- end home-content -->

    <ul class="home-social-list">
        <li>
            <a target="_blank" href="https://www.facebook.com/SidoohApp"><i class="fa fa-facebook-square"></i></a>
        </li>
        <li>
            <a target="_blank" href="https://twitter.com/SidoohApp"><i class="fa fa-twitter"></i></a>
        </li>
        <li>
            <a target="_blank" href="https://www.instagram.com/sidoohapp/ "><i class="fa fa-instagram"></i></a>
        </li>

    </ul>
    <!-- end home-social-list -->

</section> <!-- end home -->

<div id="preloader">
    <div id="loader"></div>
</div>

<!-- Java Script
    ================================================== -->
<script src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>


</body>
</html>
