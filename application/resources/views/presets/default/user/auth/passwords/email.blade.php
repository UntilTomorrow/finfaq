@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @include('presets.default.components.header')

    <section class="login-section py-115">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="log-in-box">
                        <div class="login wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">

                            <h5 class="card-title mb-4">{{ __($pageTitle) }}</h5>

                            <div class="mb-4">
                                <p>@lang('To recover your account please provide your email or username to find your account.')
                                </p>
                            </div>
                            <form method="POST" action="{{ route('user.password.email')  }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form--control" name="value"
                                    value="{{ old('value') }}" required  placeholder="">
                                    <label class="form--label">@lang('Email or Username')</label>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn--base w-100">@lang('Save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
