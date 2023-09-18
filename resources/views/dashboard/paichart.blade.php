<div class="card card-flush h-md-50 mb-5 mb-xl-10">
    <!--begin::Card body-->
    <div class="card-body pt-5">
        <!--begin::Heading-->
        <div class="fs-2hx fw-bold"  data-kt-countup="true" data-kt-countup-value="" id="categoryCounts">0</div>
        <div class="fs-4 fw-semibold text-gray-400 mb-7">Jumlah Menu</div>
        <!--end::Heading-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-wrap">
            <!--begin::Chart-->
            <div class="d-flex flex-center h-100px w-100px me-9 mb-5" style="width: 100%;">
                <canvas id="categoryChart"></canvas>
            </div>
            <!--end::Chart-->
            <!--begin::Labels-->
            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                <!--begin::Label-->
                <div class="d-flex fs-6 fw-semibold align-items-center mb-1">
                    <div class="bullet me-3" style="background-color: #36A2EB"></div>
                    <div class="text-gray-400" >Minuman</div>
                    <div class="ms-auto fw-bold text-gray-700" id="minumanCount">0</div>
                </div>
                <!--end::Label-->
                <!--begin::Label-->
                <div class="d-flex fs-6 fw-semibold align-items-center mb-1">
                    <div class="bullet me-3" style="background-color: #FF6384" ></div>
                    <div class="text-gray-400">Makanan</div>
                    <div class="ms-auto fw-bold text-gray-700" id="lainnyaCount">0</div>
                </div>
                <!--end::Label-->
                <!--begin::Label-->
                <div class="d-flex fs-6 fw-semibold align-items-center mb-12">
                    <div class="bullet bg-warning me-3"></div>
                    <div class="text-gray-400">Lainnya</div>
                    <div class="ms-auto fw-bold text-gray-700" id="makananCount">0</div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Labels-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Card body-->
</div>

    @push('scriptsdonat')
        <script>
            var categoryData = @json($categoryData);
        </script>
        <script src="/assets/js/chartdonat.js"></script>
    @endpush
