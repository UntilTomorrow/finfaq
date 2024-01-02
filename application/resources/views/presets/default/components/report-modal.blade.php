{{-- report modal --}}
<div class="modal fade report_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="report_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Report')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="set-modal-post-id" hidden name="id">
                        <label for="message-text" class="col-form-label">@lang('Reason:')</label>
                        <textarea class="form-control reason" name="reason" id="message-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="report_sent btn btn-success post-details-report-modal">@lang('Send')</button>
                </div>
            </div>
        </form>
    </div>
</div>
