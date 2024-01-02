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
                        <div class="auto-load text-center mt-5 mb-4" style="display: none;">
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
        <div class="modal fade report_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form id="report_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Report')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" class="set-modal-post-id" hidden name="id">
                                <label for="message-text" class="col-form-label">@lang('Reason:')</label>
                                <textarea class="form-control reason" name="reason" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="report_sent btn btn-success">@lang('Send')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                $(".post_vote").on('click', function() {
                    var auth = @json(auth()->check());
                    if (auth) {
                        var url = "{{ route('post.vote') }}";
                        var token = '{{ csrf_token() }}';
                        var id = $(this).data("post-id");
                        var data = {
                            post_id: id,
                            vote: $(this).data("post-vote"),
                            _token: token
                        }
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(data) {
                                $(".total_post_vote" + id).find('h6').text(data);
                            },
                            error: function(data, status, error) {
                                $.each(data.responseJSON.errors, function(key, item) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: item
                                    })
                                });

                            }
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Please Log into your account'
                        })
                    }
                });

                $(".bookmark-button").on('click', function() {
                    var auth = @json(auth()->check());
                    if (auth) {
                        var url = "{{ route('post.bookmark') }}";
                        var token = '{{ csrf_token() }}';
                        var id = $(this).data("post-id");
                        var this_data = $(this);
                        var data = {
                            post_id: id,
                            _token: token
                        }
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(data) {
                                if (data.status && data.status == "saved") {
                                    this_data.addClass("active-bookmark");
                                    var icon = this_data.find("i");
                                    if (icon.hasClass("fa-solid")) {
                                        icon.removeClass("fa-solid")
                                            .addClass("fa-regular");
                                    } else {
                                        icon.removeClass("fa-regular")
                                            .addClass("fa-solid");
                                    }
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    })
                                } else {
                                    this_data.removeClass("active-bookmark");
                                    var icon = this_data.find("i");
                                    if (icon.hasClass("fa-solid")) {
                                        icon.removeClass("fa-solid")
                                            .addClass("fa-regular");
                                    } else {
                                        icon.removeClass("fa-regular")
                                            .addClass("fa-solid");
                                    }
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    })

                                }
                            },
                            error: function(data, status, error) {
                                $.each(data.responseJSON.errors, function(key, item) {
                                    Toast.fire({
                                        icon: 'error',
                                        title: item
                                    })
                                });
                            }
                        });
                    } else {
                        $(".toast-container").addClass('d-none');
                        Toast.fire({
                            icon: 'error',
                            title: 'Please Log into your account'
                        })
                    }
                });

                $(".report_button").on('click', function() {
                    var auth = @json(auth()->check());
                    if (auth) {
                        var id = $(this).data("post-id");
                        $(".set-modal-post-id").val(id);
                        $(".report_modal").modal('show');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Please Log into your account'
                        })
                    }
                });

                $("form#report_form").submit(function(event) {
                    event.preventDefault();
                    var reason = $(".reason").val();
                    var id = $(".set-modal-post-id").val();
                    var url = "{{ route('post.report') }}";
                    var token = '{{ csrf_token() }}';
                    var this_data = $(this);
                    var data = {
                        reason: reason,
                        post_id: id,
                        _token: token
                    }
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        success: function(data) {
                            $(".report_modal").modal('hide');
                            $(".reason").val('');
                            Toast.fire({
                                icon: data.status,
                                title: data.message
                            })
                        },
                        error: function(data, status, error) {
                            $.each(data.responseJSON.errors, function(key,
                                item) {
                                Toast.fire({
                                    icon: 'error',
                                    title: item
                                })
                            });
                        }
                    });
                })
            });

        })(jQuery);
    </script>

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
