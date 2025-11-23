@extends('layouts.student')
@section('title', 'Confirm Password')
@section('content')
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <h1 class="text-dark mb-3">Confirm Your Password</h1>
                    <div class="text-gray-400 fw-semibold fs-4">
                        This is a secure area. Please confirm your password before continuing.
                    </div>
                </div>
                <!--end::Heading-->

                <!--begin::Form-->
                <form method="POST" action="{{ route('password.confirm') }}" class="form w-100">
                    @csrf

                    <!-- Password -->
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bold text-dark">Password</label>
                        <input type="password"
                               name="password"
                               autocomplete="current-password"
                               class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="is-invalid text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg w-100 mb-5"
                                style="background-color: var(--bs-custom); color: var(--bs-white);">
                            Confirm
                        </button>
                    </div>
                </form>
                <!--end::Form-->

                <!-- Back to login link (optional) -->
                <div class="text-center text-gray-400 fw-semibold fs-6 mt-4">
                    Not you?
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="link-primary fw-bold">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>

            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
@endsection

