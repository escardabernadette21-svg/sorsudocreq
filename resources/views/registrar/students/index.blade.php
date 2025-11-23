@extends('layouts.registrar')
@section('title')
    User Management
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Students</a></li>
                                <li class="breadcrumb-item active">All Students</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Manage Student Account</h3>
                                    </div>
                                    <div class="col-auto text-start float-end ms-auto download-grp">
                                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#insert_users_modal">Create Student <i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="row table-row table-responsive" id="all_users">
                                {{-- Table of all user's will appear  or render here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Registered User --}}
    <div class="modal custom-modal fade" id="insert_users_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close_header_btn"></button>
                </div>
                <div class="modal-body mb-3">
                    <form action="{{ route('users.store') }}" method="POST" id="AddUsers" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center my-3">
                                    <img id="previewImage" src="{{ asset('registrar/assets/img/blank.png') }}"
                                        alt="Profile Preview" class="rounded-circle img-thumbnail"
                                        style="width: 120px; height: 120px; object-fit: cover;">
                                </div>


                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="student_id" class="form-label">Student ID <span
                                        class="login-danger">*</span></label>
                                <input type="text" class="form-control" name="student_id" placeholder="Student ID">
                                <span class="text-danger error-text student_id_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Student Type <span
                                        class="login-danger">*</span></label>
                                <select class="form-select" name="student_type" id="student_type" style="padding:10px">
                                    <option value="">Select Type</option>
                                    <option value="alumni">Alumni</option>
                                    <option value="enrolled">Enrolled</option>
                                </select>
                                <span class="text-danger error-text student_type_error"></span>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="firstname" class="form-label">Firstname <span class="login-danger">
                                        *</span></label>
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    placeholder="Firstname">
                                <span class="text-danger error-text firstname_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="middlename" class="form-label">Middlename <span class="login-danger">
                                        *</span></label>
                                <input type="text" class="form-control" name="middlename" placeholder="Middlename">
                                <span class="text-danger error-text middlename_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Lastname <span class="login-danger">
                                        *</span></label>
                                <input type="text" class="form-control" name="lastname" placeholder="Lastname">
                                <span class="text-danger error-text lastname_error"></span>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone Number<span class="login-danger">
                                        *</span></label>
                                <input type="tel" class="form-control" placeholder="Phone Number"
                                    name="phone_number">
                                <span class="text-danger error-text phone_number_error"></span>
                            </div>
                            <div class="col-md-4" id="year_container">
                                <label for="Year" class="form-label">Year Level<span class="login-danger">
                                        *</span></label>
                                <select class="form-select" name="year" style="padding:10px">
                                    <option value="">Select Year</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                                <span class="text-danger error-text year_error"></span>
                            </div>
                            <div class="col-md-4" id="batch_year_container" style="display: none;">
                                <label for="Batch Year" class="form-label">Batch Year<span class="login-danger">
                                        *</span></label>
                                <input type="number" name="batch_year" id="batch_year" class="form-control"
                                    placeholder="Enter Year (e.g., 2024)" min="1900" max="{{ date('Y') }}">
                                <span class="text-danger error-text batch_year_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label for="course" class="form-label">Course <span
                                        class="login-danger">*</span></label>
                                <select class="form-select" name="course" style="padding:10px">
                                    <option value="">Select Course</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSIS">BSIS</option>
                                    <option value="BSCS">BSCS</option>
                                    <option value="BPA">BPA</option>
                                    <option value="BSENTREP">BSENTREP</option>
                                    <option value="BTVTED">BTVTED</option>
                                    <option value="BSAIS">BSAIS</option>
                                    <option value="BSA">BSA</option>
                                </select>
                                <span class="text-danger error-text course_error"></span>
                            </div>


                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control image-upload" id="imageInput" accept="image/*"
                                    name="profile_picture">
                                <span class="text-danger error-text profile_picture_error"></span>
                            </div>
                            {{-- <div class="col-md-6">
                                <img id="previewImage" class="img-fluid mt-2" alt="Uploaded Image"
                                    style="display: none; width:130px; height: 130px;">
                            </div> --}}
                        </div>
                        <div class="row g-3 mt-3">

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span
                                        class="login-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password <span
                                        class="login-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                                    </span>
                                </div>
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>


                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="close_btn">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- View Registered User --}}
    <div class="modal custom-modal fade" id="ViewUser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Registered Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close_header_btn"></button>
                </div>
                <div class="modal-body mb-3">
                    <form enctype="multipart/form-data">
                        @csrf
                        <input type="text" class="mb-3" name="id" id="user_id" readonly hidden>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="justify-content-center image-container" id="view_student_picture">
                                    {{-- Student Picture Appears Here --}}
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="student_id" class="form-label">Student ID <span
                                        class="login-danger">*</span></label>
                                <input type="text" class="form-control" name="student_id" id="view_student_id"
                                    placeholder="Student ID" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="student_type" class="form-label">Student Type <span
                                        class="login-danger">*</span></label>
                                <select class="form-select" name="student_type" id="view_student_type"
                                    style="padding:10px" disabled>
                                    <option value="">Select Type</option>
                                    <option value="alumni">Alumni</option>
                                    <option value="enrolled">Enrolled</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="firstname" class="form-label">Firstname <span
                                        class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="view_firstname" name="firstname"
                                    placeholder="Firstname" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="middlename" class="form-label">Middlename <span
                                        class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="view_middlename" name="middlename"
                                    placeholder="Middlename" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="lastname" class="form-label">Lastname <span
                                        class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="view_lastname" name="lastname"
                                    placeholder="Lastname" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone Number<span
                                        class="login-danger">*</span></label>
                                <input type="tel" class="form-control" placeholder="Phone Number"
                                    id="view_phone_number" name="phone_number" readonly>
                            </div>

                            {{-- Year Level --}}
                            <div class="col-md-4" id="view_year_container">
                                <label for="Year" class="form-label">Year Level<span
                                        class="login-danger">*</span></label>
                                <select class="form-select" name="year" id="view_year" style="padding:10px" disabled>
                                    <option value="">Select Year</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>

                            {{-- Year Graduated (hidden by default) --}}
                            <div class="col-md-4" id="view_batch_year_container" style="display: none;">
                                <label for="batch_year" class="form-label">Year Graduated<span
                                        class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="view_batch_year" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="course" class="form-label">Course <span
                                        class="login-danger">*</span></label>
                                <select class="form-select" name="course" id="view_course" style="padding:10px"
                                    disabled>
                                    <option value="">Select Course</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSIS">BSIS</option>
                                    <option value="BSCS">BSCS</option>
                                    <option value="BPA">BPA</option>
                                    <option value="BSENTREP">BSENTREP</option>
                                    <option value="BTVTED">BTVTED</option>
                                    <option value="BSAIS">BSAIS</option>
                                    <option value="BSA">BSA</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email <span
                                        class="login-danger">*</span></label>
                                <input type="email" class="form-control" id="view_email" name="email"
                                    placeholder="Email" readonly>
                            </div>
                        </div>

                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="close_btn">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Update Registered User --}}
    <div class="modal custom-modal fade" id="EditUser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Registered Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="edit_close_header_btn"></button>
                </div>
                <div class="modal-body mb-3">
                    <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data"
                        id="UpdateUser">
                        @csrf
                        <input type="text" name="id" id="edit_user_id" readonly hidden>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="justify-content-center image-container" id="edit_student_picture">
                                    {{-- Student Picture Appear Here --}}
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Student ID <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" name="student_id" id="edit_student_id"
                                    placeholder="Student ID">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Student Type <span class="login-danger">*</span></label>
                                <select class="form-select" name="student_type" id="edit_student_type"
                                    style="padding:10px">
                                    <option value="">Select Type</option>
                                    <option value="alumni">Alumni</option>
                                    <option value="enrolled">Enrolled</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Firstname <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_firstname" name="firstname"
                                    placeholder="Firstname">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middlename <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_middlename" name="middlename"
                                    placeholder="Middlename">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lastname <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_lastname" name="lastname"
                                    placeholder="Lastname">
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Phone Number<span class="login-danger">*</span></label>
                                <input type="tel" class="form-control" placeholder="Phone Number"
                                    id="edit_phone_number" name="phone_number">
                            </div>

                            {{-- Year Level --}}
                            <div class="col-md-4" id="edit_year_container">
                                <label class="form-label">Year Level<span class="login-danger">*</span></label>
                                <select class="form-select" name="year" id="edit_year" style="padding:10px">
                                    <option value="">Select Year</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>

                            {{-- Year Graduated --}}
                            <div class="col-md-4" id="edit_batch_year_container" style="display: none;">
                                <label class="form-label">Batch Year<span class="login-danger">*</span></label>
                                <input type="number" name="batch_year" id="edit_batch_year" class="form-control"
                                    placeholder="Enter Year (e.g., 2024)" min="1900" max="{{ date('Y') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Course <span class="login-danger">*</span></label>
                                <select class="form-select" name="course" id="edit_course" style="padding:10px">
                                    <option value="">Select Course</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSIS">BSIS</option>
                                    <option value="BSCS">BSCS</option>
                                    <option value="BPA">BPA</option>
                                    <option value="BSENTREP">BSENTREP</option>
                                    <option value="BTVTED">BTVTED</option>
                                    <option value="BSAIS">BSAIS</option>
                                    <option value="BSA">BSA</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" class="form-control image-upload" accept="image/*"
                                    name="profile_picture">
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="login-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email"
                                    placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="edit_password" name="password"
                                        placeholder="New Password">
                                    <span class="input-group-text" id="edit_togglePassword" style="cursor: pointer;">
                                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@section('script')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener('load', function() {
                        previewImage.src = reader.result;
                        previewImage.style.display = 'block';
                    });

                    reader.readAsDataURL(file);
                } else {
                    // If no file is selected, display a text message
                    previewImage.src = ''; // Clear any existing image
                    previewImage.alt = 'No Image Choosen';
                    previewImage.style.display = 'block';
                }
            });


        });

        $(document).ready(function() {

            // Show/Hide Year and Year Graduated based on Student Type selection
            $('#student_type').on('change', function() {
                var type = $(this).val();

                if (type === 'alumni') {
                    // Show Batch Year, hide Year
                    $('#batch_year_container').show();
                    $('#year_container').hide();
                } else {
                    // Show Year, hide Batch Year
                    $('#year_container').show();
                    $('#batch_year_container').hide();
                }
            });

            // Clear image preview and file input when modal is closed
            $('#insert_users_modal').on('hidden.bs.modal', function() {
                const previewImage = document.getElementById('previewImage');
                const imageInput = document.getElementById('imageInput');
                // Clear the profile picture
                previewImage.src = '';
                previewImage.style.display = 'none';
                // Clear the file input
                imageInput.value = '';
            });

            AllUserRecord();

            function AllUserRecord() {
                $.ajax({
                    url: '{{ route('users.fetch') }}',
                    method: 'GET',
                    success: function(response) {
                        $("#all_users").html(response);
                        $("#all_users_table").DataTable({
                            "order": [
                                [0, "asc"]
                            ]
                        });
                    }
                });
            }

            $("#AddUsers").on('submit', function(e) {
                e.preventDefault();
                $("#btn_submit").html(
                    'Submitting <span class="fas fa-spinner fa-spin align-middle ms-2"></span>');
                $('#btn_submit').attr("disabled", true);
                var form = this;

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: "json",
                    contentType: false,
                    beforeSend: function() {

                        $(form).find('span.error-text').text('');

                    },
                    success: function(response) {

                        if (response.status == 422) {
                            $('#btn_submit').removeAttr("disabled");

                            $.each(response.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });

                            $("#btn_submit").text('Submit');

                        } else {

                            $(form)[0].reset();
                            $('#btn_submit').removeAttr("disabled");
                            $('#btn_submit').text('Submit');
                            AllUserRecord(); // refresh the table
                            $("#insert_users_modal").modal('hide');
                            previewImage.src = '';
                            previewImage.style.display = 'none';


                            Swal.fire({
                                icon: 'success',
                                title: 'User Registered Successfully',
                                showConfirmButton: false,
                                timer: 1700,
                                timerProgressBar: true,

                            })
                        }

                        // Event binding for close button inside modal
                        $('#close_btn').on('click', function() {
                            $("#AddUsers").find('span.text-danger').text('');
                            previewImage.src = '';
                            previewImage.style.display = 'none';
                        });

                        $('#close_header_btn').on('click', function() {
                            $("#AddUsers").find('span.text-danger').text('');
                            previewImage.src = '';
                            previewImage.style.display = 'none';
                        });

                    }
                });
            });

            // Handle Year vs Year Graduated in View modal
            $(document).on('click', '.view_user', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');

                $.ajax({
                    url: '{{ route('users.view') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#user_id").val(response.id);
                        $("#view_student_id").val(response.student_id);
                        $("#view_student_type").val(response.student_type);
                        $("#view_firstname").val(response.firstname);
                        $("#view_middlename").val(response.middlename);
                        $("#view_lastname").val(response.lastname);
                        $("#view_phone_number").val(response.phone_number);
                        $("#view_course").val(response.course);
                        $("#view_email").val(response.email);

                        // Profile picture
                        let imagePath = response.profile_picture ? "/storage/student/profile/" +
                            response.profile_picture :
                            "{{ asset('registrar/assets/img/blank.png') }}";
                        $("#view_student_picture").html(`
                <div class="d-flex justify-content-center my-3">
                    <img src="${imagePath}" alt="Student Picture" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                </div>
            `);

                        // Show/hide Year or Year Graduated
                        if (response.student_type === 'alumni') {
                            $("#view_year_container").hide();
                            $("#view_batch_year_container").show();
                            $("#view_batch_year").val(response.batch_year);
                        } else {
                            $("#view_year_container").show();
                            $("#view_batch_year_container").hide();
                            $("#view_year").val(response.year);
                        }
                    }
                });
            });


            $(document).on('click', '.edit_user', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');

                $.ajax({
                    url: '{{ route('users.view') }}',
                    method: 'GET',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Fill form fields
                        $("#edit_user_id").val(response.id);
                        $("#edit_student_id").val(response.student_id);
                        $("#edit_student_type").val(response.student_type);
                        $("#edit_firstname").val(response.firstname);
                        $("#edit_middlename").val(response.middlename);
                        $("#edit_lastname").val(response.lastname);
                        $("#edit_phone_number").val(response.phone_number);
                        $("#edit_course").val(response.course);
                        $("#edit_email").val(response.email);

                        // Profile picture
                        let imagePath = response.profile_picture ?
                            "/storage/student/profile/" + response.profile_picture :
                            "{{ asset('registrar/assets/img/blank.png') }}";
                        $("#edit_student_picture").html(`
                <div class="d-flex justify-content-center my-3">
                    <img src="${imagePath}" alt="Student Picture" class="rounded-circle img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                </div>
            `);

                        // Show/hide Year vs Batch Year
                        if (response.student_type === 'alumni') {
                            $("#edit_year_container").hide();
                            $("#edit_batch_year_container").show();
                            $("#edit_batch_year").val(response.batch_year);
                        } else {
                            $("#edit_year_container").show();
                            $("#edit_batch_year_container").hide();
                            $("#edit_year").val(response.year);
                        }

                        // Show modal
                        $("#EditUser").modal('show');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Handle student_type change in Edit modal
            $('#edit_student_type').on('change', function() {
                let type = $(this).val();
                if (type === 'alumni') {
                    $("#edit_year_container").hide();
                    $("#edit_batch_year_container").show();
                } else {
                    $("#edit_year_container").show();
                    $("#edit_batch_year_container").hide();
                }
            });






            $("#UpdateUser").on('submit', function(e) {
                e.preventDefault();
                $("#edit_btn_submit").html(
                    'Updating <span class="fas fa-spinner fa-spin align-middle ms-2"></span>');
                $('#edit_btn_submit').attr("disabled", true);
                var form = this;

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: "json",
                    contentType: false,
                    beforeSend: function() {

                        $(form).find('span.error-text').text('');

                    },
                    success: function(response) {

                        if (response.status == 422) {
                            $('#edit_btn_submit').removeAttr("disabled");

                            $.each(response.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });

                            $("#edit_btn_submit").text('Submit');

                        } else {

                            $(form)[0].reset();
                            $('#edit_btn_submit').removeAttr("disabled");
                            $('#edit_btn_submit').text('Update');
                            AllUserRecord();
                            $("#EditUser").modal('hide'); //hide the modal

                            // SWEETALERT
                            Swal.fire({
                                icon: 'success',
                                title: 'User updated successfully',
                                showConfirmButton: true,
                                timer: 1700,

                            })
                        }

                        // Event binding for close button inside modal
                        $('#edit_close_btn').on('click', function() {
                            $("#UpdateUser").find('span.text-danger').text('');
                        });

                        $('#edit_close_header_btn').on('click', function() {
                            $("#UpdateUser").find('span.text-danger').text('');
                        });

                    }
                });
            });


            $(document).on('click', '.DeleteUser', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('users.delete') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                console.log(response);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted Successfully.',
                                    showConfirmButton: true,
                                    timer: 1700,

                                })
                                AllUserRecord();
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
@endsection
