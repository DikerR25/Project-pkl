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
    <div class="card mb-5">
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

    <!--page-table-->
    <!--begin::Products-->
    <div class="card card-flush mb-5">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="text-gray-800 fs-2 fw-bold me-3 ps-1">Daftar Kategori Pada Pengeluaran</span>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Add product-->
                <button type="button" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_kategoriP">
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
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th><div class="px-7">Aksi</div></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($KategoriP as $P)
                    <tr>
                        <td><div class="px-0 pb-0 pt-3">{{$P->id}}</div></td>
                        <td><div class="px-0 pb-0 pt-3">{{ $P->category }}</div></td>
                        <td>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="right" data-kt-menu-overflow="true">
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
                                        <button class="btn btn-gray-800 px-0 pb-0 pt-0 edit-btn" data-id="{{ $P->id }}" data-bs-toggle="modal" data-bs-target="#editP{{ $P->id }}">
                                            <i class="ki-duotone ki-notepad-edit text-warning fs-2x" data-bs-toggle="tooltip" title="Edit">
                                                <i class="path1"></i>
                                                <i class="path2"></i>
                                            </i>
                                        </button>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        @csrf
                                        <a href="{{ route('deleteP', $P->id) }}"><i class="ki-duotone ki-trash text-danger fs-2x" data-bs-toggle="tooltip" title="Delete"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i><i class="path5"></i></i></a>
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

    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <span class="text-gray-800 fs-2 fw-bold me-3 ps-1">Daftar Kategori Pada Penjualan</span>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Add product-->
                <button type="button" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_kategoriJ">
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
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th><div class="px-7">Aksi</div></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($KategoriJ as $J)
                    <tr>
                        <td><div class="px-0 pb-0 pt-3">{{$loop->iteration}}</div></td>
                        <td><div class="px-0 pb-0 pt-3">{{ $J->category }}</div></td>
                        <td>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="right" data-kt-menu-overflow="true">
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
                                        <button class="btn btn-gray-800 px-0 pb-0 pt-0 edit-btn" data-id="{{ $J->id }}" data-bs-toggle="modal" data-bs-target="#editJ{{ $J->id }}"><i class="ki-duotone ki-notepad-edit text-warning fs-2x" data-bs-toggle="tooltip" title="Edit"><i class="path1"></i><i class="path2"></i></i></button>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        @csrf
                                        <a href="{{ route('deleteJ', $J->id) }}"><i class="ki-duotone ki-trash text-danger fs-2x" data-bs-toggle="tooltip" title="Delete"><i class="path1"></i><i class="path2"></i><i class="path3"></i><i class="path4"></i><i class="path5"></i></i></a>
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
</div>


<!--modal-->
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

<div class="modal fade" tabindex="-1" id="kt_modal_kategoriP">
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

        <form action="{{ route('saveP') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">

                 <div class="py-5">
                     <div class="input-group mb-5">
                         <input type="text" class="form-control form-control-solid" name="category" placeholder="Masukan Nama Kategori" aria-describedby="basic-addon1"/>
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

<div class="modal fade" tabindex="-1" id="kt_modal_kategoriJ">
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

        <form action="{{ route('saveJ') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">

                 <div class="py-5">
                     <div class="input-group mb-5">
                         <input type="text" class="form-control form-control-solid" name="category" placeholder="Masukan Nama Kategori" aria-describedby="basic-addon1"/>
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

<!--edit-->
@foreach($KategoriP as $P)
<div class="modal fade" tabindex="-1" id="editP{{ $P->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Kategori</h3>
                <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>

            <form id="editCategoryForm" method="POST" action="{{ route('updateP', $P->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="py-5">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control form-control-solid" id="category" name="category" placeholder="Masukan Nama Kategori" aria-describedby="basic-addon1" value="{{ $P->category }}">
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
@endforeach

@foreach($KategoriJ as $J)
<div class="modal fade" tabindex="-1" id="editJ{{ $J->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Kategori</h3>
                <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>

            <form id="editCategoryForm" method="POST" action="{{ route('updateJ', $J->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="py-5">
                        <div class="input-group mb-5">
                            <input type="text" class="form-control form-control-solid" id="category" name="category" placeholder="Masukan Nama Kategori" aria-describedby="basic-addon1" value="{{ $J->category }}">
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
@endforeach

@endsection
@push('kategoriP')
@endpush
