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
    <div class="row g-5 g-xl-10 mb-xl-10">
        <div class="table-responsive">
            <table class="table table-striped table-row-bordered gy-5 gs-7 border rounded" id="kt_datatable_dom_positioning">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                        <th >ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Akses</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($manages as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td><a href="/account/{{$t->name}}/" class="text-gray-800 text-hover-primary mb-1">{{ $t->name }}</a></td>
                        <td><a href="/account/{{$t->name}}/" class="text-gray-800 text-hover-primary mb-1">{{ $t->email }}</a></td>
                        <td><span class="badge {{$t->akses == 'admin' ? 'badge-light-success' : ($t->akses == 'User' ? 'badge-light-primary' : 'badge-light-warning') }}">{{ $t->akses   }}</span></td>
                        <td>{{ $t->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @empty
                                  <div class="alert alert-danger">
                                      Data Post belum Tersedia.
                                  </div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
