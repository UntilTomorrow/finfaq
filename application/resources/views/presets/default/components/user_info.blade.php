<div class="user-profile-box">
    <div class="user-profile-meta">
        <div class="user-thumb mb-1">
            <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user?->image, getFileSize('userProfile')) }}"
                alt="user-avatar">
        </div>
        <div class="user-content">
            <h6 class="user-name">{{ __(@$user?->fullname) }}</h6>
            <p class="user-join-date">{{ __(showDateTime($user?->created_at, 'd M, Y')) }}</p>
        </div>
    </div>

    <div class="community-item-wraper">
        <div class="community-item">
            <div class="item-status">
                <h5 class="count">{{ @$user?->credit }}</h5>
                <h6 class="item-status-title">@lang('Total Credit')</h6>
            </div>
            <div class="item-status">
                <h5 class="count">{{ @$user?->posts->count() }}</h5>
                <h6 class="item-status-title">@lang('Total Post')</h6>
            </div>
        </div>
        <div class="community-item">
            <div class="item-status">
                <h5 class="count">{{ @$user->total_topic() }}</h5>
                <h6 class="item-status-title">@lang('Total Topics')</h6>
            </div>
            <div class="item-status">
                <h5 class="count">{{ $user->all_post_comments_count() }}</h5>
                <h6 class="item-status-title">@lang('Total Replies')</h6>
            </div>
        </div>

    </div>

    <div class="user-social-meta">
        <h5>@lang('Social Network')</h5>
        <div class="d-flex">
            @if (@$user->social_link?->facebook)
                <div class="social-link-box">
                    <a href="{{ @$user->social_link?->facebook }}" target="_blank"><i
                            class="fa-brands fa-facebook-f"></i></a>
                </div>
            @endif
            @if (@$user->social_link?->twitter)
                <div class="social-link-box mx-4">
                    <a href="{{ @$user->social_link?->twitter }}" target="_blank"><i
                            class="fa-brands fa-twitter"></i></a>
                </div>
            @endif

            @if (@$user->social_link?->instagram)
                <div class="social-link-box">
                    <a href="{{ @$user->social_link?->instagram }}" target="_blank"><i
                            class="fa-brands fa-instagram"></i></a>
                </div>
            @endif
        </div>
    </div>

    @if (auth()->user() && !(auth()->id() == @$user->id))
        <div class="button-wraper pt-4">
            <!-- open chat btn -->
            <button class="btn btn--base chatBox-open-btn">@lang('Start Chat')</button>
        </div>
    @endif
</div>

<div class="popular-topics-box">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">@lang('Experience')</h5>
                @if (auth()->user() && auth()->id() === $user->id)
                    <a href="{{ route('user.experience.index') }}" class="btn btn--sm"><i
                            class="fa-solid fa-plus"></i></a>
                @endif
            </div>

            @if (count($user->experience))
                @foreach ($user->experience as $experience)
                    <div class="card w-100 mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-content-center mb-2">
                                <div>
                                    <h4 class="mb-2">{{ __(@$experience?->title) }}</h4>
                                    <p>{{ __(@$experience->company_name) }}</p>
                                </div>
                                @if (auth()->user() && auth()->id() === $user->id)
                                    <div class="text-end">
                                        <a href="{{ route('user.experience.edit', @$experience?->id) }}"
                                            class="info me-2"><i class="fa-solid fa-pen"></i></a>
                                        <a href="{{ route('user.experience.delete', @$experience?->id) }}"
                                            class="danger"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                @endif
                            </div>

                            <p>{{ __(showDateTime(@$experience?->start_date, 'M Y')) }}
                                @if (@$experience?->end_date)
                                    - {{ __(showDateTime(@$experience?->end_date, 'M Y')) }}
                                    . {{ myDiffForHumans(@$experience?->start_date, @$experience?->end_date) }}
                                @else
                                    @lang('- Present')
                                    . {{ myDiffForHumans(@$experience?->start_date, now()) }}
                                @endif
                            </p>

                        </div>
                    </div>
                @endforeach
            @else
                <p>@lang('Nothing to experience added')</p>
            @endif

        </div>
    </div>
</div>

@php
    $skills = json_decode(@$user->skills);
