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
                        <div class="row pt-80 justify-content-center gy-4 mb-4">
                            
                            <form class="register" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4 justify-content-center">
                                    <div class="col-lg-10">
                                        <div class="dashboard_profile text-center">
                                            <div class="dashboard_profile__details">
                                                <div class="dashboard_profile_wrap">
                                                    <div class="profile_photo mb-2">
                                                        <img id="imgPre"
                                                            src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()?->image, getFileSize('userProfile')) }}"
                                                            alt="User">
                                                        <div class="photo_upload">
                                                            <label for="image"><i
                                                                    class="fa-regular fa-image"></i></label>
                                                            <input type="file" name="image" class="upload_file"
                                                                onchange="profileImg(this);" id="image">
                                                        </div>
                                                    </div>
                                                    <div class="profile-details">
                                                        <ul>
                                                            <li>
                                                                <p><span>@lang('User Name:')</span>
                                                                    {{ auth()->user()->fullname }}</p>
                                                                <p><span>@lang('Email:')</span>
                                                                    {{ auth()->user()->email }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 justify-content-center">
                                        <div class="user-profile payment-info">
                                            <div class="row gy-3">
                                                <div class="col-lg-12">
                                                    <h4 class="mb-1">@lang('Personal Information')</h4>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="firstname"
                                                            placeholder="" name="firstname" value="{{ @$user->firstname }}"
                                                            required>
                                                        <label for="firstname"
                                                            class="form--label required">@lang('First Name')</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="lastname"
                                                            placeholder="" name="lastname" value="{{ @$user->lastname }}"
                                                            required>
                                                        <label for="lastname"
                                                            class="form--label required">@lang('Last Name')</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="email"
                                                            placeholder="" name="email" value="{{ @$user->email }}"
                                                            readonly>
                                                        <label for="email" class="form--label">@lang('Your Email ')</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="zip-code"
                                                            placeholder="" name="zip"
                                                            value="{{ @$user->address->zip }}">
                                                        <label for="zip-code" class="form--label">@lang('Zip Code')</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <select class="form--control" name="country">
                                                                @foreach ($countries as $key => $country)
                                                                    <option data-mobile_code="{{ $country->dial_code }}"
                                                                        value="{{ $country->country }}" data-code="{{ $key }}" {{$user->country_code == $key ? 'selected': ''}} >
                                                                        {{ __($country->country) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-lg-6 col-md-12 mb-3">
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text mobile-code">
                                                            </span>
                                                            <input type="hidden" name="mobile_code">
                                                            <input type="hidden" name="country_code">
                                                            <input type="number"
                                                                class="form--control form-control form--control checkUser"
                                                                placeholder="Phone" name="mobile" value="{{ @$user->mobile }}"
                                                                aria-label="Dollar amount (with dot and two decimal places)" required>
                                                        </div>
                                                        <small class="text-danger mobileExist"></small>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="state"
                                                            placeholder="" name="state"
                                                            value="{{ @$user->address->state }}">
                                                        <label for="state" class="form--label">@lang('State')</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="city"
                                                            placeholder="" name="city"
                                                            value="{{ @$user->address->city }}">
                                                        <label for="city" class="form--label">@lang('City')</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="instagram"
                                                            placeholder="" name="instagram"
                                                            value="{{ @$user->social_link->instagram }}">
                                                        <label for="instagram"
                                                            class="form--label">@lang('Instagram')</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="facebook"
                                                            placeholder="" name="facebook"
                                                            value="{{ @$user->social_link->facebook }}">
                                                        <label for="facebook"
                                                            class="form--label">@lang('Facebook')</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 mb-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form--control" id="twitter"
                                                            placeholder="" name="twitter"
                                                            value="{{ @$user->social_link->twitter }}">
                                                        <label for="twitter"
                                                            class="form--label">@lang('Twitter')</label>
                                                    </div>
                                                </div>
                                                @php
                                                    $skills = json_decode(@$user->skills);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="form-group skill-input">
                                                            <label class="mb-3">@lang('Skills')</label>
                                                            <small class="ms-2 mt-2">@lang('Separate multiple keywords by')
                                                                <code>,</code>(@lang('comma')) @lang('or')
                                                                <code>@lang('enter')</code>
                                                                @lang('key')</small>
                                                            <select name="skills[]"
                                                                class="form-control form--control select2-auto-tokenize"
                                                                multiple="multiple" required>
                                                                @if (@$skills)
                                                                    @foreach ($skills as $skill)
                                                                        <option value="{{ $skill }}" selected>
                                                                            {{ __($skill) }}</option>
                                                                    @endforeach
                                                                @endif
    
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea class="form--control" placeholder="" name="address">{{ @$user->address->address }}</textarea>
                                                        <label for="email"
                                                            class="form--label">@lang('Address')</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <button type="submit"
                                                        class="btn btn--base w-100">@lang('Save Now')</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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

@push('script')
    <script>
        function profileImg(object) {
            const file = object.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#imgPre').attr('src', event.target.result);
                    var form = $(object).closest('form');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
    <script>
        (function($) {
            "use strict";
            $('.select2-auto-tokenize').select2({
                dropdownParent: $('.skill-input'),
                tags: true,
                tokenSeparators: [',']
            });
        })(jQuery);
    </script>


    <script>
        "use strict";
        (function($) {
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

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

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {

                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

