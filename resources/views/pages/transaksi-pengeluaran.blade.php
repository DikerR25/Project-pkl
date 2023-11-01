@extends('layouts.main')

@section('page-title')
<div class="page-title d-flex flex-column gap-1 me-3 mb-2">
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
        <!--begin::Item-->
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
            <a href="/" class="text-gray-500">
                <i class="ki-duotone ki-home fs-3 text-gray-400 me-n1"></i>
            </a>
        </li>
        <!--end::Item-->

        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
        </li>

        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> Pengeluaran </li>

        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
        </li>

        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> {{$title}} </li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center tNo Transaksi:ext-dark fw-bolder fs-1 lh-0">Transaksi</h1>
    <!--end::Title-->
</div>
<!--end::App-->
@endsection

@section('konten')
@foreach ($transaksi as $L)
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Invoice 2 main-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-20">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                        <!--begin::Invoice 2 content-->
                        <div class="mt-n1">
                            <!--begin::Top-->
                            <div class="d-flex flex-stack pb-10">
                                <!--begin::Logo-->
                                <img alt="Logo" src="/assets/media/logos/icon.png" height="50px" />
                                <!--end::Logo-->
                                <!--begin::Action-->
                                <span class="badge badge-light-success badge-lg"> Noted </span>
                                <!--end::Action-->
                            </div>
                            <!--end::Top-->
                            <!--begin::Wrapper-->
                            <div class="m-0">
                                <!--begin::Label-->
                                <div class="fw-bold fs-3 text-gray-800 mb-8">Transaksi #{{$L->invoice}}</div>
                                <!--end::Label-->
                                <!--begin::Row-->
                                <div class="row g-5 mb-11">
                                    <!--end::Col-->
                                    <div class="col-sm-10">
                                        <!--end::Label-->
                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Dibuat Tanggal:</div>
                                        <!--end::Label-->
                                        <!--end::Col-->
                                        <div class="fw-bold fs-6 text-gray-800">{{ date('d-m-Y', strtotime(substr($L->invoice, 4, 8))) }}</div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Col-->
                                    <!--end::Col-->
                                    <div class="col-sm-2">
                                        <!--end::Label-->
                                        <div class="fw-semibold fs-7 text-gray-600 mb-1">Dikeluarkan oleh:</div>
                                        <!--end::Label-->
                                        <!--end::Info-->
                                        <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                            <span class="pe-2">Nyan Cafe</span>
                                        </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Content-->
                                <div class="flex-grow-1">
                                    <!--begin::Table-->
                                    <div class="table-responsive border-bottom mb-9">
                                        <table class="table mb-3">
                                            <thead>
                                                <tr class="border-bottom fs-6 fw-bold text-muted">
                                                    <th class="min-w-175px pb-2">Kebutuhan</th>
                                                    <th class="min-w-70px text-end pb-2">Kategori</th>
                                                    <th class="min-w-70px text-end pb-2">Jumlah</th>
                                                    <th class="min-w-100px text-end pb-2">Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaksiB as $B)
                                                <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                    <td class="d-flex align-items-center pt-6">
                                                    <i class="fa fa-genderless text-success fs-2 me-2" data-bs-toggle="tooltip" title="{{$B->category}}"></i>{{$B->requirement}}</td>
                                                    <td class="pt-6">{{$B->category}}</td>
                                                    <td class="pt-6">{{$B->quantity}}</td>
                                                    <td class="pt-6 text-dark fw-bolder">Rp{{number_format($B->price,2)}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                    <!--begin::Container-->
                                    <div class="d-flex justify-content-end">
                                        <!--begin::Section-->
                                        <div class="mw-300px">
                                            <!--begin::Item-->
                                            <div class="d-flex flex-stack mb-5">
                                                <!--begin::Code-->
                                                <div class="fw-semibold pe-10 text-gray-600 fs-7">Total Harga</div>
                                                <!--end::Code-->
                                                <!--begin::Label-->
                                                <div class="text-end fw-bold fs-6 text-gray-800">Rp{{number_format($L->total_price,2)}}</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Item-->
                                            <div class="d-flex flex-stack">
                                                <!--begin::Code-->
                                                <div class="fw-semibold pe-10 text-gray-600 fs-7">Jumlah Bahan</div>
                                                <!--end::Code-->
                                                <!--begin::Label-->
                                                <div class="text-end fw-bold fs-6 text-gray-800">{{ $L->total_quantity }}</div>
                                                <!--end::Label-->
                                            </div>
                                        </div>
                                        <!--end::Section-->
                                    </div>
                                    <!--end::Container-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Invoice 2 content-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Invoice 2 main-->
    </div>
    <!--end::Content container-->
</div>
@endforeach
@endsection
