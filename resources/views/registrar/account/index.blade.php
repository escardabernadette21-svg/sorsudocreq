@extends('layouts.registrar')

@section('title', 'Account Management')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Account</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- LEFT PROFILE CARD -->
                <div class="col-lg-4">
                    <div class="card comman-shadow">
                        <div class="card-body text-center">
                            <div class="profile-image mb-4">
                                <img class="rounded-circle img-fluid"
                                    src="{{ Auth::user()->profile_picture ? asset('storage/registrar/profile/' . Auth::user()->profile_picture) : asset('registrar/assets/img/blank.png') }}"
                                    style="width: 250px; height: 250px; object-fit: cover;">
                            </div>
                            <h5 class="card-title mb-3">Personal Information</h5>
                            <ul class="list-unstyled text-start">
                                <li class="mb-2">
                                    <span class="text-muted me-2">Fullname:</span>
                                    {{ Auth::user()->firstname }} {{ Auth::user()->middlename ?? '' }}
                                    {{ Auth::user()->lastname }}
                                </li>
                                <li class="mb-2">
                                    <span class="text-muted me-2">Email:</span>{{ Auth::user()->email }}
                                </li>
                                <li class="mb-2">
                                    <span class="text-muted me-2">Phone Number:</span>{{ Auth::user()->phone_number }}
                                </li>
                                <li>
                                    <span class="text-muted me-2">Role:</span>{{ ucfirst(Auth::user()->role) }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- RIGHT ACCOUNT DETAILS -->
                <div class="col-lg-8">
                    <div class="card comman-shadow">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Account Details</h5>

                            <!-- Update Account Form -->
                            <form action="{{ route('registrar-profile.update') }}" method="POST" id="Update_Account" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                <!-- Row 1: Fullname -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Firstname</label>
                                        <input type="text" class="form-control" name="firstname"
                                            value="{{ old('firstname', Auth::user()->firstname) }}">
                                        @error('firstname')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Middlename</label>
                                        <input type="text" class="form-control" name="middlename"
                                            value="{{ old('middlename', Auth::user()->middlename) }}">
                                        @error('middlename')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Lastname</label>
                                        <input type="text" class="form-control" name="lastname"
                                            value="{{ old('lastname', Auth::user()->lastname) }}">
                                        @error('lastname')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Row 2: Email, Phone Number and Role -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', Auth::user()->email) }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number"
                                            value="{{ old('phone_number', Auth::user()->phone_number) }}">
                                        @error('phone_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->role) }}" readonly>
                                    </div>
                                </div>

                                <!-- Row 3: Profile Picture -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" accept="image/*" name="profile_picture">
                                        @error('profile_picture')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Row 4: Password -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="password">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" id="update_btn_submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