@endphp
<div class="popular-topics-box">
    <div class="user-social-meta mb-2">
        <h5>@lang('Skills')</h5>
        @if (@$user->skills)
            <div class="row">
                <div class="col-12">
                    @foreach ($skills as $skill)
                        <div class="skill-tag">
                            {{ $skill }}
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <span>@lang('Nothing to skill added')</span>
        @endif
    </div>
</div>


<!-- on screen chat box -->
<div class="chat-box">
    <!-- chat header -->
    <div class="chat-box-header">
        <div class="user-meta">
            <div class="user-thumb">
                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user?->image, getFileSize('userProfile')) }}"
                    alt="user-avatar" width="30">
            </div>
            <p class="user-id">{{ __(@$user?->username) }}</p>
        </div>
        <div class="user-actn">
            <button class="chat-box-min-btn"><i class="fa-solid fa-minus"></i></button>
            <button class="chat-box-close-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <!-- chat body -->
    <div class="chat-body">
        <div class="msg-list-wraper">
            @if (isset($chat) && $chat != '')
                @foreach ($chat as $message)
                    @if ($message->sender_id != auth()->id())
                        <div class="message-text">
                            <div class="text">
                                @if ($message->file)
                                    <a
                                        href="{{ route('user.chat.download.file', $message->id) }}">{{ $message->file }}</a>
                                @endif
                                <p>{{ __($message->message) }}</p>
                                <div class="msg-text-meta">
                                    <span
                                        class="text-dt">{{ __(showDateTime($message->created_at, 'd M, h:i A')) }}</span>
                                    <span><i class="fa-solid fa-check-double"></i></span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="message-text odd">
                            <div class="text">
                                @if ($message->file)
                                    <a
                                        href="{{ route('user.chat.download.file', $message->id) }}">{{ $message->file }}</a>
                                @endif
                                <p>{{ __($message->message) }}</p>
                                <div class="msg-text-meta">
                                    <span
                                        class="text-dt">{{ __(showDateTime($message->created_at, 'd M, h:i A')) }}</span>
                                    <span><i class="fa-solid fa-check-double"></i></span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="message-text">
                    <div class="text">
                        <p>No data Found</p>
                    </div>
                </div>
            @endif

        </div>
        <!-- chat btm -->
        <div class="msg-btm ">
            <div class="msg-input mt-2">
                <form id="chat" enctype="multipart/form-data">
                    @csrf
                    <div class="attchment-input-box">
                        <i class="fa-solid fa-paperclip att-file-upload"></i>
                        <input type="text" name="receiver_id" value="{{ @$user?->id }}" class="d-none">
                        <input type="file" class="att-upload-input d-none" name="file" accept=".jpeg, .png">
                        <p class="att-file-name">
                        </p>
                    </div>
                    <textarea class="emoji-text att-file-name" name="message"></textarea>
                    <button class="msg-submit-btn" type="submit"><i class="fa-regular fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        <!-- chat btm /> -->
    </div>

