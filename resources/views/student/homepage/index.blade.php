@extends('layouts.student')

@section('title')
    Student Homepage
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-column justify-content-center align-items-center text-center flex-grow-1">
        <div id="kt_toolbar_container" class="container-xxl">
            <div class="page-title">
                <h2 class="text-white fw-bolder fs-2qx my-1" style="font-size: 2.75rem; letter-spacing: 0.5px;">
                    Welcome, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!
                </h2>
                <span class="text-white opacity-80 pt-1 d-block">
                    Track your document requests and stay updated with <br> real-time notifications.
                </span>
            </div>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
               <a href="{{ route('document.request.index') }}" class="btn text-white fw-bold mt-5" style="background-color: var(--bs-custom);">
                    Start New Request
                </a>
                <a href="{{ route('document-request-status.index') }}" class="btn fw-bold mt-5"
                     style="background-color: var(--bs-white); border: 1px solid var(--bs-custom); color: var(--bs-custom);">
                     View Request Status
                </a>


            </div>
        </div>
    </div>
@endsection

