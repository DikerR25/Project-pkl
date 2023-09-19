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
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-penjualan-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Nama Barang..." />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div class="w-100 mw-200px">
                    <!--begin::Select2-->
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kategori Barang" data-kt-penjualan-product-filter="kategori">
                        <option></option>
                        <option value="all">All</option>
                        @foreach ($dataKategori as $nilai => $teks)
                            <option value="{{ $teks }}">{{ $teks }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="table_penjualan">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Total Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category => $items)
                @php
                    $categoryTotal = 0;
                @endphp
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>
                            <input type="number" class="quantity-input form-control"
                                   data-base-quantity="{{ $item->base_quantity }}"
                                   data-price="{{ $item->price }}"
                                   value="{{ $item->base_quantity }}"
                                   min="0" max="{{ $item->base_quantity }}">
                        </td>
                        <td>Rp{{ number_format($item->price, 2) }}</td>
                        <td class="total">Rp0</td>
                        <td class="barangDikurangi">0</td>
                    </tr>
                    @empty
                            <div class="alert alert-danger">Data Post belum Tersedia.</div>
                @endforelse
                @empty
                            <div class="alert alert-danger">Data Post belum Tersedia.</div>
                @endforelse
                </tbody>
            </table>
            <div id="total-price">
                Total Harga: <span id="total-amount">Rp0</span>
            </div>
            <div class="d-flex flex-column-fluid flex-center">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <button id="save-button" class="btn btn-sm btn-success">Simpan</button>
            </div>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Products-->
</div>
@endsection
@push('scriptpenjualanM')
<script src="/assets/js/menujual.js"></script>
@endpush
