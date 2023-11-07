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

        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> Laba Rugi </li>

        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
        </li>

        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> {{$title}} </li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
    <!--begin::Title-->
    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0"> {{$title}} Laba Rugi</h1>
    <!--end::Title-->
</div>
<!--end::App-->
@endsection

@section('konten')
<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card mb-10">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <!--begin::Wrapper-->
                <div class="flex-grow-1">
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap justify-content-center">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-3 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-outline ki-calendar-add text-dark fs-1 me-2"></i>
                                    <div class="fs-4 fw-bold"> {{$tanggal}} </div>
                                </div>
                                <!--end::Number-->
    
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Tanggal</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
    
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-3 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-purchase text-dark fs-1 me-2"><i class="path1"></i><i class="path2"></i></i>                                
                                    <div class="fs-4 fw-bold counted">{{$stok}}</div>
                                </div>
                                <!--end::Number-->
    
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Stok Terjual</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
    
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-3 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-tag text-dark fs-1 me-2"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>  
                                    <div class="fs-4 fw-bold counted">Rp{{number_format($pendapatanL)}}</div>
                                </div>
                                <!--end::Number-->                                
    
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Penghasilan</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-3 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-tag text-dark fs-1 me-2"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>                                
                                    <div class="fs-4 fw-bold counted">Rp{{number_format($pengeluaranL)}}</div>
                                </div>
                                <!--end::Number-->                                                               
    
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Pengeluaran</div>
                                <!--end::Label-->
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-3 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-tag text-dark fs-1 me-2"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i>                                
                                    <div class="fs-4 fw-bold counted me-2">Rp{{number_format($pendapatanL-$pengeluaranL)}}</div>
                                    @if ($persentasePerubahan > -1) 
                                        <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            </i>{{ number_format($persentasePerubahan, 2) }}%</span> 
                                    @else 
                                        <span class="badge badge-light-danger fs-base">
                                            <i class="ki-duotone ki-arrow-down fs-5 text-danger ms-n1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>{{ number_format($persentasePerubahan, 2) }}%</span> 
                                    @endif
                                </div>
                                <!--end::Number-->                                
    
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Penghasilan Bersih</div>
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
    <!--begin::Products-->
    <div class="card card-flush mb-10">
        <!--begin::Input group-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-penjualan-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari No Transaksi..." />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">  
                <div class="fw-bold badge badge-light-warning">Pendapatan</div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <div class="card-body pt-0">
            <!--begin::Header-->
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="table_penjualan_laba">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Total Harga</th>
                        <th>Jumlah Bahan</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendapatan as $p)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $p->invoice }}</td>
                        <td>Rp{{  number_format($p->total_price, 2) }}</td>
                        <td>{{ $p->total_quantity }}</td>
                        <td>{{ date('d-m-Y', strtotime(substr($p->invoice, 4, 8))) }}</td>
                        <td><a href="/pages/pendapatan/{{$p->invoice}}"><i class="ki-duotone ki-eye text-primary fs-2x" data-bs-toggle="tooltip" title="View"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i></a></td>
                    </tr>
                    @empty
                        <div class="alert alert-danger">Data Post belum Tersedia.</div>
                    @endforelse
                </tbody>
            </table>
            <!--end::Header-->
        </div>
     <!--end::Input group-->
    </div>
    <div class="card card-flush">
        <!--begin::Input group-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-pengeluaran-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari No Transaksi..." />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5"> 
                <div class="fw-bold badge badge-light-warning"> Pengeluaran </div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <div class="card-body pt-0">
            <!--begin::Header-->
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="table_pengeluaran">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Total Harga</th>
                        <th>Jumlah Bahan</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengeluaran as $p)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $p->invoice }}</td>
                        <td>Rp{{  number_format($p->total_price, 2) }}</td>
                        <td>{{ $p->total_quantity }}</td>
                        <td>{{ date('d-m-Y', strtotime(substr($p->invoice, 4, 8))) }}</td>
                        <td><a href="/pages/pembelian-bahan/{{$p->invoice}}"><i class="ki-duotone ki-eye text-primary fs-2x" data-bs-toggle="tooltip" title="View"><i class="path1"></i><i class="path2"></i><i class="path3"></i></i></a></td>
                    </tr>
                    @empty
                        <div class="alert alert-danger">Data Post belum Tersedia.</div>
                    @endforelse
                </tbody>
            </table>
            <!--end::Header-->
        </div>
     <!--end::Input group-->
    </div>
</div>
@endsection
