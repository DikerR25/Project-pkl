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
        <div class="card-toolbar">
            <button class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active" data-bs-toggle="modal" data-bs-target="#menu">Menu</button>
        </div>
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
                    <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-15px h-15px" data-id="{{ $category }}" data-bs-toggle="modal" data-bs-target="#kategori{{$category}}"></button>
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

<!--modal-->
<div class="modal fade" tabindex="-1" id="menu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title d-flex flex-column">
                    <span class="card-label fw-bold fs-3 text-dark">Menu Populer</span>
                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Bulan Ini</span>
                </div>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
            
                <div class="d-flex flex-stack">
                    <div class="card-body card bg-gray-200 px-2 pb-2 pt-2">
                    <!--begin::Symbol-->
                        <div class="symbol symbol-25px">
                            <div class="symbol-label fs-6 fw-semibold">A</div>
                        </div>
                    <!--end::Symbol-->
                    </div>
                </div>
                <div class="separator separator-dashed my-2"></div>

                <div class="d-flex flex-stack">
                    <div class="card-body card bg-gray-200 px-2 pb-2 pt-2">
                    <!--begin::Symbol-->
                        <div class="symbol symbol-25px">
                            <div class="symbol-label fs-6 fw-semibold">B</div>
                        </div>
                    <!--end::Symbol-->
                    </div>
                </div>
                <div class="separator separator-dashed my-2"></div>

                <div class="d-flex flex-stack">
                    <div class="card-body card bg-gray-200 px-2 pb-2 pt-2">
                    <!--begin::Symbol-->
                        <div class="symbol symbol-25px">
                            <div class="symbol-label fs-6 fw-semibold">C</div>
                        </div>
                    <!--end::Symbol-->
                    </div>
                </div>
                <div class="separator separator-dashed my-2"></div>

            </div>
            
        </div>
    </div>
</div>

<!--kategori-->
@foreach($totalquantity as $category => $count)
<div class="modal fade" tabindex="-1" id="kategori{{$category}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title d-flex flex-column">
                    <span class="card-label fw-bold fs-3 text-dark">{{$category}} Populer</span>
                    <span class="text-gray-400 pt-1 fw-semibold fs-6">Bulan Ini</span>
                </div>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="d-flex flex-center mb-5">
                    <span class="text-gray-700 fw-semibold fs-6">Stok Terjual: {{$count}}</span>
                </div>
                @php
                    $no = 1;
                @endphp
                @foreach($categorypopuler as $categoryItem)
                @if($categoryItem->category == $category)
                <div class="d-flex flex-stack">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-30px me-4">
                        <div class="symbol-label fs-6 fw-semibold {{ $category == 'Makanan' ? 'bg-danger' : ($category == 'Minuman' ? 'bg-primary' : 'bg-success') }} text-inverse-danger">{{ substr($categoryItem->category, 0, 1) }}</div>
                    </div>
                    <!--end::Symbol-->

                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                        <!--begin:Author-->
                        <div class="flex-grow-1 me-2">
                            <span class="text-gray-800 text-hover-primary fs-6 fw-bold">#{{$no++}}</span>
                            <span class="text-muted fw-semibold d-block fs-7">{{ $categoryItem->name }}</span>
                        </div>
                        <!--end:Author-->
                        <span class="text-gray-800 text-hover-primary px-2 fs-6 fw-bold">Terjual: {{$categoryItem->total_quantity}}</span>
                    </div>
                    <!--end::Section-->
                </div>
                <div class="separator separator-dashed my-2"></div>
                @endif
            @endforeach

            </div>
            
        </div>
    </div>
</div>
@endforeach
