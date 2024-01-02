<!-- 404 section -->
<!-- header -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> {{ $general->siteName(__('404')) }}</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

    <style>
        .erro-body {
            height: 100vh;
        }
    </style>
</head>

<body>

    <!--==================== Preloader Start ====================-->
    @include('presets.default.components.loader')

    <!--==================== Preloader End ====================-->

    <!--========================== Sidebar mobile menu wrap End ==========================-->
    <section class="account">
        <div class="account-inner">
            <div class="container">
                <div class="row gy-4 justify-content-center align-items-center" style="height: 90vh">
                    <div class="col-lg-6">
                        <div class="error-wrap text-center">
                            <div>
                                <div class="eye"></div>
                                <div class="eye"></div>
                            </div>
                            <div class="error__text">
                                <span>@lang('4')</span>
                                <span>@lang('0')</span>
                                <span>@lang('4')</span>
                            </div>
                            <!-- <div class="404-thumb">
                            <img src="assets/images/common/error-img.png" alt="404-img">
                        </div> -->
                            <h2 class="error-wrap__title mb-3">@lang('Page Not Found')</h2>
                            <p class="error-wrap__desc">@lang('Page you are looking have been deleted or does not exist')</p>
                            <a href="{{route('home')}}" class="btn btn--base">
                                <i class="la la-undo"></i>@lang('Go Home') 
                                <span style="top: 212.016px; left: 168px;"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  404 section /> -->


    <!-- footer -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

</body>

</html>
