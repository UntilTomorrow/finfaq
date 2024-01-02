@php
    $existVote = @$post->votes?->where('user_id', auth()->id())->first();
@endphp
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
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="forum-details-card-wraper">
                                    <div class="forum-details-card">
                                        <div class="card--body">
                                            <div class="card-auth-meta">
                                                <div class="auth-info">
                                                    <a href="{{ route('user.profile.details', @$post->user?->id) }}">
                                                        <div class="user-thumb">
                                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$post->user?->image, getFileSize('userProfile')) }}"
                                                                alt="avatar">
                                                        </div>
                                                        <p class="post-by">
                                                            @lang('Posted by')<span> {{ __(@$post->user?->fullname) }}</span>
                                                        </p>
                                                    </a>
                                                    <i class="fa-solid fa-circle"></i>
                                                    <p class="time-status">
                                                        {{ __(showDateTime(@$post->created_at, 'd M, Y')) }},
                                                    </p>
                                                    @if (@$post->created_at != @$post->updated_at && @$post->created_at < @$post->updated_at)
                                                        <p class="time-status">@lang('Updated at')
                                                            {{ __(showDateTime($post->updated_at, 'd M, Y')) }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="actn-dropdown-box">
                                                    <button class="actn-dropdown-btn">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <div class="actn-dropdown option">
                                                        <ul>
                                                            <li>
                                                                <button class="me-3 report_button report_post_button"
                                                                    data-post-id={{ @$post->id }}><i
                                                                        class="fa-regular fa-flag"></i>
                                                                    <span> @lang('Report')</span>

                                                                </button>
                                                            </li>
                                                            @if (auth()->user() && $post->user_id == auth()->id())
                                                                <li>
                                                                    <a class="report_button"
                                                                        href="{{ route('user.post.edit', @$post->id) }}">
                                                                        <i class="fa-solid fa-pencil"></i>
                                                                        <span>@lang('Edit')</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card-content">
                                                <h6 class="card-title">{{ __(@$post->title) }}</h6>

                                                {{--  --}}
                                                @if ($post->images->count() > 0)
                                                    @if ($post->images->count() == 1)
                                                        <div class="gallery-img single-img">
                                                            <div class="main-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                        alt="image">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @elseif($post->images->count() == 2)
                                                        <div class="gallery-img double-img">
                                                            <div class="main-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                        alt="image">
                                                                </a>
                                                            </div>

                                                            <div class="main-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[1]->path . $post->images[1]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[1]->path . $post->images[1]->image, getFileSize('posts')) }}"
                                                                        alt="image">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @elseif($post->images->count() == 3)
                                                        <div class="gallery-img">
                                                            <div class="main-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                        alt="image">
                                                                </a>
                                                            </div>
                                                            <div class="sub-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[1]->path . $post->images[1]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[1]->path . $post->images[1]->image, getFileSize('posts')) }}"
                                                                        alt="image" /></a>

                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[2]->path . $post->images[2]->image, getFileSize('posts')) }}"
                                                                    class="glightbox more--img more--none"
                                                                    data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[2]->path . $post->images[2]->image, getFileSize('posts')) }}"
                                                                        alt="image" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="gallery-img">
                                                            <div class="main-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[0]->path . $post->images[0]->image, getFileSize('posts')) }}"
                                                                        alt="image">
                                                                </a>
                                                            </div>
                                                            <div class="sub-img">
                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[1]->path . $post->images[1]->image, getFileSize('posts')) }}"
                                                                    class="glightbox" data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[1]->path . $post->images[1]->image, getFileSize('posts')) }}"
                                                                        alt="image"></a>

                                                                <a href="{{ getImage(getFilePath('posts') . $post->images[2]->path . $post->images[2]->image, getFileSize('posts')) }}"
                                                                    class="glightbox more--img"
                                                                    data-glightbox="type: image"><img
                                                                        src="{{ getImage(getFilePath('posts') . $post->images[2]->path . $post->images[2]->image, getFileSize('posts')) }}"
                                                                        alt="image">
                                                                        <h6>@lang('+'){{$post->images->count() - 3}}</h6>
                                                                    </a>

                                                                <div class="more-img d-none">
                                                                    @forelse ($post->images->slice(3) as $image)
                                                                        <a href="{{ getImage(getFilePath('posts') . $image->path . $image->image, getFileSize('posts')) }}"
                                                                            class="glightbox more--img"
                                                                            data-glightbox="type: image"><img
                                                                                src="{{ getImage(getFilePath('posts') . $image->path . $image->image, getFileSize('posts')) }}"
                                                                                alt="image"></a>

                                                                    @empty
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                {{--  --}}

                                                <!-- Click photo to check out the modal -->


                                                @if ($post->job == 1)
                                                    <div class="job-time-line">
                                                        <p>{{ __($general->cur_sym) }}{{ showAmount($post->salary) }},
                                                        </p>
                                                        <p>{{ __(showDateTime(@$post->deadline, 'd M, Y')) }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <p>@lang('Vacancy:') {{ $post->vacancy }}</p>
                                                    </div>
                                                @endif
                                                <div class="wyg">@php echo  __(@$post->content) ; @endphp</div>
                                            </div>
                                            <div class="forum-cad-footer">
                                                <ul class="footer-item-list">
                                                    <li>
                                                        <div class="footer-item comment-voting vote-qty">
                                                            <button
                                                                class="vote-qty__increment post_vote @if ($existVote != null && $existVote->like) active-upvote @endif"
                                                                data-post-id="{{ $post->id }}" data-post-vote="1">
                                                                <i
                                                                    class="fa-circle-up @if ($existVote != null && $existVote->like) fa-solid @else fa-regular @endif"></i>
                                                            </button>
                                                            <div class="total_post_vote{{ $post->id }}"
                                                                data-post-id="{{ $post->id }}">
                                                                <span class="vote-qty__value">
                                                                    {{ __(number_format_short($post->votes->where('like', 1)->count() - $post->votes->where('unlike', 1)->count())) }}
                                                                </span>
                                                            </div>
                                                            <button
                                                                class="vote-qty__decrement post_vote @if ($existVote != null && $existVote->unlike) active-downvote @endif"
                                                                data-post-id="{{ $post->id }}" data-post-vote="0">
                                                                <i
                                                                    class="fa-circle-down @if ($existVote != null && $existVote->unlike) fa-solid @else fa-regular @endif"></i>
                                                            </button>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="footer-item">
                                                            <i class="las la-comments"></i>
                                                            <p id="postCommentCount">
                                                                {{ number_format_short(@$post->comments?->count()) }}
                                                                @if ($post->text === 1)
                                                                    @lang('Answers')
                                                                @else
                                                                    @lang('Comments')
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="footer-item">
                                                            <i class="las la-eye"></i>
                                                            <p>{{ number_format_short(@$post->views) }} @lang('Views')
                                                            </p>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <!--  -->
                                                        <div class="actn-dropdown-box">
                                                            <button class="actn-dropdown-btn"><i
                                                                    class="las la-share"></i>
                                                                    <span> @lang('Share')</span>
                                                            </button>
                                                            @if (@$post->job == 1 && auth()->id() != @$post->user_id)
                                                                @if (@$post->deadline > now()->format('Y-m-d'))
                                                                    <button type="button" class="btn btn--base mx-4"
                                                                        onclick="applyModal(this)">
                                                                        <i class="las la-plane-departure"></i>
                                                                        @lang('Apply')
                                                                    </button>
                                                                @endif
                                                            @endif
                                                            <div class="actn-dropdown">
                                                                <ul>
                                                                    <li>
                                                                        <a target="_blank" class="report_button"
                                                                            href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug(@$post->title) }}">
                                                                            <i class="fa-brands fa-facebook-f"></i>
                                                                            <span>@lang('Facebook')</span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a target="_blank" class="report_button"
                                                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug(@$post->title) }}&source=behands">
                                                                            <i class="fa-brands fa-linkedin-in"></i>
                                                                            <span>@lang('Linkedin')</span>
                                                                        </a>

                                                                    </li>
                                                                    <li>
                                                                        <a target="_blank" class="report_button"
                                                                            href="https://twitter.com/intent/tweet?status={{ slug(@$post->title) }}+{{ Request::url() }}">
                                                                            <i class="fa-brands fa-twitter"></i>
                                                                            <span>@lang('Twitter')</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!--  -->
                                                    </li>
                                                </ul>
                                                <button class="me-3 report_post_button report_button"
                                                    data-post-id={{ @$post->id }}><i class="fa-regular fa-flag"></i>
                                                </button>
                                                <button
                                                    class="bookmark-button
                                                    @if (auth()->user()) @if (
                                                        @$post->bookmarks?->first()->user_id == auth()->user()->id &&
                                                            @$post->bookmarks?->first()->type == auth()->user()->type) 
                                                            active-bookmark @endif
                                                    @endif"
                                                    data-post-id="{{ $post->id }}" type="button">
                                                    <i
                                                        class="fa-regular fa-bookmark 
                                                        @if (auth()->user()) @if (
                                                            @$post->bookmarks?->first()->user_id == auth()->user()->id &&
                                                                @$post->bookmarks->first()->type == auth()->user()->type) 
                                                                fa-solid @endif
                                                        @endif">
                                                    </i>
                                                </button>

                                                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                                                    <div class="toast" role="alert" aria-live="assertive"
                                                        aria-atomic="true">
                                                        <div class="toast-header">
                                                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$post->user?->image, getFileSize('userProfile')) }}"
                                                                class="rounded me-2" alt="...">
                                                            <strong
                                                                class="me-auto">{{ __(strLimit(@$post->title, 40)) }}</strong>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="toast" aria-label="Close"></button>
                                                        </div>
                                                        <div class="toast-body{{ @$post->id }}">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($post->comments->where('parent_comment_id', null) as $single_comment)
                                                @if ($single_comment->status)
                                                    <div class="single-comment">
                                                        @include('presets/default/components/comment', [
                                                            'single_comment' => $single_comment,
                                                            'count' => 0,
                                                        ])
                                                    </div>
                                                @endif
                                            @endforeach

                                            @if (auth()->user())
                                                <div class="single-comment-replay">
                                                    <div class="auth-info">
                                                        <a href="#">
                                                            <div class="user-thumb">
                                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                                                                    alt="avatar">
                                                            </div>
                                                            <p class="post-by">
                                                                <span>{{ __(@$post?->user?->fullname) }}</span>
                                                            </p>
                                                        </a>
                                                    </div>
                                                    <div class="comment-text">
                                                        <form>
                                                            <div class="form-group">
                                                                <input type="text" name="post_id" hidden
                                                                    value="{{ @$post->id }}">
                                                                <input type="text" name="parent_comment_id" hidden
                                                                    value="">
                                                                <textarea placeholder="" class="form--control comment-replay-field" id="comment-field" name="comment"
                                                                    onkeypress="singleCommentSubmit(this)"></textarea>
                                                                <label class="form--label">
                                                                    @if ($post->text === 1)
                                                                        @lang('Write Your Answer')
                                                                    @else
                                                                        @lang('Write Your Comments')
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </section>

    {{-- apply job modal --}}
    <div class="modal fade apply_job" id="applyJobModal" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Apply Job')</h5>
                    <button type="button" class="btn-close" onclick="applyModalClose()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('user.apply.job.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <input type="text" class="form-control" hidden name="post_id"
                                    value={{ @$post->id }}>

                                <div class="form-group mb-3">
                                    <label class="form-label mb-3 required" for="amount">@lang('Expect-salary:')</label>
                                    <div class="input-group country-code">
                                        <span class="input-group-text">{{ __(@$general->cur_text) }}</span>
                                        <input type="number" step="any" name="expect_salary"
                                            class="form-control form--control" required id="amount">
                                    </div>
                                </div>

                                <label class="col-form-label">@lang('Resume:')</label>
                                <input type="file" class="form-control" accept=".pdf,.doc,.docx" name="file"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('Send')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- report modal --}}
    <div class="modal fade post_report_modal" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="post_report_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="set_post_modal_post_id" hidden name="post_id">
                            <label for="report-modal" class="col-form-label">@lang('Reason:')</label>
                            <textarea class="form-control post-reason" name="reason" id="report-modal"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success post-details-report-modal">@lang('Send')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- report modal comment --}}
    <div class="modal fade comment_report_modal" id="exampleModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="comment_report_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Report')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="text" class="set-comment-modal_post-id" hidden name="post_id">
                            <input type="text" class="set-comment-modal_comment-id" hidden name="comment_id">

                            <label for="message-text" class="col-form-label">@lang('Reason'):</label>
                            <textarea class="form-control comment_reason" name="reason" id="message-text"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">@lang('Send')</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                "use strict";
                // post votes
                $(document).on('click', '.post_vote', function() {
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
                                $(".total_post_vote" + id).find('span').text(data);
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
                })

                // comment votes
                $(document).on('click', '.comment_vote', function() {
                    var auth = @json(auth()->check());
                    if (auth) {
                        var url = "{{ route('comment.vote') }}";
                        var token = '{{ csrf_token() }}';
                        var id = $(this).data("comment-id");

                        var data = {
                            comment_id: id,
                            vote: $(this).data("comment-vote"),
                            _token: token
                        }
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function(data) {
                                $(".total_comment_vote" + id).text(data);
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
                })

                // boorkmark post
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
                            title: "Please Log into your account."
                        })
                    }


                });

                // report post button
                $(".report_post_button").on('click', function() {
                    var auth = @json(auth()->check());
                    if (auth) {
                        var id = $(this).data("post-id");
                        $(".set_post_modal_post_id").val(id);
                        $(".post_report_modal").modal('show');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Please Log into your account'
                        })
                    }

                });

                // report post 
                $("form#post_report_form").on('submit', function(event) {

                    event.preventDefault();
                    var id = $(".set_post_modal_post_id").val();
                    var reason = $(".post-reason").val();
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
                            $(".post_report_modal").modal('hide');
                            $(".post_report_modal").find('form')[0].reset();
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

                // report comment button
                $(document).on('click', '.report_comment_button', function() {
                    var auth = @json(auth()->check());
                    if (auth) {
                        var comment_id = $(this).data("comment-id");
                        var post_id = $(this).data("post-id");
                        $(".set-comment-modal_post-id").val(post_id);
                        $(".set-comment-modal_comment-id").val(comment_id);
                        $(".comment_report_modal").modal('show');
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Please Log into your account'
                        })
                    }

                });

                // report comment 
                $("form#comment_report_form").on('submit', function(event) {
                    event.preventDefault();
                    var reason = $(".comment_reason").val();
                    var post_id = $(".set-comment-modal_post-id").val();
                    var comment_id = $(".set-comment-modal_comment-id").val();
                    var url = "{{ route('comment.report') }}";
                    var token = '{{ csrf_token() }}';
                    var data = {
                        reason: reason,
                        comment_id: comment_id,
                        post_id: post_id,
                        _token: token
                    }
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        success: function(data) {
                            $(".comment_report_modal").modal('hide');
                            $(".comment_report_modal").find('form')[0].reset();
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

                // delete comment
                $(document).on('click', '.delete_comment', function() {
                    const actn_dropdown = $(this).closest('.actn-dropdown').removeClass(
                        'is-open-actn-dropdown');
                    const dataCommentId = $(this).data('comment');
                    const dataPostId = $(this).data('post');
                    const thisTag = $(this);
                    const url = "{{ route('comment.delete') }}";
                    const token = '{{ csrf_token() }}';
                    const data = {
                        post_id: dataPostId,
                        comment_id: dataCommentId,
                        _token: token
                    }
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        success: function(data) {
                            var nestedComment = thisTag.closest('.comment-card-footer')
                                .closest('.comment-text').closest('.nested-comment');
                            if (nestedComment.length == 0) {
                                // that means its single comment
                                var singleComment = thisTag.closest('.comment-card-footer')
                                    .parent('.comment-text').parent('.single-comment')
                                    .remove();
                                var oldCountComment = parseInt($('#postCommentCount')
                                    .text());
                                $('#postCommentCount').text(oldCountComment - data
                                    .commentDeleteCount + " " + "Comments");

                            } else {

                                var allNestedComment = thisTag.closest(
                                    '.comment-card-footer').parents(
                                    '.nested-comment');

                                replyCommentCountDelete(thisTag, data,
                                    allNestedComment);

                                var type = 'delete';
                                postCommentCount(data, type);
                                nestedComment.closest('.nested-comment-wraper').remove();
                            }

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

        // Single comment create
        function singleCommentSubmit(object) {
            const dataReply = $(object).data('reply');
            const dataEdit = $(object).data('edit');
            if (dataReply != 'reply' && dataEdit != 'edit') {
                $(object).attr('data-comment', 'comment');
            }
            if (event.which == 13 && $(object).data('comment') == 'comment') {
                var data = {
                    post_id: $(object).siblings('input[name=post_id]').val(),
                    parent_comment_id: $(object).siblings('input[name=parent_comment_id]').val(),
                    comment: $(object).val(),
                    _token: '{{ csrf_token() }}'
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment') }}",
                    data: data,
                    success: function(data) {
                        var SingleCommentReply = $(object).closest(".single-comment-replay");
                        SingleCommentReply.before(` 
                                <div class="single-comment"> 
                                    ${data.html} 
                                </div>
                            `);
                        $(object).val('');
                        $(object).removeAttr('data-comment');

                        var type = "create";
                        postCommentCount(data, type)
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
                return false;
            }
        }

        // Reply comment create
        function replyComment(object, event) {
            var auth = @json(auth()->check());
            if (auth) {
                var allReplayCommentField = $('.replay-comment-field').removeClass('show-comment-field');
                var findTextarea = $(object).closest(".comment-card-footer").siblings(".replay-comment-field-reply").find(
                        'form')
                    .find("textarea[name=comment]");
                findTextarea.attr('data-action', 'reply');
                findTextarea.val('');
                $(object).closest(".comment-card-footer").siblings(".replay-comment-field-reply").toggleClass(
                    "show-comment-field");
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Please Log into your account'
                })
            }

        }

        // Reply comment submit
        function ReplyCommentSubmit(object, event) {

            if (event.which == 13 && $(object).data('action') === 'reply') {
                var data = {
                    post_id: $(object).siblings('input[name=post_id]').val(),
                    comment_id: $(object).siblings('input[name=comment_id]').val(),
                    comment: $(object).val(),
                    _token: '{{ csrf_token() }}'
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment.replay') }}",
                    data: data,
                    success: function(data) {
                        var nestedCommentWrapper = $(object).closest(".replay-comment-field").parents(
                            '.nested-comment-wraper');
                        if (nestedCommentWrapper.length < 4) {
                            $(object).closest(".replay-comment-field").parent(
                                '.comment-text').append(`
                                    <div class="nested-comment-wraper">
                                        <div class="nested-comment">
                                            ${data.html}
                                        </div>
                                    </div>
                                `);
                        }


                        $(object).val('');
                        $(object).closest(".replay-comment-field").toggleClass("show-comment-field");

                        var allNestedComment = $(object).closest(
                            '.replay-comment-field-reply');

                        replyCommentCountCreate(allNestedComment);
                        var type = 'create';
                        postCommentCount(data, type);

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
            }

            if (event.which == 13 && $(object).data('action') === 'edit') {

                var data = {
                    comment_id: $(object).siblings('input[name=comment_id]').val(),
                    comment: $(object).val(),
                    _token: '{{ csrf_token() }}'
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment.edit') }}",
                    data: data,
                    success: function(data) {
                        var commentText = $(object).closest('.replay-comment-field').parent('.comment-text')
                            .find('p').first();

                        commentText.text(data.comment.comment);

                        $(object).closest(".replay-comment-field").toggleClass("show-comment-field");
                        $(object).removeAttr('data-edit');

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
            }
        }

        // Edit comment create
        function editComment(object) {
            var allReplayCommentField = $('.replay-comment-field').removeClass('show-comment-field');

            const actn_dropdown = $(object).closest('.actn-dropdown').removeClass('is-open-actn-dropdown');
            const data = $(object).closest('.comment-text').find('p').first().text();
            const findTextarea = $(object).closest('.comment-card-footer').siblings(".replay-comment-field-edit").find(
                    'form')
                .find('textarea[name=comment]');
            findTextarea.val(data);
            findTextarea.focus();
            findTextarea.attr('data-action', 'edit');

            $(object).closest('.comment-card-footer').siblings(".replay-comment-field-edit").toggleClass(
                "show-comment-field");

        }

        function editReplyCommentSubmit(object, event) {
            if (event.which == 13 && $(object).data('action') === 'edit') {
                var data = {
                    comment_id: $(object).siblings('input[name=comment_id]').val(),
                    comment: $(object).val(),
                    _token: '{{ csrf_token() }}'
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment.edit') }}",
                    data: data,
                    success: function(data) {
                        var commentText = $(object).closest('.replay-comment-field').parent('.comment-text')
                            .find('p').first();
                        commentText.text(data.comment.comment);

                        $(object).closest(".replay-comment-field").toggleClass("show-comment-field");
                        $(object).removeAttr('data-edit');

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
            }
        }

        // Reply-comment (comment count) create
        function replyCommentCountCreate(allNestedComment) {
            $.each(allNestedComment.parents('.nested-comment'), function(index,
                value) {
                // reply-comment (comment reply) count create 

                $(value).children('.comment-text').children(
                    '.comment-card-footer').children(
                    '.user-actn').find(
                    '.nestedCommentsCount').text(parseInt($(
                        value).children('.comment-text')
                    .children('.comment-card-footer')
                    .children('.user-actn').find(
                        '.nestedCommentsCount').text()) + 1 + " " + "Reply");
            });


            // single-comment (comment reply) count create 
            allNestedComment.parents(
                    '.single-comment').children('.comment-text')
                .children('.comment-card-footer').children('.user-actn')
                .find('.nestedCommentsCount').text(parseInt(allNestedComment.parents(
                            '.single-comment').children('.comment-text')
                        .children('.comment-card-footer').children(
                            '.user-actn').find('.nestedCommentsCount')
                        .text()) + 1 + " " +
                    "Reply");
        }

        // Reply-comment (comment count) delete
        function replyCommentCountDelete(thisTag, data, allNestedComment) {
            $.each(allNestedComment, function(index,
                value) {
                // reply-comment (comment reply) count delete 
                $(value).children('.comment-text').children(
                    '.comment-card-footer').children(
                    '.user-actn').find(
                    '.nestedCommentsCount').text(parseInt($(
                            value).children('.comment-text')
                        .children('.comment-card-footer')
                        .children('.user-actn').find(
                            '.nestedCommentsCount').text()
                    ) - data.commentDeleteCount + " " +
                    "Reply");
            });
            // single-comment (comment reply) count delete 
            thisTag.closest(
                    '.comment-card-footer').parents(
                    '.single-comment').children('.comment-text')
                .children('.comment-card-footer').children('.user-actn')
                .find('.nestedCommentsCount').text(parseInt(thisTag
                        .closest(
                            '.comment-card-footer').parents(
                            '.single-comment').children('.comment-text')
                        .children('.comment-card-footer').children(
                            '.user-actn').find('.nestedCommentsCount')
                        .text()) - data.commentDeleteCount + " " +
                    "Reply");
        }

        // single-comment (comment count) create or delete
        function postCommentCount(data, type) {
            if (type == "create") {
                //that single-comment (comment count) create
                var postCommentCount = $('#postCommentCount').text();
                postCommentCount = postCommentCount.replace(/\s/g, "");
                postCommentCount = parseInt(postCommentCount) + 1;
                $('#postCommentCount').text(number_format_short(postCommentCount));
            } else {
                //that single-comment (comment count) delete
                var postCommentCount = $('#postCommentCount').text();
                postCommentCount = postCommentCount.replace(/\s/g, "");
                postCommentCount = parseInt(postCommentCount) - data.commentDeleteCount;
                $('#postCommentCount').text(number_format_short(postCommentCount));
            }

        }

        // Number formate
        function number_format_short(postCommentCount) {
            var n_format;
            var suffix = '';
            if (postCommentCount >= 0 && postCommentCount < 1000) {
                // 1 - 999
                n_format = Math.floor(postCommentCount);
                suffix = '';
            } else if (postCommentCount >= 1000 && postCommentCount < 1000000) {
                // 1k-999k
                n_format = Math.floor(postCommentCount / 1000);
                $suffix = 'K+';
            } else if (postCommentCount >= 1000000 && postCommentCount < 1000000000) {
                // 1m-999m
                n_format = Math.floor(postCommentCount / 1000000);
                $suffix = 'M+';
            } else if (postCommentCount >= 1000000000 && postCommentCount < 1000000000000) {
                // 1b-999b
                n_format = Math.floor(postCommentCount / 1000000000);
                $suffix = 'B+';
            } else if (postCommentCount >= 1000000000000) {
                // 1t+
                n_format = Math.floor(postCommentCount / 1000000000000);
                $suffix = 'T+';
            }
            return n_format + suffix + " " + "Comments";
        }

        // Apply modal
        function applyModal(object) {
            var auth = @json(auth()->check());
            if (auth) {
                $('.apply_job').modal('show');

            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Please Log into your account'
                })
            }

        }

        // Apply modal close
        function applyModalClose() {
            var form = $('.apply_job').find('form');
            form.find('input[name=expect_salary]').val('');
            form.find('input[name=file]').val(null);
        }
    </script>
@endpush
