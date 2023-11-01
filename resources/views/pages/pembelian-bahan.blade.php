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
                    <input type="text" data-kt-pengeluaran-product-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Cari No Transaksi" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div style="width: 115px">
                    <input class="form-control" placeholder="Pick a date" id="kt_datepicker_1"/>
                </div>
                <!--begin::Add product-->
                <button type="button" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_2">
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
                    @forelse ($transaksi as $p)
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
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Products-->
</div>

<!--modal-->

<div class="modal fade" tabindex="-1" id="kt_modal_2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Insert Data Baru</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->

            </div>

        <form action="{{ route('pengeluaranT') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">

                <!--begin::Repeater-->
                <div id="form_pembelian">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="form_pembelian">
                            <div data-repeater-item>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_2" data-placeholder="Kategori" name="category" data-allow-clear="true" aria-describedby="basic-addon1">
                                            <option></option>
                                            @foreach ($dataKategori as $nilai => $teks)
                                            <option value="{{ $teks }}">{{ $teks }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control form-control-solid mb-1 mb-md-4" name="requirement" placeholder="Nama Pengeluaran" />
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control form-control-solid mb-1 mb-md-4" name="price" placeholder="Harga satuan" />
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control form-control-solid mb-1 mb-md-4" name="quantity" placeholder="Jumlah" />
                                    </div>
                                    <div class="col-md-1">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-1 mt-md-1">
                                            <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group mt-5">
                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                            Add
                        </a>
                    </div>
                    <!--end::Form group-->
                </div>
                <!--end::Repeater-->

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
@push('pembelian_repeater')
<script>
    $('#form_pembelian').repeater({
    initEmpty: false,

    defaultValues: {
        'text-input': 'foo'
    },

    show: function () {
        $(this).slideDown();
    },

    hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
    }
});
</script>
@endpush
