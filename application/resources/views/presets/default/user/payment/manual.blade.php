@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section>
        <!-- header -->
        @include('presets.default.components.header')
        @include('presets.default.components.sidenav')
        <!-- body -->
        <div class="body-section">
            <div class="container-fluid">
                <div class="row">
                    <!-- left side -->
                    @include('presets.default.components.user.sidebar')
                    <!-- left side / -->

                    {{-- main content --}}
                    <div class="col-xl-6 col-lg-6">
                        <div class="row justify-content-center pt-60 gy-4 px-3">
                            
                            <form action="{{ route('user.deposit.manual.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p class="text-center mt-2">@lang('You have requested') <b
                                                class="text-success">{{ showAmount($data['amount']) }}
                                                {{ __($general->cur_text) }}</b> , @lang('Please pay')
                                            <b class="text-success">{{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }}
                                            </b> @lang('for successful payment')
                                        </p>
                                        <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                        <div class="my-4 text-center">@php echo  $data->gateway->description @endphp</div>
                                    </div>

                                    <x-custom-form identifier="id"
                                        identifierValue="{{ $gateway->form_id }}"></x-custom-form>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn--base w-100 mt-3">@lang('Pay Now')</button>
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
