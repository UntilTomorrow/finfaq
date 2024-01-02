@push('script')
    <script>
        (function($) {
            "use strict"
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

                $("form#report_form").on('submit', function(event) {
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


        })(jQuery);
    </script>
@endpush
