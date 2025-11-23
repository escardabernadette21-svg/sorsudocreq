@extends('layouts.student')
@section('title', 'Sign Up')
@section('content')
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed auth-page-bg">
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <div class="w-lg-800px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">

                <form class="form w-100" action="{{ route('register') }}" method="POST" enctype="multipart/form-data"
                    id="RegisterStudentAccount">
                    @csrf
                    <h1 class="text-dark mb-10 text-center">Create an Account</h1>

                    <div class="row">
                        <!-- Profile Picture -->
                        <div class="col-md-12 mb-5">
                            <label class="form-label fw-bold">Profile Picture <span class="text-danger">*</span></label>
                            <input type="file" name="profile_picture"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text profile_picture_error"></span>
                        </div>

                        <!-- Student ID -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                            <input type="text" name="student_id" placeholder="Student ID"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text student_id_error"></span>
                        </div>

                        <!-- Student Type -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Student Type <span class="text-danger">*</span></label>
                            <select name="student_type" id="student_type"
                                class="form-select form-control form-control-lg form-control-solid">
                                <option value="" selected disabled>Student Type</option>
                                <option value="enrolled">Enrolled</option>
                                <option value="alumni">Alumni</option>
                                {{-- <option value="graduate">Graduate</option> --}}
                            </select>
                            <span class="text-danger error-text student_type_error"></span>
                        </div>


                        <!-- Firstname -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" placeholder="Firstname"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text firstname_error"></span>
                        </div>

                        <!-- Middlename -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Middle Name</label>
                            <input type="text" name="middlename" placeholder="Middlename"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text middlename_error"></span>
                        </div>

                        <!-- Lastname -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" placeholder="Lastname"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text lastname_error"></span>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone_number" placeholder="Phone"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text phone_number_error"></span>
                        </div>

                        <!-- Year (for Enrolled/Alumni) -->
                        <div class="col-md-6 mb-5" id="year_container">
                            <label class="form-label fw-bold">Year <span class="text-danger">*</span></label>
                            <select name="year" class="form-select form-control form-control-lg form-control-solid">
                                <option value="">Select Year</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                            <span class="text-danger error-text year_error"></span>
                        </div>
                        <!-- Year Batch (for Graduate) -->
                        {{-- <div class="col-md-6 mb-5" id="year_graduated_container" style="display: none;">
                            <label class="form-label fw-bold">Year Graduated <span class="text-danger">*</span></label>
                            <input type="number" name="year_graduated" id="year_graduated"
                            class="form-control form-control-lg form-control-solid"
                            placeholder="Enter Year (e.g., 2024)" min="1900" max="{{ date('Y') }}">

                            <span class="text-danger error-text year_graduated_error"></span>
                        </div> --}}
                        <!-- Batch Year (for Alumni) -->
                        <div class="col-md-6 mb-5" id="batch_year_container" style="display: none;">
                            <label class="form-label fw-bold">Batch Year <span class="text-danger">*</span></label>
                            <input type="number" name="batch_year" id="batch_year"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Enter Batch Year (e.g., 2024)" min="1900" max="{{ date('Y') }}">
                            <span class="text-danger error-text batch_year_error"></span>
                        </div>




                        <!-- Course -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Course <span class="text-danger">*</span></label>
                            <select class="form-select form-control form-control-lg form-control-solid" name="course"
                                style="padding:10px">
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

                        <!-- Email -->
                        <div class="col-md-12 mb-5">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" placeholder="Email"
                                class="form-control form-control-lg form-control-solid">
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" name="password" placeholder="Password"
                                    class="form-control form-control-lg form-control-solid">
                                <i class="toggle-password fas fa-eye" id="toggleConfirmPassword"
                                    style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                            </div>
                            <span class="text-danger error-text password_error"></span>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" id="confirmPassword"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Confirm New Password" />
                                <i class="toggle-password fas fa-eye" id="toggleConfirmPassword"
                                    style="cursor: pointer; position: absolute; right: 20px; top: 15px;"></i>
                            </div>
                            <span class="text-danger error-text password_confirmation_error"></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg w-100 mb-5" id="btn_submit"
                            style="background-color: var(--bs-custom); color: var(--bs-white);">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Show/Hide Year field based on Student Type
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


            // Bind the form submission to AJAX
            $("#RegisterStudentAccount").on('submit', function(e) {
                e.preventDefault();
                $("#btn_submit").html(
                    'Submitting <span class="spinner-border spinner-border-sm align-middle ms-2"></span>'
                    );
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
                            $.each(response.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                            $("#btn_submit").html('Submit');
                            $('#btn_submit').removeAttr("disabled");
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: response.msg,
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = response
                                    .redirect; // Redirect after confirmation
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        // Handle server errors
                        console.log(xhr.responseText);
                        $("#btn_submit").html('Submit');
                        $('#btn_submit').removeAttr("disabled");
                    }
                });
            });
        });
    </script>


@endsection
