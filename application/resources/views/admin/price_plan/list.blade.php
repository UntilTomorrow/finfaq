@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Credit')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td>
                                            {{ __(@$item->name) }}
                                        </td>

                                        <td>
                                            {{ __(@$item->price . $general->cur_sym) }}
                                        </td>
                                        <td>
                                            {{ __(@$item->credit) }}
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                            <span
                                                class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                        @else
                                            <span
                                                class="text--small badge font-weight-normal badge--danger">@lang('Pending')</span>
                                        @endif
                                        </td>

                                        <td>
                                            <a title="@lang('Edit')" href="javascript:void(0)"
                                                class="btn btn-sm btn--primary ms-1 editBtn"
                                                data-url="{{ route('admin.price.plan.update', $item->id) }}"
                                                data-plan="{{ json_encode($item->only('name', 'price', 'credit', 'status')) }}">
                                                <i class="la la-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($data->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($data) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- NEW MODAL --}}
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"> @lang('Add New Price Plan')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="{{ route('admin.price.plan.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label>@lang('Price')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('price') }}" name="price"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label>@lang('Credit')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('credit') }}" name="credit"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option value="1" selected>@lang('Active')</option>
                                    <option value="0">@lang('Pending')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                            value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Edit plan')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i></button>
                </div>
                <form method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label>@lang('Price')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('price') }}" name="price"
                                    required>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label>@lang('Credit')</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" value="{{ old('credit') }}" name="credit"
                                    required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <div class="col-sm-12">
                                <select name="status" id="setDefault" class="form-control">
                                    <option value="1">@lang('Active')</option>
                                    <option value="0">@lang('Pending')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                            value="add">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection


@push('breadcrumb-plugins')
    <a class="btn btn-sm btn--primary addBtn" data-bs-toggle="modal" data-bs-target="#createModal"><i
            class="las la-plus"></i>@lang('Add New')</a>
@endpush


 @push('script')
 <script>
    (function($) {
        "use strict";
        $('.addBtn').on('click', function() {
            var modal = $('#createModal');
            modal.modal('show');
        });
        $('.editBtn').on('click', function() {
            var modal = $('#editModal');
            var url = $(this).data('url');
            var plan = $(this).data('plan');

            modal.find('form').attr('action', url);
            modal.find('input[name=name]').val(plan.name);
            modal.find('input[name=price]').val(plan.price);
            modal.find('input[name=credit]').val(plan.credit);
            if (plan.status == 1) {
                modal.find('.modal-body #setDefault').val(1);
            } else {
                modal.find('.modal-body #setDefault').val(0);
            }
            modal.modal('show');
            
        });
    })(jQuery);
</script>
@endpush 
