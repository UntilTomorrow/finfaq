<div class="community-state-box">
    <h5>@lang('Community State')</h5>
    <div class="community-item-wraper">
        <div class="community-item">
            <div class="item-status mb-3">
                <span class="count odometer" data-count="{{ @$last_month_posts }}"></span>
                <h6 class="item-status-title">@lang('Posts This Month')</h6>
            </div>
            <div class="item-status">
                <span class="count odometer" data-count="{{ @$total_topic }}"></span>
                <h6 class="item-status-title">@lang('Total Topics')</h6>
            </div>
        </div>
        <div class="community-item">
            <div class="item-status mb-3">
                <span class="count odometer" data-count="{{ @$conversations }}"></span>
                <h6 class="item-status-title">@lang('Conversations')</h6>
            </div>
            <div class="item-status">
                <span class="count odometer" data-count="{{ @$total_replies }}"></span>
                <h6 class="item-status-title">@lang('Total Replies')</h6>
            </div>
        </div>
    </div>
</div>
