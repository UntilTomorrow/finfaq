<div class="row gy-4 mb-5">
    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="buy-credit.html">
            <div class="dashboard-card">
                <span class="banner-effect-1"></span>
                <div class="dashboard-card__icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="dashboard-card__content">
                    <h5 class="dashboard-card__title">@lang('Total Credit')</h5>
                    <h5 class="dashboard-card__amount">500</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="#">
            <div class="dashboard-card">
                <span class="banner-effect-1"></span>
                <div class="dashboard-card__icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="dashboard-card__content">
                    <h5 class="dashboard-card__title">@lang('Total Post')</h5>
                    <h5 class="dashboard-card__amount">500</h5>

                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="#">
            <div class="dashboard-card">
                <span class="banner-effect-1"></span>
                <div class="dashboard-card__icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="dashboard-card__content">
                    <h5 class="dashboard-card__title">@lang('Approved Post')</h5>
                    <h5 class="dashboard-card__amount">500</h5>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="#">
            <div class="dashboard-card">
                <span class="banner-effect-1"></span>
                <div class="dashboard-card__icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="dashboard-card__content">
                    <h5 class="dashboard-card__title">@lang('Pending Post')</h5>
                    <h5 class="dashboard-card__amount">500</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="#">
            <div class="dashboard-card">
                <span class="banner-effect-1"></span>
                <div class="dashboard-card__icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="dashboard-card__content">
                    <h5 class="dashboard-card__title">@lang('Reject Post')</h5>
                    <h5 class="dashboard-card__amount">20</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="#">
            <div class="dashboard-card">
                <span class="banner-effect-1"></span>
                <div class="dashboard-card__icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="dashboard-card__content">
                    <h5 class="dashboard-card__title">@lang('Report')</h5>
                    <h5 class="dashboard-card__amount">500</h5>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="dashboard-chart">
            <div id="chart"> </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="dashboard-chart">
            <div id="chart1"> </div>
        </div>
    </div>
</div>

@push('script')
    <script src="{{ asset('assets/admin/js/apexcharts.min.js') }}"></script>
    <script>
        // chart
        document.addEventListener("DOMContentLoaded", function() {
            var options1 = {
                chart: {
                    type: "bar",
                },
                series: [{
                    name: "Post",
                    data: @json($postReport['values']),
                }, ],
                xaxis: {
                    categories: @json($postReport['labels']),
                },
                fill: {
                    colors: ["#1dbf73"],
                },
            };

            var options2 = {
                chart: {
                    type: "bar",
                },
                series: [{
                    name: "sales",
                    data: [30, 40, 45, 50, 49, 60, 70, 91, 125],
                }, ],
                xaxis: {
                    categories: [6777, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023],
                },
                fill: {
                    colors: ["#1dbf73"],
                },
            };


            var chart = new ApexCharts(document.querySelector("#chart"), options1);
            chart.render();
            var chart = new ApexCharts(document.querySelector("#chart1"), options2);

            chart.render();
        });
    </script>
@endpush
