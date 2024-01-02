@extends($activeTemplate . 'layouts.' . $layout)
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
                    @include('presets.default.components.user.sidebar')
                    <!-- left side / -->

                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row justify-content-center pt-80 gy-2 px-3">
                            <div class="col-xl-12">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                                        <h5>
                                            @php echo $myTicket->statusBadge; @endphp
                                            [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                                        </h5>
                                        @if ($myTicket->status != 3 && $myTicket->user)
                                            <button class="btn btn--danger close-button btn--sm confirmationBtn" type="button"
                                                data-question="@lang('Are you sure to close this ticket?')"
                                                data-action="{{ route('ticket.close', $myTicket->id) }}"><i
                                                    class="fa fa-lg fa-times-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="mb-4">
                                        @if ($myTicket->status != 4)
                                            <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row justify-content-between mb-4">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea name="message" class="form-control form--control" rows="4">{{ old('message') }}</textarea>
                                                            <label class="form--label">@lang('Message')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end mb-3">
                                                    <a href="javascript:void(0)" class="btn btn--base btn--sm addFile"><i
                                                            class="fa fa-plus"></i> @lang('Add New')</a>
                                                </div>
                                                <div class="form-group mb-4">
                                                    
                                                    <input type="file" name="attachments[]"
                                                        class="form-control form--control" >
                                                    <div id="fileUploadsContainer"></div>
                                                    <p class="my-2 ticket-attachments-message text-muted">
                                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'),
                                                        .@lang('png'), .@lang('pdf'), .@lang('doc'),
                                                        .@lang('docx')
                                                    </p>
                                                    <label class="form--label">@lang('Attachments')</label>
                                                </div>
                                                <button type="submit" class="btn btn--base btn--sm"> <i
                                                        class="fa fa-reply"></i> @lang('Reply')</button>
                                            </form>
                                        @endif
                                    </div>
                              
                                <div class="card mt-5">
                                    <div class="card-body">
                                        @foreach ($messages as $message)
                                            @if ($message->admin_id == 0)
                                                <div class="row border rounded p-3 mx-2">
                                                    <div class="col-md-9">
                                                        <p class="text-muted fw-bold my-2">
                                                            @lang('Posted on')
                                                            {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                        <p>{{ $message->message }}</p>
                                                        @if ($message->attachments->count() > 0)
                                                            <div class="mt-2">
                                                                @foreach ($message->attachments as $k => $image)
                                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                                        class="me-3"><i class="fa fa-file"></i>
                                                                        @lang('Attachment') {{ ++$k }} </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row border rounded my-3 p-3 mx-2"
                                                    style="background-color: #ffd96729">
                                                    
                                                    <div class="col-md-9">
                                                        <p class="text-muted fw-bold my-2">
                                                            @lang('Posted on')
                                                            {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                        <p>{{ $message->message }}</p>
                                                        @if ($message->attachments->count() > 0)
                                                            <div class="mt-2">
                                                                @foreach ($message->attachments as $k => $image)
                                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}"
                                                                        class="me-3"><i class="fa fa-file"></i>
                                                                        @lang('Attachment') {{ ++$k }} </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- main content / --}}

                    <!-- right side -->
                    <div class="col-lg-3">
                        <aside class="rightside-bar">
                            @include('presets.default.components.user_info')
                            @include('presets.default.components.popular')
                        </aside>
                    </div>
                    <!-- right side /-->

                </div>
            </div>
        </div>
    </section>
    <x-confirmation-modal></x-confirmation-modal>
@endsection



















@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
