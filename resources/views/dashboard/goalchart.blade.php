<div class="card card-flush h-md-50 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <!--begin::Info-->
            <div class="d-flex align-items-center">
                <!--begin::Amount-->
                <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2" data-kt-countup="true" data-kt-countup-value="{{$stockterjual}}">0</span>
                <!--end::Amount-->
            </div>
            <!--end::Info-->
            <!--begin::Subtitle-->
            <span class="text-gray-400 pt-1 fw-semibold fs-6">Stok Terjual Bulan Ini</span>
            <!--end::Subtitle-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->
    <!--begin::Card body-->
    <div class="card-body d-flex align-items-end pt-0">
        <!--begin::Progress-->
        <div class="d-flex align-items-center flex-column mt-3 w-100">
            <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                <span class="fw-bold text-dark fs-4 text-dark" ><span class="fs-5 fw-semibold text-gray-400 me-1">Rp</span><span data-kt-countup="true" data-kt-countup-decimal-places="2" data-kt-countup-value="{{  number_format($penjualanTerjual, 2) }}"></span> Menuju Target </span>
                <span class="fw-bold fs-6 text-gray-400" >{{ number_format($persentaseTerjual, 2) }}%</span>
            </div>
            <div class="progress-container rounded h-8px mx-3">
                <div class="progress-bar {{ $persentaseTerjual < 25 ? 'red' : ($persentaseTerjual < 75 ? 'yellow' : 'green') }} rounded h-8px mx-0" id="progressBar" style="width: {{ $persentaseTerjual >= 100 ? 100 : $persentaseTerjual }}%;">
                </div>
            </div>
        </div>
        <!--end::Progress-->
    </div>
    <!--end::Card body-->
</div>
