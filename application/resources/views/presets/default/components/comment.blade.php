@php
    $existCommentVote = @$single_comment->votes?->where('user_id', auth()->id())->first();
@endphp

<div class="auth-info">
    <a href="{{ route('user.profile.details', @$single_comment->user?->id) }}">
        <div class="user-thumb">
            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$single_comment->user?->image, getFileSize('userProfile')) }}"
                alt="avatar">
        </div>
        <p class="post-by"><span>{{ __(@$single_comment?->user?->fullname) }}</span></p>
    </a>
    <i class="fa-solid fa-circle"></i>
    <p class="time-status">{{ __(showDateTime(@$single_comment->created_at, 'd M, Y')) }}</p>
</div>
<div class="comment-text">
    <p>{{ __(@$single_comment?->comment) }}</p>
    <div class="comment-card-footer">
        <ul class="user-actn">
            <li>
                <div class="comment-voting vote-qty">
                    <button
                        class="vote-qty__increment comment_vote @if ($existCommentVote != null && $existCommentVote->like) active-upvote @else fa-regular @endif"
                        data-comment-id="{{ $single_comment->id }}" data-comment-vote="1">
                        <i class="fa-circle-up @if ($existCommentVote != null && $existCommentVote->like) fa-solid @else fa-regular @endif"></i>
                    </button>
                    <span class="vote-qty__value total_comment_vote{{ $single_comment->id }}"
                        data-comment-id="{{ $single_comment->id }}">{{ __(number_format_short(@$single_comment->votes?->where('like', 1)->count() - @$single_comment->votes?->where('unlike', 1)->count())) }}</span>
                    <button
                        class="vote-qty__decrement comment_vote @if ($existCommentVote != null && $existCommentVote->unlike) active-downvote @endif"
                        data-comment-id="{{ $single_comment->id }}" data-comment-vote="0">
                        <i
                            class="fa-regular fa-circle-down @if ($existCommentVote != null && $existCommentVote->unlike) fa-solid @else fa-regular @endif"></i>
                    </button>
                </div>
            </li>
            <li>
                <button class="cmnt-reply-btn" onclick="replyComment(this, event);">
                    <i class="las la-comments"></i>
                    <span class="nestedCommentsCount">{{ __(@$single_comment->nested_comments_count()) }}
                        @lang('Reply')
                    </span>
                </button>
            </li>
            <li>
                <div class="actn-dropdown-box">
                    <button class="actn-dropdown-btn">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div class="actn-dropdown option">
                        <ul>
                            @if (auth()->user())
                                @if (auth()->user()->id == $single_comment->user_id && auth()->user()->type == $single_comment->type)
                                    <li class="edit_comment" style="cursor: pointer;" onclick="editComment(this);">
                                        <button class="usr-ctn-btn report_button">
                                            <i class="fa-solid fa-pencil"></i>
                                            <span>@lang('Edit')</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button class="delete_comment report_button"
                                            data-comment="{{ @$single_comment->id }}"
                                            data-post="{{ @$single_comment->post?->id }}" style="cursor: pointer;">
                                            <i class="fa-solid fa-trash-can"></i>
                                            <span>@lang('Delete')</span>
                                        </button>

                                    </li>
                                @elseif(auth()->guard('admin')->user())
                                    @if (auth()->user()->id == $single_comment->user_id && auth()->user()->type == $single_comment->type)
                                        <li class="edit_comment" data-comment="{{ @$single_comment->comment }}"
                                            style="cursor: pointer;" onclick="editComment(this);">
                                            <button class="usr-ctn-btn">
                                                <i class="fa-solid fa-pencil"></i>
                                                <span>@lang('Edit')</span>
                                            </button>
                                        </li>
                                        <li>
                                            <button class="delete_comment report_button"
                                                data-comment="{{ @$single_comment->id }}"
                                                data-post="{{ @$single_comment->post?->id }}" style="cursor: pointer;">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span>@lang('Delete')</span>
                                            </button>
                                        </li>
                                    @endif
                                @endif
                            @endif
                            <li class="report_comment_button" data-post-id={{ @$single_comment->post_id }}
                                data-comment-id={{ @$single_comment->id }}>
                                <button class="me-3 report_button"><i class="fa-regular fa-flag"></i>
                                    <span>@lang('Report')</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    {{-- ----------------------------------  Reply comment create ---------------------------------- --}}
    <div class="replay-comment-field replay-comment-field-reply">
        <div class="comment-in-replay">
            <div class="auth-info">
                <a href="#">
                    <div class="user-thumb">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                            alt="avatar">
                    </div>
                    <p class="post-by">
                        <span>{{ __(@$single_comment?->user?->fullname) }}</span>
                    </p>
                </a>
            </div>
            <div class="comment-text">
                <form>
                    <div class="form-group">
                        <input type="text" name="post_id" hidden value="{{ @$single_comment->post?->id }}">
                        <input type="text" name="comment_id" hidden value="{{ @$single_comment?->id }}">
                        <textarea placeholder="" class="form--control comment-replay-field" name="comment"
                            onkeypress="ReplyCommentSubmit(this,event)"></textarea>
                        <label class="form--label">
                            @if ($single_comment?->post?->text === 1)
                                @lang('Write Your Answer')
                            @else
                                @lang('Write Your Comments')
                            @endif

                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ---------------------------------- All comment edit ---------------------------------- --}}
    <div class="replay-comment-field replay-comment-field-edit">
        <div class="comment-in-replay">
            <div class="auth-info">
                <a href="#">
                    <div class="user-thumb">
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                            alt="avatar">
                    </div>
                    <p class="post-by">
                        <span>{{ __(@$single_comment?->user?->fullname) }}</span>
                    </p>
                </a>
            </div>
            <div class="comment-text">
                <form>
                    <div class="form-group">
                        <input type="text" name="post_id" hidden value="{{ @$single_comment->post?->id }}">
                        <input type="text" name="comment_id" hidden value="{{ @$single_comment?->id }}">
                        <textarea placeholder="" class="form--control comment-replay-field" name="comment"
                            onkeypress="editReplyCommentSubmit(this,event)"></textarea>
                        <label class="form--label">
                            @if ($single_comment?->post?->text === 1)
                                @lang('Write Your Answer')
                            @else
                                @lang('Write Your Comments')
                            @endif
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (@$single_comment->comments->count() > 0)
        @foreach ($single_comment->comments as $comment)
            @if ($comment->status)
                @php
                    $count += 1;
                @endphp
                @if ($count < 4)
                    <div class="nested-comment-wraper">
                        <div class="nested-comment">
                            @include('presets/default/components/comment', [
                                'single_comment' => $comment,
                                'count' => $count,
                            ])
                        </div>
                    </div>
                @endif
            @endif
        @endforeach
    @endif
</div>
