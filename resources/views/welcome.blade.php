@extends('layouts.student')

@section('title')
    Welcome to SorSu Bulan Document Request System
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-column flex-grow-1 justify-content-center justify-content-lg-end align-items-center align-items-lg-end text-center text-lg-end py-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl">
            <div class="page-title">
                <h4 class="text-white fw-bolder fs-2qx my-1">
                    Seamless Document Requests, <br> Anytime Anywhere
                </h4>
                <span class="text-white opacity-75 pt-1 d-block mb-3">
                    Your Documents, Just one Click Away.
                </span>
                <a href="{{ route('document.request.index') }}" class="btn text-white fw-bold" style="background-color: #8F0C00">
                    Start Your Request <i class="bi bi-arrow-right text-white"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
