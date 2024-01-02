<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('includes.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/common/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/common/css/line-awesome.min.css') }}">


    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/fontawesome-all.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <!-- Animate css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.min.css') }}">
    <!-- Odometer -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/emoji.css') }}">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">

    @stack('style-lib')

    @stack('style')
    <style>
        .cookies-card {
            position: fixed;
            bottom: 16px;
            width: 40%;
            padding: 20px;
            background: #fff;
            border: 2px solid #108ce6;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            right: 16px;
            z-index: 99;
            border: 2px solid #108ce6;
        }

        .dark-mode .cookies-card {
            background: #2d3748;
            border: 1px solid #404040;
        }

        @media (max-width:576px) {
            .cookies-card {
                width: 90%;
            }
        }
    </style>
    <link rel="stylesheet"
        href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}&secondColor={{ $general->secondary_color }}">
</head>

<body>
    @include('presets.default.components.loader')
    <section class="dashboard-section">
        <div class="dashboard">
            <div class="container-fluid">
                <div class="row">
                    <!-- < dashboard side bar -->
                    @include('presets.default.components.user.sidebar')
                    <!-- dashboard side bar /> -->
                    <div class="col-xxl-10 col-xl-9 col-lg-12">
                        <div class="dashboard-body">
                            <div class="dashboard-body__bar">
                                <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
                            </div>
                            <!-- < dashboard header -->
                            @include('presets.default.components.user.header')
                            <!-- dashboard header /> -->
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <div class="page-wrapper">

    </div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/common/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/common/js/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset($activeTemplateTrue . 'js/jquery.validate.js') }}"></script>

    @stack('script-lib')

    @include('includes.notify')

    @include('includes.plugins')


    @stack('script')


    <!-- Bootstrap Js -->
    <script src="{{ asset($activeTemplateTrue . 'js/bootstrap.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <!-- Magnific Popup js -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Odometer js -->
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <!-- Viewport js -->
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <!-- Emoji -->
    <script src="{{ asset($activeTemplateTrue . 'js/emojione.min.js') }}"></script>
    <!-- Appear -->
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.appear.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <!-- apex chart -->
    <script src="{{ asset($activeTemplateTrue . 'js/apexcharts.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
    

    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";

            $('form').on('submit', function() {
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            });

            var inputElements = $('[type=text],[type=password],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });


            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });


            let headings = $('.table th');
            let rows = $('.table tbody tr');
            let columns
            let dataLabel;

            $.each(rows, function(index, element) {
                columns = element.children;
                if (columns.length == headings.length) {
                    $.each(columns, function(i, td) {
                        dataLabel = headings[i].innerText;
                        $(td).attr('data-label', dataLabel)
                    });
                }
            });

        })(jQuery);
    </script>

</body>

</html>
