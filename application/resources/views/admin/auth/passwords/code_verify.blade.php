@extends('admin.layouts.master')
@section('content')
    <div style="background-image: url('{{ asset('assets/admin/images/login.png') }}')" class="login_area">
        <div class="login">
            <div class="login__header">
                <h2>@lang('Verification')</h2>
                <p>@lang('Please enter the verification code')</p>
            </div>
            <div class="login__body">
                <!-- <h4>user login</h4> -->
                <form class="form" action="{{ route('admin.password.verify.code') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <span class="fas fa-envelope" aria-hidden="true"></span>
                        <label class="form-label" for="input">@lang('Verification Code')</label>
                        <div class="verification-code">
                            <input type="text" name="code" class="overflow-hidden" autocomplete="off">
                            <div class="boxes">
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <a href="{{ route('admin.password.reset') }}" class="forget-text">@lang('Try to send again')</a>
                    </div>
                    <div class="form-row button-login">
                        <button type="submit" class="btn btn-login">@lang('Verify') <span class="fas fa-arrow-right"
                                aria-hidden="true"></span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/verification_code.css') }}">
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';
            $('[name=code]').on('input', function() {

                $(this).val(function(i, val) {
                    if (val.length >= 6) {
                        $('form').find('button[type=submit]').html(
                            '<i class="las la-spinner fa-spin"></i>');
                        $('form').find('button[type=submit]').removeClass('disabled');
                        $('form')[0].submit();
                    } else {
                        $('form').find('button[type=submit]').addClass('disabled');
                    }
                    if (val.length > 6) {
                        return val.substring(0, val.length - 1);
                    }
                    return val;
                });

                for (let index = $(this).val().length; index >= 0; index--) {
                    $($('.boxes span')[index]).html('');
                }
            });

        })(jQuery)
    </script>
@endpush
