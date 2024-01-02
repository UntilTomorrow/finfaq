@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>@lang('Status')</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="status"
                                            {{ @$cookie->data_values->status ? 'checked' : null }}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Short Description')</label>
                            <textarea class="form-control" rows="5" required name="short_desc">{{ @$cookie->data_values->short_desc }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>@lang('Cookie Icon')</label>
                            
                            <div class="input-group">
                                <input type="text" class="form-control iconPicker icon" autocomplete="off" name="cookie_icon"
                                    value="{{ @$cookie->data_values->cookie_icon}}" required>
                                <span class="input-group-text  input-group-addon" data-icon="las la-home"
                                    role="iconpicker"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="form-control trumEdit" rows="10" name="description">@php echo @$cookie->data_values->description @endphp</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('.icon').on('click', function() {
                $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                    $(this).closest('.form-group').find('.iconpicker-input').val(
                        `<i class="${e.iconpickerValue}"></i>`);
                });
            });

        })(jQuery);
    </script>
@endpush
