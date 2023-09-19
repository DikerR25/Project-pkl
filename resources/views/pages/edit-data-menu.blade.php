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

        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> Stok Barang </li>

        <li class="breadcrumb-item">
            <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
        </li>

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
        <!--begin::Input group-->
        <div class="card card-flush overflow-hidden h-md-100">
            <!--begin::Header-->
            @foreach ($menus as $menu)
            <form action="/pages/{{ $menu->id}}/edit-data-menu" method="POST" enctype="multipart/form-data">
                  @csrf
            <div class="py-5">
                <div class="input-group mb-5 mt-3">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Pilih Kategori Menu" name="category" value="{{ $menu->kategori }}" aria-describedby="basic-addon1">
                        <option></option>
                        @foreach ($dataKategori as $nilai => $teks)
                                <option {{ ($menu->category == $teks) ? 'selected' : '' }} value="{{ $teks }}">{{ $teks }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="input-group mb-5">
                    <input type="text" class="form-control form-control-solid" name="name" value="{{ $menu->name }}" placeholder="Masukan Nama Menu" aria-describedby="basic-addon1"/>
                </div>
                <div class="input-group mb-5">
                    <input type="text" class="form-control form-control-solid" name="base_quantity" value="{{ $menu->base_quantity }}" placeholder="Jumlah" aria-describedby="basic-addon1"/>
                </div>
                <div class="input-group mb-5">
                    <input type="text" class="form-control form-control-solid" name="price" value="{{ $menu->price }}" placeholder="Harga" aria-describedby="basic-addon1"/>
                </div>
            </div>
            <div class="text-center mb-8">
                <button type="submit" class="btn btn-sm btn-success">SIMPAN</button>
            </div>
        </form>
        @endforeach
        </div>
     <!--end::Input group-->
    </div>
</div>
@endsection
