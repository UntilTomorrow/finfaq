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
                    @include('presets.default.components.user.sidebar')
                    <!-- left side / -->
                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row justify-content-center pt-80 gy-4 mb-4">
                            <div class="col-lg-10">
                                <div class="user-profile">
                                    <form method="POST">
                                        @csrf
                                        <div class="row gy-3">
                                            <div class="col-sm-12">
                                                <h4>@lang('Change Password')</h4>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <input id="your-password" type="password" class="form--control"
                                                        name="current_password" placeholder=""
                                                        required autocomplete="current-password">
                                                    <label for="your-password"
                                                        class="form--label required">@lang('Current Password')</label>
                                                    <div class="password-show-hide fas fa-eye toggle-password-change"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <input id="new-password" type="password"
                                                        class="form-control form--control" placeholder="" name="password"
                                                        required autocomplete="current-password">
                                                    <label for="new-password" class="form--label required">@lang('New Password')
                                                    </label>
                                                    <div class="password-show-hide fas fa-eye toggle-password-change"></div>
                                                    @if ($general->secure_password)
                                                        <div class="input-popup">
                                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                                            <p class="error number">@lang('1 number minimum')</p>
                                                            <p class="error special">@lang('1 special character minimum')</p>
                                                            <p class="error minimum">@lang('6 character password')</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group input-group">
                                                    <input type="password" class="form--control" id="password_confirmation"
                                                        name="password_confirmation" placeholder=""
                                                         required
                                                        autocomplete="current-password">
                                                    <label for="password_confirmation"
                                                        class="form--label">@lang('Confirm Password')</label>
                                                    <div class="password-show-hide fas fa-eye toggle-password-change"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn--base">@lang('Save Now')</button>
                                            </div>
                                        </div>
                                    </form>
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
@endsection

@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif

            $(".toggle-password-change").on('click', function() {
                var input = $(this).siblings('input');
                var icon = $(this);
                if (input.attr("type") === "password") {

                    input.attr("type", "text");
                    icon.addClass("fa-eye-slash");
                    icon.removeClass("fa-eye");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash");
                    icon.addClass("fa-eye");
                }
            });
        })(jQuery);
    </script>
@endpush
