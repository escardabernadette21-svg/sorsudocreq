@extends('layouts.student')

@section('title')
    Profile Account
@endsection

@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl py-5 py-lg-15">
        <div class="content flex-row-fluid" id="kt_content" style="border:2px solid var(--bs-custom); border-radius:1%">
            <div class="card">
                <form id="profile-form" class="form" action="{{ route('student-account.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-9">
                        <h4 class="mb-6">Profile Information</h4>

                        {{-- Profile Picture --}}
                        <div class="row mb-6 justify-content-center">
                            <div class="col-lg-8">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg"
                                            name="profile_picture" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview"
                                            style="background-image: url('{{ asset('storage/student/profile/' . Auth::user()->profile_picture) }}')">
                                        </div>
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                    @error('profile_picture')
                                        <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Full Name --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <input type="text" name="firstname" class="form-control form-control-lg "
                                            placeholder="Firstname" value="{{ Auth::user()->firstname }}" />
                                        @error('firstname')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <input type="text" name="middlename" class="form-control form-control-lg "
                                            placeholder="Middlename" value="{{ Auth::user()->middlename }}" />
                                        @error('middlename')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="lastname" class="form-control form-control-lg"
                                            placeholder="Lastname" value="{{ Auth::user()->lastname }}" />
                                        @error('lastname')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Email Address</label>
                            <div class="col-lg-8">
                                <input type="email" name="email" class="form-control form-control-lg"
                                    placeholder="Email" value="{{ Auth::user()->email }}" />
                                @error('email')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Account Role</label>
                            <div class="col-lg-8">
                                <input type="text" name="role" class="form-control form-control-lg form-control-solid"
                                    placeholder="Role" value="{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}"
                                    readonly />
                                @error('role')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Student ID --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Student ID</label>
                            <div class="col-lg-8">
                                <input type="text" name="student_id"
                                    class="form-control form-control-lg form-control-solid" placeholder="Student ID"
                                    value="{{ Auth::user()->student_id }}" readonly />
                                @error('student_id')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone Number --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Phone Number</label>
                            <div class="col-lg-8">
                                <input type="text" name="phone_number" class="form-control form-control-lg"
                                    placeholder="Phone Number" value="{{ Auth::user()->phone_number }}" />
                                @error('phone_number')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Course & Year / Batch Year --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Course & Year/Batch</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <input type="text" name="course"
                                            class="form-control form-control-lg form-control-solid" placeholder="Course"
                                            value="{{ Auth::user()->course }}" readonly />
                                        @error('course')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        @if (Auth::user()->student_type == 'enrolled')
                                            <select class="form-select form-control form-control-lg" name="year"
                                                style="padding:10px">
                                                <option value="">Select Year</option>
                                                <option value="1st Year"
                                                    {{ Auth::user()->year == '1st Year' ? 'selected' : '' }}>1st Year
                                                </option>
                                                <option value="2nd Year"
                                                    {{ Auth::user()->year == '2nd Year' ? 'selected' : '' }}>2nd Year
                                                </option>
                                                <option value="3rd Year"
                                                    {{ Auth::user()->year == '3rd Year' ? 'selected' : '' }}>3rd Year
                                                </option>
                                                <option value="4th Year"
                                                    {{ Auth::user()->year == '4th Year' ? 'selected' : '' }}>4th Year
                                                </option>
                                            </select>
                                            @error('year')
                                                <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        @elseif(Auth::user()->student_type == 'alumni')
                                            <input type="number" name="batch_year"
                                                class="form-control form-control-lg"
                                                placeholder="Batch Year" value="{{ Auth::user()->batch_year }}"
                                                min="1900" max="{{ date('Y') }}" />
                                            @error('batch_year')
                                                <span class="text-danger mt-1">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Student Type --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Student Type</label>
                            <div class="col-lg-8">
                                <input type="text" name="student_type"
                                    class="form-control form-control-lg form-control-solid" placeholder="Student Type"
                                    value="{{ Auth::user()->student_type }}" readonly />
                                @error('student_type')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">New Password</label>
                            <div class="col-lg-8 position-relative">
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg" placeholder="New Password" />
                                <i class="toggle-password fas fa-eye" id="togglePassword"
                                    style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                                @error('password')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-6">
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Confirm Password</label>
                            <div class="col-lg-8 position-relative">
                                <input type="password" name="password_confirmation" id="confirmPassword"
                                    class="form-control form-control-lg" placeholder="Confirm New Password" />
                                <i class="toggle-password fas fa-eye" id="toggleConfirmPassword"
                                    style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                                @error('password_confirmation')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="submit" class="btn btn-sm text-white" style="background-color: #8F0C00;">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
