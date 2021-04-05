<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.includes.header')

<body>
{{--        @include('admin.includes.preloader')--}}

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<main class="main" id="top">
    <div class="container-fluid">

        @yield('content')

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
