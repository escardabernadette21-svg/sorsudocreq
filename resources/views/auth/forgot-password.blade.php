@extends('layouts.student')
@section('title', 'Forgot Password')
@section('content')
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">
                            Forgot Your Password?
                        </h1>
                        <!--end::Title-->

                        <!--begin::Description-->
                        <div class="text-gray-400 fw-semibold fs-4">
                            No problem. Just enter your email address and we’ll send you a password reset link.
                        </div>
                        <!--end::Description-->
                    </div>
                    <!--end::Heading-->

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bold text-dark">Email</label>
                        <input type="email"
                            class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Enter Email">

                        @error('email')
                            <div class="is-invalid text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg w-100 mb-5"
                            style="background-color: var(--bs-custom); color: var(--bs-white);">
                            Send Password Reset Link
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
@endsection
