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
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        
        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> {{$title}} </li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0"> {{$title}} </h1>
    <!--end::Title-->
</div>
<!--end::App-->
@endsection

@section('konten')
<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="row g-5 g-xl-10 mb-xl-10">
        <div class="card ">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <!--begin::Wrapper-->
                    <div class="flex-grow-1">
                        <!--begin::Head-->
                        <div class="d-flex justify-content-center align-items-center flex-wrap mb-2">
                            <!--begin::Details-->
                            <div class="d-flex flex-column">
                                <!--begin::Status-->
                                <div class="d-flex align-items-center mb-1">
                                    <span class="text-gray-800 fs-2 fw-bold me-3">Atur target Penjualan</span>
                                    <button class="badge badge-light-dark me-auto" data-bs-toggle="modal" {{$targetPenjualan > 0 ? 'data-bs-target=#alerttarget' : 'data-bs-target=#target'}}><i class="ki-solid ki-gear fs-2x hover-rotate-end"></i></button>
                                </div>
                                <!--end::Status-->
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::Head-->
                        <!--begin::Info-->
                        <div class="d-flex flex-wrap justify-content-center">
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap">
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="ki-outline ki-calendar-add text-dark fs-1 me-2"></i>
                                        <div class="fs-4 fw-bold"> {{$bulanSekarang1}}, {{$tahunSekarang}}</div>
                                    </div>
                                    <!--end::Number-->
        
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Bulan</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
        
                                <!--begin::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-tag text-dark fs-1 me-2"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>  
                                        <div class="fs-4 fw-bold counted">Rp{{number_format($penjualanTerjual)}}</div>
                                    </div>
                                    <!--end::Number-->                                
        
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Penghasilan</div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Stat-->
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <!--begin::Number-->
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-tag text-dark fs-1 me-2"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>                                
                                        <div class="fs-4 fw-bold counted">Rp{{number_format($targetPenjualan)}}</div>
                                    </div>
                                    <!--end::Number-->                                
        
                                    <!--begin::Label-->
                                    <div class="fw-semibold fs-6 text-gray-400">Target Penghasilan</div>
                                    <!--end::Label-->
                                </div>
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Details-->
            </div>
        </div>
    </div>
</div>

<!--begin-->
<div class="modal fade" tabindex="-1" id="target">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Atur Target</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>                  
            <form action="{{ route('aturtarget') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                 <div class="py-5">
                     <div class="input-group mb-5 mt-3 d-flex flex-row-fluid flex-center">
                        <div class="fs-4 fw-bold counted alert {{$targetPenjualan > 0 ? 'alert-success' : 'alert-primary'}}">Target Penghasilan Sekarang Rp{{number_format($targetPenjualan)}}</div>
                     </div>
                     <div class="input-group mb-5 mt-3">
                     <input type="text" class="form-control form-control-solid" placeholder="Masukan Tujuan Penghasilan" name="tujuan_penghasilan" id="tujuan_penghasilan">
                    </div>
                 </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>          
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="alerttarget">
    <div class="modal-dialog">
        <div class="modal-content bg-primary">
            <!--begin::Alert-->
            <div class="alert alert-dismissible bg-primary d-flex flex-column flex-sm-row">
                <!--begin::Icon-->
                <i class="ki-duotone ki-notification-bing fs-2hx text-light me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                <!--end::Icon-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <!--begin::Title-->
                    <h4 class="mb-2 light">Peringatan</h4>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <span>Target sudah ada , Apakah anda ingin mengubahnya?</span>
                    <!--end::Content-->
                </div>
                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="modal" data-bs-dismiss="alert">
                    <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span class="path2"></span></i>
                </button>
                <!--end::Wrapper-->
            </div>
            <!--end::Alert-->
                <button data-bs-toggle="modal" data-bs-target="#target" class="btn btn-primary">Lanjutkan</button> 
        </div>
    </div>
</div>

@endsection
