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

        <li class="breadcrumb-item text-gray-700 fw-bold lh-1"> Account </li>

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
    <div class="row">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <!--begin::details View-->
                <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                    <!--begin::Card header-->
                    <div class="card-header cursor-pointer">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Profile Details</h3>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Action-->
                        <button type="button" class="btn btn-sm btn-primary align-self-center btn-edit" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                            Edit Profil 
                        </button>

                        <div class="modal fade" tabindex="-1" id="kt_modal_1">
                            <div class="modal-dialog">
                                <form action="{{ route('profile.update', ['id' => Auth::user()->id]) }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Edit Profile</h3>
                        
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                        
                                    <div class="modal-body">
                            
                                        {{-- <div class="input-group mb-5">
                                            <input type="text" class="form-control form-control-solid" name="name" placeholder="Nama" aria-describedby="basic-addon1" value="{{ old('name', Auth::user()->name)  }}"/>
                                        
                                        </div>
                                        @error('name')
                                        <small>{{ $message }}</small>
                                    @enderror
                                        <div class="input-group mb-5">
                                            <input type="email" class="form-control form-control-solid" name="email" placeholder="Email" aria-describedby="basic-addon1" value="{{ old('email', Auth::user()->email) }}"/>
                                            
                                        </div>
                                        @error('email')
                                                <small>{{ $message }}</small>
                                            @enderror --}}
                                        <div class="input-group mb-5">
                                            <input type="file" class="form-control
                                            form-control-solid" name="image" required aria-describedby="basic-addon1"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Action-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-9">
                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Nama</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->name }}</span>
                                {{-- <span class="badge {{$p->access == 'Admin' ? 'badge-light-success' : ($p->access == 'Pegawai' ? 'badge-light-primary' : 'badge-light-warning') }} fw-bold fs-8 px-2 py-1 ms-2">{{ $p->access }}</span> --}}
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Perusahaan</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <span class="fw-semibold text-gray-800 fs-6">Nyan Cafe</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Email</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 d-flex align-items-center">
                                <span class="fw-bold fs-6 text-gray-800 me-2">{{ Auth::user()->email }}</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Web Perusahaan</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <a href="/dashboard" class="fw-semibold fs-6 text-gray-800 text-hover-primary">nyan-cafe.co.id</a>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Negara</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <span class="fw-bold fs-6 text-gray-800">Indonesia</span>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-10">
                            <!--begin::Label-->
                            <label class="col-lg-4 fw-semibold text-muted">Akses</label>
                            <!--begin::Label-->
                            <!--begin::Label-->
                            <div class="col-lg-8">
                                <span class="fw-semibold fs-6 text-gray-800">{{ Auth::user()->akses }}</span>
                            </div>
                            <!--begin::Label-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::details View-->
            </div>
            <!--end::Content container-->
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session()->has('message'))
    <script>
			Swal.fire('{{ session()->get('message') }}')
    </script>
@endif
@if (session()->has('failed'))
    <script>
			Swal.fire('{{ session()->get('failed') }}')
    </script>
@endif


@endsection
