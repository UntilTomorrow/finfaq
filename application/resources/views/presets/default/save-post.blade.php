@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section>
        <!-- header -->
        @include('presets.default.components.header')
        @include('presets.default.components.sidenav')

        <!-- body -->
        <div class="body-section">
            <div class="container-fluid">
                <div class="row m-0">
                    <!-- left side -->
                    @include('presets.default.components.leftside')
                    <!-- left side / -->
                    
                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="forum-card-wraper">
                                    @include('presets.default.components.main')
                                </div>
                            </div>
                        </div>

                        <!-- Data Loader -->
                        <div class="auto-load text-center mt-5 mb-3" style="display: none;">
                            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="60"
                                viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                <path fill="#000"
                                    d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate"
                                        dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                </path>
                            </svg>
                        </div>
                    </div>
                    {{-- main content / --}}


                    <!-- right side -->
                    <div class="col-lg-3">
                        <aside class="rightside-bar">
                            @include('presets.default.components.community_state')
                            @include('presets.default.components.popular')
                        </aside>
                    </div>
                    <!-- right side /-->

                </div>
            </div>
        </div>
        
         {{-- report modal --}}
        @include($activeTemplate . 'components.report-modal')

    </section>
@endsection
@include($activeTemplate . 'common.post-vote-report-js')

@push('script')
    <script>
        var ENDPOINT = "{{ url()->current() }}";
        var page = 1;

        /*------------------------------------------
        --------------------------------------------
        Call on Scroll
        --------------------------------------------
        --------------------------------------------*/
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 20)) {
                page++;
                infinteLoadMore(page);
            }
        });

        /*------------------------------------------
        --------------------------------------------
        call infinteLoadMore()
        --------------------------------------------
        --------------------------------------------*/
        function infinteLoadMore(page) {
            $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        $('.auto-load').show();
                    }
                })
                .done(function(response) {
                    if (response.html == '') {
                        $('.auto-load').html("<h5>No Data Found.</h5>");
                        return;
                    }

                    $('.auto-load').hide();
                    $(".forum-card-wraper").append(response.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {});
        }
    </script>
@endpush
