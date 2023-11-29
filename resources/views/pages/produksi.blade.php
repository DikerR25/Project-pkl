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
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
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

            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <button type="button" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_stacked_2">
                    Tambah Menu
                </button>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

        </div>

        <div class="modal fade" tabindex="-1" id="kt_modal_stacked_2">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Modal title</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <form action="{{ Route('inputdataproduksi') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <input class="form-control d-flex align-items-center form-control-solid" name="name" placeholder="Nama produk" />
                            </div>

                            <div class="mb-3">
                                <select class="form-select form-select-solid" data-control="select2" data-dropdown-parent="#kt_modal_stacked_2" data-placeholder="Kategori" name="category" data-allow-clear="true" aria-describedby="basic-addon1">
                                    <option></option>
                                    @foreach ($dataKategori as $nilai => $teks)
                                    <option value="{{ $teks }}">{{ $teks }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <input class="form-control d-flex align-items-center form-control-solid" name="Ingredients" placeholder="Masukan Bahan-bahan" value="" id="kt_tag_produksi" />
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <select class="form-select form-select-solid" data-control="select2" id="tag_value">
                                        <option value="">Pilih Bahan</option>
                                        @foreach($bahan as $bahanItem)
                                            <option value="{{ $bahanItem }}">{{ $bahanItem }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input class="form-control d-flex align-items-center form-control-solid" type="number" id="tag_quantity" min="0" placeholder="Masukkan Jumlah">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-success" onclick="addTag()">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body pt-0">
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="table_penjualan">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th>No</th>
                        <th>Nama menu</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataproduk as $p)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category }}</td>
                        <td>{{ $p->base_quantity }}</td>
                        <td>{{number_format($p->price,2)}}</td>
                        <td> <div class="menu-item px-3">
                                <button class="btn btn-gray-800 px-0 pb-0 pt-0 edit-btn" data-id="{{ $p->id }}" data-bs-toggle="modal" data-bs-target="#editP{{ $p->id }}">
                                    <i class="ki-duotone ki-eye text-primary fs-2x" data-bs-toggle="tooltip" title="Produksi">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                        <i class="path3"></i>
                                    </i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <div class="alert alert-danger">Data Post belum Tersedia.</div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!--end::Products-->
</div>

<!--view-->
<!--edit-->
@foreach($dataproduk as $p)
<div class="modal fade" tabindex="-1" id="editP{{ $p->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $p->name }}</h3>
                <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>

            <form id="editCategoryForm" method="POST" action="/produksi/{{$p->name}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="table_penjualan">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                <th>No</th>
                                <th>Nama menu</th>
                                <th>Kategori</th>
                                <th>Bahan</th>
                                <th>Jumlah</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                @if ($d->name == $p->name)
                                    @php
                                        $ingredientsArray = json_decode($d->Ingredients, true);
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$p->name}}</td>
                                        <td>{{$p->category}}</td>
                                        <td>
                                            @foreach ($ingredientsArray as $item)
                                                @php
                                                    $itemName = strtok($item['value'], ':');
                                                @endphp
                                                <p>{{ $itemName }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($ingredientsArray as $item)
                                                @php
                                                    $valueParts = explode(':', $item['value']);
                                                    $itemValue = end($valueParts);
                                                @endphp
                                                <p>{{ $itemValue }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($ingredientsArray as $item)
                                                @php
                                                    $itemName = strtok($item['value'], ':');
                                                    $stokGudang = App\Models\Stock_Storage::where('name', $itemName)->first();
                                                @endphp
                                                @if ($stokGudang)
                                                    <p>{{ $stokGudang->base_quantity }}</p>
                                                @else
                                                    <p>Stok Gudang Tidak Tersedia</p>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    @foreach ($data as $d)
                        @if ($d->name == $p->name)
                            @php
                            $dataBahan = json_decode( $d->Ingredients, true);
                            $menuJumlah = null;

                            foreach ($dataBahan as $item) {
                                $parts = explode(':', $item['value']);
                                $namaBahan = strtolower($parts[0]);
                                $jumlahBahan = (int) $parts[1];

                                $stokGudang = App\Models\Stock_Storage::where('name', $namaBahan)->first();

                                if ($stokGudang) {
                                    $jumlahMenu = (int) ($stokGudang->base_quantity / $jumlahBahan);

                                    if ($menuJumlah === null || $jumlahMenu < $menuJumlah) {
                                        $menuJumlah = $jumlahMenu;
                                    }
                                }
                            }
                            @endphp
                            <div class="form-group row justify-content-center align-items-center">
                                <div class="col-md-4">
                                    <span class="fw-semibold fs-6 text-gray-800">Maximal menu yang diproduksi: {{ $menuJumlah }}</span>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control form-control-solid" type="number" name="base_quantity" max="{{$menuJumlah}}" min="0" placeholder="Masukkan Jumlah">
                                </div>
                                <input type="hidden" name="Ingredients" value="{{$d->Ingredients}}">
                                <input type="hidden" name="name_product" value="{{$p->name}}">
                            </div>
                        @endif
                @endforeach
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

@push('produksi')
<script>
    var Bahan = {!! json_encode($bahan) !!};
    var tagify = new Tagify(document.querySelector('#kt_tag_produksi'), {
        delimiters: null,
        enforceWhitelist: false,
        whitelist: Bahan,
        dropdown: {
            enabled: 1,
            classname: 'extra-properties'
        }
    })

    var tagsToAdd = tagify.settings.whitelist.slice(0, 0);
    tagify.addTags(tagsToAdd);

    function addTag() {
        var tagValue = document.getElementById('tag_value').value;
        var tagQuantity = document.getElementById('tag_quantity').valueAsNumber || 1;

        var newTag = {"value": tagValue, "quantity": tagQuantity};

        tagify.whitelist.push(tagValue);
        tagify.addTags(`${tagValue}:${tagQuantity}`);
    }
    </script>
 @endpush
