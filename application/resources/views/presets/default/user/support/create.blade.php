@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section>
        <!-- header -->
        @include('presets.default.components.header')
        @include('presets.default.components.sidenav')

        <!-- body -->
        <div class="dashboard">
            <div class="container-fluid">
                <div class="row m-0">
                    <!-- left side -->
                    @include('presets.default.components.user.sidebar')
                    <!-- left side / -->

                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row  pt-80 justify-content-center gy-4">
                            <h5 class="text-white">{{ __($pageTitle) }}</h5>
                            <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data"
                                onsubmit="return submitUserForm();">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="name"
                                            value="{{ @$user->firstname . ' ' . @$user->lastname }}"
                                            class="form-control form--control" required readonly>
                                            <label class="form--label">@lang('Name')</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{ @$user->email }}"
                                            class="form-control form--control" required readonly placeholder="">
                                            <label class="form--label">@lang('Email Address')</label>
                                        </div>
                                       
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <input type="text" name="subject" value="{{ old('subject') }}"
                                            class="form-control form--control" required placeholder="">
                                            <label class="form--label">@lang('Subject')</label>
                                        </div>
                                       
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <select name="priority" class="form-select form--control" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1">@lang('Low')</option>
                                                <option value="2">@lang('Medium')</option>
                                                <option value="3">@lang('High')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="form-group">
                                            <textarea name="message" id="inputMessage" rows="6" class="form--control" placeholder="" required>{{ old('message') }}</textarea>
                                            <label class="form--label">@lang('Message')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="text-end mt-2">
                                        <button type="button" class="btn btn--base btn-sm addFile">
                                            <i class="fa fa-plus"></i> @lang('Add New')
                                        </button>
                                    </div>
                                    <div class="file-upload">
                                        <label class="form-label">@lang('Attachments')</label> 
                                        <input type="file" name="attachments[]" id="inputAttachments"
                                            class="form-control form--control mb-2">
                                        <div id="fileUploadsContainer"></div>
                                        <p class="ticket-attachments-message text-muted my-3">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'),
                                            .@lang('png'),
                                            .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <button class="btn btn--base w-100" type="submit" id="recaptcha">&nbsp;@lang('Send')</button>
                                </div>
                            </form>
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
