@forelse ($posts as $post)
    <div class="forum-card">
        @php
            $existVote = @$post->votes?->where('user_id', auth()->id())->first();
        @endphp

        <div class="vote-item vote-qty">
            <div class="vote-item-wraper">
                <button class="vote-qty__increment post_vote @if ($existVote != null && $existVote->like) active-upvote @endif"
                    data-post-id="{{ $post->id }}" data-post-vote="1">
                    <i class="fa-circle-up @if ($existVote != null && $existVote->like) fa-solid @else fa-regular @endif"></i>
                </button>

                <div class="vote-value-container total_post_vote{{ $post->id }}" data-post-id="{{ $post->id }}">
                    <h6 class="vote-qty__value">
                        {{ __(number_format_short(@$post->votes?->where('like', 1)->count() - @$post->votes?->where('unlike', 1)->count())) }}
                    </h6>
                </div>
                <button class="vote-qty__decrement post_vote @if ($existVote != null && $existVote->unlike) active-downvote @endif"
                    data-post-id="{{ $post->id }}" data-post-vote="0">
                    <i class="fa-circle-down @if ($existVote != null && $existVote->unlike) fa-solid @else fa-regular @endif"></i>
                </button>
            </div>
        </div>

        <div class="card--body">
            <div class="card-auth-meta">
                <div class="auth-info">
                    <a href="{{ route('user.profile.details', $post->user?->id) }}">
                        <div class="user-thumb">
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$post->user?->image, getFileSize('userProfile')) }}"
                                alt="avatar">
                        </div>
                        <p class="post-by">@lang('Posted by')
                            <span>{{ __(@$post->user?->fullname) }}</span>
                        </p>
                    </a>
                    <i class="fa-solid fa-circle"></i>
                    <p title="{{ showDateTime(@$post->created_at, 'd M, Y h:i A') }}" class="time-status">{{ diffForHumans($post->created_at) }}</p>
                    
                    @if(@$post->job)<i class="fa-solid fa-circle"></i><p class="time-status">@lang('Deadline'): {{ showDateTime(@$post->deadline, 'd M, Y')}}</p>@endif
                   
                </div>
                <div class="actn-dropdown-box">
                    <button class="actn-dropdown-btn">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <div class="actn-dropdown option">
                        <ul>
                            <li>
                                <button class="report_button report_post_button" data-post-id={{ @$post->id }}>
                                    <i class="fa-regular fa-flag"></i>
                                    <span>@lang('Report')</span>
                                </button>
                            </li>
                            @if (auth()->user() && $post->user_id == auth()->id())
                                <li>
                                    <a href="{{ route('user.post.edit', @$post->id) }}" class="edit_button">
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
                <a href="{{ route('post.details', $post->id) }}">
                    <h6 class="card-title {{ @$post->job ? 'mb-0' : '' }}">{{ __(@$post->title) }} </h6>
                </a>
                @if (@$post->job)
                    <div class="job-time-line">
                        <p>{{ __(gs()->cur_sym) }} {{ __(@$post->salary) }}</p>
                    </div>
                @endif

                <p class="card-sub-title wyg">{{ substr(strip_tags($post->content), 0, 190) }}
                    @if (strlen(strip_tags($post->content)) > 190)
                        ... <a href="{{ route('post.details', $post->id) }}" class="btn-sm p-1"><u>
                                @lang('See More')</u></a>
                    @endif
                </p>
            </div>
            <div class="forum-cad-footer">
                <ul class="footer-item-list">
                    <li>
                        <a href="{{ route('post.details', $post->id) }}"><i class="las la-comments"></i>
                            <p>{{ number_format_short(@$post->comments?->count()) }}
                                @if ($post->text === 1)
                                    @lang('Answers')
                                @else
                                    @lang('Comments')
                                @endif
                            </p>
                        </a>
                    </li>
                    <li><a href="{{ route('post.details', $post->id) }}"><i class="las la-eye"></i>
                            <p>{{ number_format_short(@$post->views) }} @lang('Views')</p>
                        </a></li>
                    <li>
                        <!--  -->
                        <div class="actn-dropdown-box">
                            <button class="actn-dropdown-btn">
                                <i class="las la-share"></i>
                                <span> @lang('Share')</span>
                            </button>
                            <div class="actn-dropdown">
                                <ul>
                                    <li>
                                        <a target="_blank" class="report_button"
                                            href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug(@$post->title) }}">
                                            <i class="fa-brands fa-facebook-f"></i>
                                            <span class="ms-3">@lang('Facebook')</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a target="_blank" class="report_button"
                                            href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug(@$post->title) }}&source=behands">
                                            <i class="fa-brands fa-linkedin-in"></i>
                                            <span class="ms-3">@lang('Linkedin')</span>
                                        </a>

                                    </li>
                                    <li class="report_button">
                                        <a target="_blank" class="report_button"
                                            href="https://twitter.com/intent/tweet?status={{ slug(@$post->title) }}+{{ Request::url() }}">
                                            <i class="fa-brands fa-twitter"></i>
                                            <span class="ms-3">@lang('Twitter')</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <!--  -->
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="me-3 report_button report_post_button" data-post-id={{ @$post->id }}><i
                            class="fa-regular fa-flag"></i>
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
                            class="fa-regular fa-bookmark @if (auth()->user()) @if (
                                @$post->bookmarks?->first()->user_id == auth()->user()->id &&
                                    @$post->bookmarks->first()->type == auth()->user()->type) 
                                fa-solid @endif @endif"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@empty
@endforelse
