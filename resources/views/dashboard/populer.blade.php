<div class="card card-flush h-md-50 mb-5 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-5">
        <!--begin::Title-->
        <div class="card-title d-flex flex-column">
            <!--begin::Title-->
            <span class="card-label fw-bold text-dark">Kategori Populer</span>
            <!--end::Title-->
            <!--begin::Subtitle-->
            <span class="text-gray-400 pt-1 fw-semibold fs-6">Bulan Ini</span>
            <!--end::Subtitle-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Header-->
    <!--begin::Card body-->
    <div class="card-body d-flex flex-column px-6 pb-0 pe-6">
          <!--begin::Item-->
          @if (count($totalquantity) == 0)
            <div class="d-flex flex-stack">
                <div class="card-body card bg-gray-200 px-2 pb-2 pt-2">
                <!--begin::Symbol-->
                    <div class="symbol symbol-25px">
                        <div class="symbol-label fs-6 fw-semibold">A</div>
                    </div>
                <!--end::Symbol-->
                </div>
            </div>
            <div class="separator separator-dashed my-1"></div>
            <div class="d-flex flex-stack">
                <div class="card-body card bg-gray-200 px-2 pb-2 pt-2">
                <!--begin::Symbol-->
                    <div class="symbol symbol-25px">
                        <div class="symbol-label fs-6 fw-semibold">B</div>
                    </div>
                <!--end::Symbol-->
                </div>
            </div>
            <div class="separator separator-dashed my-1"></div>
            <div class="d-flex flex-stack">
                <div class="card-body card bg-gray-200 px-2 pb-2 pt-2">
                <!--begin::Symbol-->
                    <div class="symbol symbol-25px">
                        <div class="symbol-label fs-6 fw-semibold">C</div>
                    </div>
                <!--end::Symbol-->
                </div>
            </div>
            <div class="separator separator-dashed my-1"></div>

          @else
            @foreach($totalquantity as $category => $count)
            <div class="d-flex flex-stack">
                <!--begin::Symbol-->
                <div class="symbol symbol-30px me-4">
                    <div class="symbol-label fs-6 fw-semibold {{$category == 'Makanan' ? 'bg-danger' : ($category == 'Minuman' ? 'bg-primary' : 'bg-success') }} text-inverse-danger">{{ substr($category, 0, 1) }}</div>
                </div>
                <!--end::Symbol-->

                <!--begin::Section-->
                <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                    <!--begin:Author-->
                    <div class="flex-grow-1 me-2">
                        <span  class="text-gray-800 text-hover-primary fs-6 fw-bold">#{{$loop->iteration}}</span>

                        <span class="text-muted fw-semibold d-block fs-7">{{ $category }}</span>
                    </div>
                    <!--end:Author-->

                    <!--begin::Actions-->
                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-15px h-15px" data-bs-toggle="tooltip" title="Stock Terjual {{ $count }}"></button>
                    <!--begin::Actions-->
                </div>
                <!--end::Section-->
            </div>
            <div class="separator separator-dashed my-1"></div>
            @endforeach
          @endif
        <!--end::Item-->
    </div>
    <!--end::Card body-->
</div>
