<div class="card card-flush h-md-50 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <!--begin::Title-->
            <span class="card-label fw-bold text-dark"><span class="fs-5 fw-semibold text-gray-400 me-1">Rp</span><span data-kt-countup="true" data-kt-countup-decimal-places="2" data-kt-countup-value="{{number_format($pengeluaranT,2)}}">0</span></span></span>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <span class="text-gray-400 pt-1 fw-semibold fs-6">Pengeluaran Bulan Ini</span>
            <!--end::Subtitle-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->
    <!--begin::Card body-->
    <div class="card-body d-flex align-items-end px-3 pt-0 pb-0">
        <!--begin::Users group-->
        <div style="width: 100%; max-width: 600px;">
            <canvas id="myChart" class="w-100" style="height: 150px"></canvas>
        </div>
        <!--end::Users group-->
    </div>
    <!--end::Card body-->
</div>

    @push('chartpopuler')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var dailyExpensesjson = @json($dailyExpenses);
        </script>
        <script src="/assets/js/barpengeluaran.js"></script>
    @endpush
