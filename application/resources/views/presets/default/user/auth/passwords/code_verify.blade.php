@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @include('presets.default.components.header')

    <section class="login-section py-115">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="log-in-box">
                        <div class="login wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">

                            <h5 class="pb-3 text-center border-bottom">@lang('Verify Email Address')</h5>
                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')
                                </p>
                            </div>
                            <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form">
                                @csrf
                                <p class="verification-text">@lang('A 6 digit verification code sent to your email address')
                                    : {{ showEmailAddress($email) }}</p>
                                <input type="hidden" name="email" value="{{ $email }}">
    
                                @include($activeTemplate.'components.verification_code')
    
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
                                </div>
    
                                <div class="form-group">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                   <u> <a href="{{ route('user.password.request') }}" class="text--base">@lang('Try to send again')</a></u> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
