@extends('layouts.student')
@section('title', 'Login')
@section('content')
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

                <!--begin::Form-->
                <form class="form w-100" action="{{ route('login') }}" method="POST">
                    @csrf
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <!--begin::Title-->
                        <h1 class="text-dark mb-3">
                            Sign In to SorSu <br> Bulan Document Request </h1>
                        <!--end::Title-->

                        <!--begin::Link-->
                        <div class="text-gray-400 fw-semibold fs-4">
                            New Here?

                            <a href="{{ route('register') }}" class="link-primary fw-bold">
                                Create an Account
                            </a>
                        </div>
                        <!--end::Link-->
                    </div>
                    <!--begin::Heading-->
                    @if (session('status'))
                        <div class="alert alert-success text-center mt-2">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fs-6 fw-bold text-dark">Email</label>
                        <input type="email"
                            class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email" >
                        @error('email')
                            <div class="is-invalid text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack mb-2">
                            <!--begin::Label-->
                            <label class="form-label fw-bold text-dark fs-6 mb-0">Password</label>
                            <!--end::Label-->

                            <!--begin::Link-->
                            <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bold">
                                Forgot Password ?
                            </a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Input-->
                        <div class="position-relative">
                            <input
                                id="login_password"
                                type="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="off"
                                class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" />

                            <i class="fas fa-eye toggle-password" id="toggleLoginPassword"
                            style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                        </div>
                        @error('password')
                            <div class="is-invalid text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center">
                        <!--begin::Submit button-->
                        <button type="submit" class="btn btn-lg  w-100 mb-5"
                            style="background-color: var(--bs-custom); color: var(--bs-white); ">
                            <span class="indicator-label">
                                Continue
                            </span>
                        </button>
                        <!--end::Submit button-->
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
