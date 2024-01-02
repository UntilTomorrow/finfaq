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
                        <div class="row pt-80 justify-content-center gy-4 px-3">
                            
                                <h4 class="title mb-3">@lang('Payment Options')</h4>
                                <form action="{{ route('user.deposit.insert') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="method_code">
                                    <input type="hidden" name="currency">
                                    <input type="hidden" name="price_plan_id" value="0">
                                    <div class="form-group mb-3">
                                        <label class="form-label required mb-3" for="gateway">@lang('Select Gateway')</label>
                                        <select class=" select form-control form--control" name="gateway" required=""
                                            id="gateway">
                                            <option value="">@lang('Select One')</option>
                                            @foreach ($gatewayCurrency as $data)
                                                <option value="{{ $data->method_code }}" @selected(old('gateway') == $data->method_code)
                                                    data-gateway="{{ $data }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label mb-3 required" for="credit">@lang('Credit')</label>
                                        <div class="input-group country-code mb-2">
                                            <input type="number" name="credit" class="form-control form--control"
                                                value="1" required="" id="credit"
                                                step="1" min="1" onkeyup="creditChange(this)">
                                        </div>
                                        <span class="">@lang('Per Credit') {{ __(@$general->per_credit_price) }}
                                            {{ __(@$general->cur_text) }}. @lang('Limit 2.00 - 100.00')</span>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label mb-3 required" for="amount">@lang('Amount')</label>
                                        <div class="input-group country-code">
                                            <span class="input-group-text">{{ __(@$general->cur_text) }}</span>
                                            <input type="number" step="any" name="amount"
                                                class="form-control form--control"
                                                value="{{ __(@$general->per_credit_price) }}"
                                                required="" id="amount" readonly>
                                        </div>
                                    </div>
                                    <div class="preview-details d-none">
                                        <span>@lang('Limit')</span>
                                        <span><span class="min fw-bold">0</span> {{ __($general->cur_text) }} - <span
                                                class="max fw-bold">0</span> {{ __($general->cur_text) }}
                                        </span>
                                        <span>@lang('Charge')</span>
                                        <span><span class="charge fw-bold">0</span>{{ __($general->cur_text) }}</span>
                                        <span>@lang('Payable')</span>
                                        <span>
                                            <span class="payable fw-bold">
                                                0
                                            </span>
                                            {{ __($general->cur_text) }}
                                        </span>
                                        <ul>
                                            <li class="list-group-item justify-content-between d-none rate-element">

                                            </li>
                                            <li class="list-group-item justify-content-between d-none in-site-cur">
                                                <span>@lang('In') <span class="base-currency"></span></span>
                                                <span class="final_amo fw-bold">0</span>
                                            </li>
                                            <li class="list-group-item justify-content-center crypto_currency d-none">
                                                <span>@lang('Conversion with') <span class="method_currency"></span>
                                                    @lang('and final value will Show on next step')</span>
                                            </li>
                                        </ul>

                                    </div>
                                    <button type="submit" class="btn btn--base w-100 mt-3">@lang('Submit')</button>
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
        (function($) {
            "use strict";
            $('select[name=gateway]').change(function() {
                if (!$('select[name=gateway]').val()) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var resource = $('select[name=gateway] option:selected').data('gateway');
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                if (resource.method.crypto == 1) {
                    var toFixedDigit = 8;
                    $('.crypto_currency').removeClass('d-none');
                } else {
                    var toFixedDigit = 2;
                    $('.crypto_currency').addClass('d-none');
                }
                $('.min').text(parseFloat(resource.min_amount).toFixed(2));
                $('.max').text(parseFloat(resource.max_amount).toFixed(2));
                var amount = parseFloat($('input[name=amount]').val());
                if (!amount) {
                    amount = 0;
                }
                if (amount <= 0) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                $('.preview-details').removeClass('d-none');
                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(
                    toFixedDigit);
                $('.final_amo').text(final_amo);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement =
                        `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span> <span class="base-currency">${resource.currency}</span></span></span>`;
                    $('.rate-element').html(rateElement)
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                } else {
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=currency]').val(resource.currency);
                $('input[name=method_code]').val(resource.method_code);
                $('input[name=amount]').on('input');
            });
            $('input[name=amount]').on('input', function() {
                $('select[name=gateway]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });
        })(jQuery);

        function creditChange(object) {
            var credit = parseFloat($(object).val()).toFixed(2);
            var perCredit = "{{ gs()->per_credit_price }}";
            var totalCreditPrice = parseInt(perCredit) * credit;
            $('input[name=amount]').val(totalCreditPrice);
            var resource = $('select[name=gateway] option:selected').data('gateway');
            var fixed_charge = parseFloat(resource.fixed_charge);
            var percent_charge = parseFloat(resource.percent_charge);
            var rate = parseFloat(resource.rate)
            if (resource.method.crypto == 1) {
                var toFixedDigit = 8;
                $('.crypto_currency').removeClass('d-none');
            } else {
                var toFixedDigit = 2;
                $('.crypto_currency').addClass('d-none');
            }
            $('.min').text(parseFloat(resource.min_amount).toFixed(2));
            $('.max').text(parseFloat(resource.max_amount).toFixed(2));
            var amount = parseFloat($('input[name=amount]').val());
            if (!amount) {
                amount = 0;
            }
            if (amount <= 0) {
                $('.preview-details').addClass('d-none');
                return false;
            }
            $('.preview-details').removeClass('d-none');
            var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
            $('.charge').text(charge);
            var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
            $('.payable').text(payable);
            var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(
                toFixedDigit);
            $('.final_amo').text(final_amo);
        }
    </script>
@endpush