</div>
<!-- on screen chat box /> -->
@if (auth()->user())
    @push('script')
        <script src="{{ asset($activeTemplateTrue . 'js/pusher.min.js') }}"></script>
        <script>
            $('.msg-submit-btn').on('click', function(e) {
                e.preventDefault();
                var message = $("textarea[name=message]").val();
                var receiver_id = $("input[name=receiver_id]").val();
                var file = $('input[name=file]')[0].files;
                let message_list_wrapper = $('.msg-list-wraper');

                var formData = new FormData();
                formData.append('message', message);
                formData.append('receiver_id', receiver_id);

                if (file.length > 0) {
                    for (var i = 0; i < file.length; i++) {
                        formData.append('file', file[i]);
                    }
                }
                if (message == '' && file.length == 0) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Message and files are empty.',
                    });
                    return;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.chat.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        const now = new Date();
                        const formattedDate = now.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                        });
                        const formattedTime = now.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true,
                        });
                        const dateTime = `${formattedDate}, ${formattedTime}`;
                        const url = "{{ route('user.chat.download.file', ':id') }}".replace(':id', data
                            .id);
                        $(".emojionearea-editor").text('');
                        $(".emojionearea-editor").focus();
                        $('input[name=file]').val(null);
                        $('p.att-file-name').text('');
                        if (data.file != null && data.message != null) {
                            message_list_wrapper.append(`
                                <div class="message-text odd">
                                    <div class="text">
                                        <a href ="${url}">${data.file}</a>
                                        <p>${data.message}</p> 
                                        <div class="msg-text-meta">
                                            <span class="text-dt">${dateTime}</span>
                                            <span><i class="fa-solid fa-check-double"></i></span>
                                        </div>
                                    </div>
                                </div>
                             `);
                        } else if (data.file == null && data.message != null) {
                            message_list_wrapper.append(`
                                <div class="message-text odd">
                                    <div class="text">
                                        <p>${data.message}</p> 
                                        <div class="msg-text-meta">
                                            <span class="text-dt">${dateTime}</span>
                                            <span><i class="fa-solid fa-check-double"></i></span>
                                        </div>
                                    </div>
                                </div>
                             `);
                        } else {
                            message_list_wrapper.append(`
                                <div class="message-text odd">
                                    <div class="text">
                                        <a href ="${url}" target="_blank">${data.file}</a>
                                        <div class="msg-text-meta">
                                            <span class="text-dt">${dateTime}</span>
                                            <span><i class="fa-solid fa-check-double"></i></span>
                                        </div>
                                    </div>
                                </div>
                             `);
                        }
                        var chatBox = $('.msg-list-wraper')[0];
                        chatBox.scrollTop = chatBox.scrollHeight;

                    },
                    error: function(data, status, error) {
                        $('input[name=file]').val(null);
                        $('p.att-file-name').text('');
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

            // Pusher Setup and Credential and Sender - Receiver Function Start
            var app_key = @json(gs()->pusher_credential->app_key);
            var app_cluster = @json(gs()->pusher_credential->app_cluster);
            var my_channel = "{{ auth()->user()->id }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Pusher.logToConsole = false;
            var pusher = new Pusher(
                app_key, {
                    cluster: app_cluster
                });

            var channel = pusher.subscribe(my_channel);
            channel.bind('App\\Events\\Chat', function(data) {

                const now = new Date();
                const formattedDate = now.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                });
                const formattedTime = now.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true,
                });
                const dateTime = `${formattedDate}, ${formattedTime}`;
                const url = "{{ route('user.chat.download.file', ':id') }}".replace(':id', data.id);

                let message_list_wrapper = $('.msg-list-wraper');
                if (data.receiver == my_channel) {
                    if (data.file != null && data.message != null) {

                        message_list_wrapper.append(`
                            <div class="message-text">
                                <div class="text">
                                    <a href ="${url}" target="_blank">${data.file}</a>
                                    <p>${data.message}</p> 
                                    <div class="msg-text-meta">
                                        <span class="text-dt">${dateTime}</span>
                                        <span><i class="fa-solid fa-check-double"></i></span>
                                    </div>
                                </div>
                            </div>
                        `);
                    } else if (data.file == null && data.message != null) {

                        message_list_wrapper.append(`
                            <div class="message-text ">
                                <div class="text">
                                    <p>${data.message}</p> 
                                    <div class="msg-text-meta">
                                        <span class="text-dt">${dateTime}</span>
                                        <span><i class="fa-solid fa-check-double"></i></span>
                                    </div>
                                </div>
                            </div>
                        `);
                    } else {

                        message_list_wrapper.append(`
                        <div class="message-text">
                            <div class="text">
                                <a href ="${url}" target="_blank">${data.file}</a>
                                <div class="msg-text-meta">
                                    <span class="text-dt">${dateTime}</span>
                                    <span><i class="fa-solid fa-check-double"></i></span>
                                </div>
                            </div>
                        </div>
                        `);
                    }
                }

                var chatBox = $('.msg-list-wraper')[0];
                chatBox.scrollTop = chatBox.scrollHeight;
            });

            function checkbox(object) {
                if (object.checked) {
                    $('input[name=end_date]').attr('readonly', 'readonly').val('');
                } else {
                    $('input[name=end_date]').removeAttr('readonly');
                }
            }
        </script>
    @endpush
@endif
