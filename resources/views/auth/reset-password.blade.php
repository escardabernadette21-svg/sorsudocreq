@extends('layouts.student')
@section('title', 'Reset Password')
@section('content')
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                <!--begin::Form-->
                <form class="form w-100" method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <h1 class="text-dark mb-3">Reset Your Password</h1>
                        <div class="text-gray-400 fw-semibold fs-4">
                            Enter your new password below.
                        </div>
                    </div>
                    <!--end::Heading-->

                    <!--begin::Email-->
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bold text-dark">Email</label>
                        <input type="email"
                            class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email', $request->email) }}" required autocomplete="username"
                            autofocus>
                        @error('email')
                            <div class="is-invalid text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Email-->

                    <!--begin::Password-->
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bold text-dark">New Password</label>
                        <div class="position-relative">
                            <input type="password"
                                class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror"
                                name="password" id="password" required autocomplete="new-password"
                                placeholder="Enter new password">
                            <i class="fas fa-eye toggle-password" id="togglePassword"
                                style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                        </div>
                        @error('password')
                            <div class="is-invalid text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Password-->

                    <!--begin::Confirm Password-->
                    <div class="fv-row mb-10">
                        <label class="form-label fs-6 fw-bold text-dark">Confirm Password</label>
                        <div class="position-relative">
                            <input type="password"
                                class="form-control form-control-lg form-control-solid @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm password">
                            <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"
                                style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                        </div>
                        @error('password_confirmation')
                            <div class="is-invalid text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!--end::Confirm Password-->

                    <!--end::Confirm Password-->

                    <!--begin::Submit-->
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg w-100 mb-5"
                            style="background-color: var(--bs-custom); color: var(--bs-white);">
                            Reset Password
                        </button>
                    </div>
                    <!--end::Submit-->

                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
@endsection
