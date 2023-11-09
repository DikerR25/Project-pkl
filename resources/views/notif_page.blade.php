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
<div class="container px-5">
    @forelse($notifications as $notification)
    <div class="alert {{ $notification->read_at ? 'alert-secondary' : 'alert-success' }} d-flex" role="alert" id="notification">
        <i class="bi bi-exclamation-circle-fill text-primary mt-1 px-2"></i>
        @csrf
        {{ $notification->created_at->format('d-m-Y') }} | 
        @if ($notification->type === 'App\Notifications\PengeluaranNotif')
            {{ $notification->data['message'] }}
        @elseif ($notification->type === 'App\Notifications\RegistrationSuccesful')
            {{ $notification->data['newUserMessage'] }}
        @endif
        <div class="d-flex px-1 justify-center items-center text-center">
            <form action="{{ route('deleteNotif', $notification->id) }}" method="POST">
                @csrf
                <button type="submit" class="border-0 bg-transparent block text-primary d-inline">Hapus</button>
            </form>
            <span >|</span>
            <form method="POST" action="{{ route('markAsRead', $notification->id) }}">
                @csrf
                @if ($notification->read_at === null)
                    <button type="submit" class="border-0 bg-transparent block text-primary d-inline">Tandai Sudah Dibaca</button>
                @else
                    <button type="submit" class="border-0 bg-transparent block text-primary d-inline opacity-50" disabled>Tandai Sudah Dibaca</button>
                @endif
            </form>       
        </div>     
    </div>
    @empty
    <div class="alert alert-dark" role="alert">
        Tidak Ada Notifikasi Terbaru!!
    </div>
    @endforelse
</div>





@endsection

    