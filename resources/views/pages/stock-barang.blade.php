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

<div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Insert Data Baru</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

        <form action="{{ route('simpandatamenu') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                    
                 <div class="py-5">
                     <div class="input-group mb-5 mt-3">
                         <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_1" data-placeholder="Pilih Kategori Barang" name="category" data-allow-clear="true" aria-describedby="basic-addon1">
                             <option></option>
                             @foreach ($dataKategori as $nilai => $teks)
                                <option value="{{ $teks }}">{{ $teks }}</option>
                            @endforeach
                         </select>
                     </div>
                     <div class="input-group mb-5">
                         <input type="text" class="form-control form-control-solid" name="name" placeholder="Masukan Nama Barang" aria-describedby="basic-addon1"/>
                     </div>
                     <div class="input-group mb-5">
                         <input type="text" class="form-control form-control-solid" name="base_quantity" placeholder="Jumlah" aria-describedby="basic-addon1"/>
                     </div>
                     <div class="input-group mb-5">
                         <input type="text" class="form-control form-control-solid" name="price" placeholder="Harga" aria-describedby="basic-addon1"/>
                     </div>
                 </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>
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
                        <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari Nama Barang..." />
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="w-100 mw-200px">
                        <!--begin::Select2-->
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Kategori Barang" data-kt-ecommerce-product-filter="status">
                            <option></option>
                            <option value="all">All</option>
                            @foreach ($dataKategori as $nilai => $teks)
                                <option value="{{ $teks }}">{{ $teks }}</option>
                            @endforeach
                        </select>
                        <!--end::Select2-->
                    </div>
                    <!--begin::Add product-->
                    <button type="button" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                        Buat Data Baru
                    </button>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="kt_ecommerce_products_table">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                            <th>No</th>
                            <th>Kategori </th>
                            <th>Nama </th>
                            <th>Jumlah </th>
                            <th>Harga </th>
                            <th>Terakhir Update </th>
                            <th>Dibuat Pada </th>
                            <th>Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($menus as $menu)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td data-order="{{ $menu->category }}">{{ $menu->category }}</td>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->base_quantity }}</td>
                            <td>Rp{{ number_format($menu->price, 2) }}</td>
                            <td>{{ $menu->updated_at->format('d-m-Y') }}</td>
                            <td>{{ $menu->created_at->format('d-m-Y') }}</td>
                            <td >
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                        <i class="ki-duotone ki-dots-square fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </button>
                                    <!--begin::Menu 2-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-50px card card-flush" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            @csrf
                                            <a href="{{ route('editdatamenu', $menu->id) }}" ><i class="ki-duotone ki-notepad-edit text-warning fs-2x" data-bs-toggle="tooltip" title="Edit"><i class="path1"></i><i class="path2"></i></i></a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            @csrf
                                            <a href="{{ route('deletedatamenu', $menu->id) }}"><i class="ki-duotone ki-trash text-danger fs-2x" data-bs-toggle="tooltip" title="Delete"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i><i class="path5"></i></i></a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu 2-->
                                    <!--end::Menu-->
                                </div>
                            </td>
                        </tr>
                        @empty
                            <div class="alert alert-danger">Data Post belum Tersedia.</div>
                        @endforelse
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Products-->
    </div>
    <!--end::Content container-->
@endsection
