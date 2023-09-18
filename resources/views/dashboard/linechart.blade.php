<div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-6 mb-5 mb-xl-10">
            <!--begin::Chart widget 8-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Penghasilan Bersih</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Pada Semua Kategori</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <ul class="nav" id="kt_chart_widget_8_tabs">
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1" data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle" href="#kt_chart_widget_8_week_tab">Tahun</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active" data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle" href="#kt_chart_widget_8_month_tab">Bulan</a>
                            </li>
                        </ul>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-6">
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_chart_widget_8_week_tab" role="tabpanel">
                            <!--begin::Statistics-->
                            <div class="mb-5">
                                <!--begin::Statistics-->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-4 fw-semibold text-gray-400 me-1">Rp</span>
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2" data-kt-countup="true" data-kt-countup-value="{{number_format($penjualanTerjual - $pengeluaranT,2)}}">0</span>
                                    <span class="badge badge-light-success fs-base">
                                    <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>4,8%</span>
                                </div>
                                <!--end::Statistics-->
                                <!--begin::Description-->
                                <span class="fs-6 fw-semibold text-gray-400">Penghasilan Bersih Bulan Ini</span>
                                <!--end::Description-->
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Chart-->
                            <div id="kt_charts_widget_3M" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade active show" id="kt_chart_widget_8_month_tab" role="tabpanel">
                            <!--begin::Statistics-->
                            <div class="mb-5">
                                <!--begin::Statistics-->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-4 fw-semibold text-gray-400 me-1">Rp</span>
                                    <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2" data-kt-countup="true" data-kt-countup-value="{{number_format($pendaparanbersihhariini,2)}}">0</span>
                                    <span class="badge badge-light-success fs-base">
                                    <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>2.2%</span>
                                </div>
                                <!--end::Statistics-->
                                <!--begin::Description-->
                                <span class="fs-6 fw-semibold text-gray-400">Penghasilan Bersih Hari Ini</span>
                                <!--end::Description-->
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Chart-->
                            <div id="kt_charts_widget_3" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 8-->
        </div>
        <!--end::Col-->
    </div>
</div>

    @push('kt_charts_penjualan')
    <script>
            var weeklyExpensesPeng = @json($pendapatanBersih);
            var monthlyExpensesPenghasilan = @json($monthlyExpensesPenghasilan);
        </script>
    @endpush
