@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @include('presets.default.components.header')
    <section class="login-section py-115">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="log-in-box">
                        <div class="login wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">
                            <h4 class="card-title mb-4">{{ __($pageTitle) }}</h4>
                            <form method="POST" action="{{ route('user.data.submit') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <div class="form-group pwow animate__animated animate__fadeInUp  mb-3"
                                            data-wow-delay="0.3s">
                                            <input type="text" class="form--control" placeholder=" " name="firstname"
                                                value="{{ old('firstname') }}" required>
                                            <label class="form--label">@lang('First Name')</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                    <div class="wow animate__animated animate__fadeInUp mb-3" data-wow-delay="0.3s">
                                        <div class="form-group">
                                            <input type="text" class="form--control" placeholder=" " name="lastname"
                                                value="{{ old('lastname') }}" required>
                                            <label class="form--label">@lang('Last Name')</label>
                                        </div>

                                    </div>
                                    </div>
                                    <div class="form-group col-sm-6">

                                    <div class="form-group wow animate__animated animate__fadeInUp mb-3"
                                        data-wow-delay="0.3s">
                                        <input type="text" class="form--control" placeholder="" name="address"
                                            value="{{ old('address') }}">
                                        <label class="form--label">@lang('Address')</label>
                                    </div>
                                    </div>
                                    <div class="form-group col-sm-6">

                                    <div class="form-group wow animate__animated animate__fadeInUp mb-3"
                                        data-wow-delay="0.3s">
                                        <input type="text" class="form--control" placeholder=" " name="state"
                                            value="{{ old('state') }}">
                                        <label class="form--label">@lang('State')</label>
                                    </div>
                                    </div>
                                    <div class="form-group col-sm-6">

                                    <div class="form-group wow animate__animated animate__fadeInUp mb-3"
                                        data-wow-delay="0.3s">
                                        <input type="text" class="form--control" placeholder="" name="zip"
                                            value="{{ old('zip') }}">
                                        <label class="form--label">@lang('Zip Code')</label>
                                    </div>
                                    </div>
                                    <div class="form-group col-sm-6">

                                    <div class="form-group wow animate__animated animate__fadeInUp mb-3"
                                        data-wow-delay="0.3s">
                                        <input type="text" class="form--control" placeholder="" name="city"
                                            value="{{ old('city') }}">
                                        <label class="form--label">@lang('City')</label>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit"
                                            class=" w-100 btn btn--base wow animate__animated animate__fadeInUp"
                                            data-wow-delay="0.5s">
                                            @lang('Save')
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
