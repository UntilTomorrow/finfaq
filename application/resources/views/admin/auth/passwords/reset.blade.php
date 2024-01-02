@extends('admin.layouts.master')
@section('content')
<div style="background-image: url('{{ asset('assets/admin/images/login.png') }}')" class="login_area">
    <div class="login">
        <div class="login__header">
            <h2>@lang('Reset Password')</h2>
            <p>@lang('Provide a new to log in')</p>
        </div>
        <div class="login__body">
            <!-- <h4>user login</h4> -->
            <form action="{{ route('admin.password.change') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="field">
                    <input type="password" name="password" placeholder="@lang('Password')" required>
                    <span class="show-pass"><i class="fas fa-lock"></i></span>
                </div>
                <div class="field">
                    <input type="password" name="password_confirmation" placeholder="@lang('Password Confirmation')"
                        required>
                    <span class="show-pass"><i class="fas fa-lock"></i></span>
                </div>
                <div class="field">
                    <button type="submit" class="sign-in">@lang('Reset')</button>
                </div>
                <div class="login__footer d-flex justify-content-center">
                    <a class="float-end" href="{{ route('admin.login') }}">@lang('Go back')</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{asset('assets/admin/css/auth.css')}}">
@endpush