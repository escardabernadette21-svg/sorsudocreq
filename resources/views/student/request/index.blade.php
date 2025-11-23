@extends('layouts.student')

@section('title')
    Document Request
@endsection

@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl  py-5 py-lg-15">
        <div class="content flex-row-fluid" style="border:2px solid var(--bs-custom); border-radius:1%">
            <div class="card">
                <form action="{{ route('document.request.store') }}" method="POST" enctype="multipart/form-data"
                    id="CreateDocumentRequest">
                    @csrf
                    <div class="card-body p-9">
                        <h3 class="anchor fw-bolder mb-5">1. PERSONAL INFORMATION</h3>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="studentname"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"
                                    placeholder="Fullname" readonly />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Student ID <span class="text-danger">*</span></label>
                                <input type="text" name="student_id"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="{{ Auth::user()->student_id }}" placeholder="Student ID" readonly />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Student Type <span class="text-danger">*</span></label>
                                <input type="text" name="student_type"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="{{ Auth::user()->student_type }}" placeholder="Student Type" readonly />
                            </div>
                        </div>

                        <div class="row mb-3">
                            @if (Auth::user()->student_type === 'enrolled')
                                <div class="col-md-6">
                                    <label class="form-label">Year <span class="text-danger">*</span></label>
                                    <input type="text" name="year"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        value="{{ Auth::user()->year }}" placeholder="Year" readonly />
                                </div>
                            @elseif(Auth::user()->student_type === 'alumni')
                                <div class="col-md-6">
                                    <label class="form-label">Batch Year <span class="text-danger">*</span></label>
                                    <input type="text" name="batch_year"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        value="{{ Auth::user()->batch_year }}" placeholder="Batch Year" readonly />
                                </div>
                            @endif

                            <div class="col-md-6">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <input type="text" name="course"
                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                    value="{{ Auth::user()->course }}" placeholder="Course" readonly />
                            </div>
                        </div>



                        <h3 class="anchor mb-5">2. SELECT THE DOCUMENT YOU NEED</h3>
                        <div class="row mb-5">
                            <!-- Left Column: Certification / Other Services -->
                            <div class="col-lg-6">
                                <!-- Certifications Group -->
                                <div class="mb-4">
                                    <label class="fw-bold mb-2">Certification (₱25.00 each)</label>

                                    <div class="row g-2">
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox" id="cert_grades"
                                                name="certifications[]" value="Grades">
                                            <label class="form-check-label w-100" for="cert_grades">Grades</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Grades]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>

                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_graduation" name="certifications[]" value="Graduation">
                                            <label class="form-check-label w-100" for="cert_graduation">Graduation</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Graduation]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_goodmoral" name="certifications[]" value="GoodMoral">
                                            <label class="form-check-label w-100" for="cert_goodmoral">Good Moral</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[GoodMoral]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_enrollment" name="certifications[]" value="Enrollment">
                                            <label class="form-check-label w-100" for="cert_enrollment">Enrollment</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Enrollment]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_gwa" name="certifications[]" value="GWA">
                                            <label class="form-check-label w-100" for="cert_gwa">GWA</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[GWA]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_honors_awarded" name="certifications[]" value="Honors Awarded">
                                            <label class="form-check-label w-100" for="cert_honors_awarded">Honors
                                                Awarded</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Honors Awarded]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_medium_of_instruction" name="certifications[]"
                                                value="Medium of Instruction">
                                            <label class="form-check-label w-100" for="cert_medium_of_instruction">Medium
                                                of Instruction</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Medium of Instruction]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_units_earned" name="certifications[]" value="Units Earned">
                                            <label class="form-check-label w-100" for="cert_units_earned">Units
                                                Earned</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Units Earned]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_subject_enrolled" name="certifications[]"
                                                value="Subject Enrolled">
                                            <label class="form-check-label w-100" for="cert_subject_enrolled">Subject
                                                Enrolled</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Subject Enrolled]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_subject_description" name="certifications[]"
                                                value="Subject Description">
                                            <label class="form-check-label w-100" for="cert_subject_description">Subject
                                                Description</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Subject Description]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="cert_others" name="certifications[]" value="Others">
                                            <label class="form-check-label me-2" for="cert_others">Others:</label>
                                            <input type="text" name="cert_others_text"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="cert_qty[Others]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Services -->
                                <div class="mb-4">


                                    <div class="row g-2 mb-2">
                                        <label class="fw-bold mb-2">Other Services</label>
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="authentication" name="other_services[]" value="Authentication">
                                            <label class="form-check-label w-100" for="authentication">Authentication
                                                (₱5.00 per
                                                page)</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="other_services_qty[Authentication]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Total Pages">
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="evaluation"
                                                name="other_services[]" value="Evaluation">
                                            <label class="form-check-label" for="evaluation">Evaluation (₱15.00)</label>
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="documentarystamp" name="other_services[]" value="Documentary Stamp">
                                            <label class="form-check-label w-100" for="documentarystamp">Documentary Stamp
                                                (₱30.00 per
                                                pcs)</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="other_services_qty[Documentary Stamp]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Total Pcs">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Academic Form & Purpose -->
                            <div class="col-lg-6">
                                <!-- Academic Form -->
                                <!-- Credentials -->
                                <div class="mb-4">
                                    <label class="fw-bold d-block mb-2">Credentials</label>

                                    <div class="row g-2">

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="Transcript of Records">
                                            <label class="form-check-label" for="tor">Transcript of Records<br>
                                                (TOR ₱50.00 / Page & Required 2pcs 2x2 Pictures)</label>
                                        </div>
                                        <div class="col-4">
                                            <input type="number" name="credentials_qty[Transcript of Records]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div>

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="Honorable Dismissal">
                                            <label class="form-check-label">Honorable Dismissal (₱25.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="credentials_qty[Honorable Dismissal]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="Reconstructed Diploma">
                                            <label class="form-check-label">Reconstructed Diploma (₱100.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="credentials_qty[Reconstructed Diploma]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="Form 137-A">
                                            <label class="form-check-label">Form 137-A (₱50.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="credentials_qty[Form 137-A]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="Certificate of Registration">
                                            <label class="form-check-label">Certificate of Registration (₱25.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="credentials_qty[Certificate of Registration]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="CAV">
                                            <label class="form-check-label">CAV (₱80.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="credentials_qty[CAV]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="Correction of Data">
                                            <label class="form-check-label">Correction of Data (₱60.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="credentials_qty[Correction of Data]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                name="credentials[]" value="ID">
                                            <label class="form-check-label">ID (₱150.00)</label>
                                        </div>




                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="fw-bold d-block mb-2">Academic Form</label>
                                    <div class="row g-2">
                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="acad_shifting" name="academic_forms[]" value="Shifting Form">
                                            <label class="form-check-label" for="acad_shifting">Shifting Form
                                                (₱100.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="academic_qty[Shifting Form]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="acad_dropping" name="academic_forms[]"
                                                value="Dropping/Adding/Changing">
                                            <label class="form-check-label" for="acad_dropping">Dropping/Adding/Changing
                                                (₱50.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="academic_qty[Dropping/Adding/Changing]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}

                                        <div class="col-8 d-flex align-items-center">
                                            <input class="form-check-input me-2 cert-check" type="checkbox"
                                                id="acad_completion" name="academic_forms[]" value="Completion/Removal">
                                            <label class="form-check-label" for="acad_completion">Completion/Removal
                                                (₱50.00)</label>
                                        </div>
                                        {{-- <div class="col-4">
                                            <input type="number" name="academic_qty[Completion/Removal]"
                                                class="form-control form-control-sm qty-input d-none" min="1"
                                                placeholder="Qty">
                                        </div> --}}
                                    </div>
                                </div>

                                {{-- <!-- Purpose & Message -->
                                <div class="mb-3">
                                    <label for="purpose" class="form-label fw-bold">Purpose</label>
                                    <select class="form-select" id="purpose" name="purpose">
                                        <option value="">-- Select Purpose --</option>
                                        <option value="Employment">Employment</option>
                                        <option value="Scholarship">Scholarship</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div> --}}
                                <!-- Dropdown -->
                                <div class="mb-3">
                                    <label for="purpose" class="form-label fw-bold">Purpose</label>
                                    <select class="form-select" id="purpose" name="purpose"
                                        onchange="togglePurpose()">
                                        <option value="">-- Select Purpose --</option>
                                        <option value="Employment">Employment</option>
                                        <option value="Scholarship">Scholarship</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>

                                <!-- Collapsible text input -->
                                <div class="collapse mb-3" id="otherPurposeCollapse">
                                    <label for="other_purpose" class="form-label fw-bold">Please specify</label>
                                    <input type="text" class="form-control" name="other_purpose" id="other_purpose"
                                        placeholder="Enter your purpose">
                                </div>



                                <div class="mb-3">
                                    <label for="message" class="form-label fw-bold">Additional Message (Optional)</label>
                                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                </div>

                                <!-- Total and Buttons -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div><strong>Total:</strong> ₱<span id="total-amount">0.00</span></div>
                                    <div>
                                        <button type="submit" class="btn text-white" id="btn_submit"
                                            style="background-color: #8F0C00;">Generate Payment Order Slip</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script type="text/javascript">

             // Function to toggle the visibility of the other purpose input
        function togglePurpose() {
            const val = document.getElementById('purpose').value;
            const collapse = new bootstrap.Collapse(document.getElementById('otherPurposeCollapse'), {
                toggle: false
            });
            if (val === 'Others') {
                collapse.show();
            } else {
                collapse.hide();
                document.getElementById('other_purpose').value = '';
            }
        }

        // Initialize the total amount calculation
        const prices = {
            // Certifications
            'Grades': 25,
            'Graduation': 25,
            'GoodMoral': 25,
            'Enrollment': 25,
            'GWA': 25,
            'Honors Awarded': 25,
            'Medium of Instruction': 25,
            'Units Earned': 25,
            'Subject Enrolled': 25,
            'Subject Description': 25,
            'Others': 25,

            // Academic Forms
            'Shifting Form': 100,
            'Dropping/Adding/Changing': 50,
            'Completion/Removal': 50,

            // Other Services
            'Authentication': 5,
            'Evaluation': 15,
            'Documentary Stamp': 30,

            // Credential's Fee
            'Transcript of Records': 50,
            'Honorable Dismissal': 25,
            'Reconstructed Diploma': 100,
            'Form 137-A': 50,
            'Certificate of Registration': 25,
            'CAV': 80,
            'Correction of Data': 60,
            'ID': 150,
        };


        // Function to calculate total amount
        function calculateTotal() {
            let total = 0;

            // Check all selected checkboxes
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                const value = checkbox.value;
                const qtyInput = document.querySelector(`input[name*="qty"][name*="${value}"]`);

                let qty = 1;
                if (qtyInput && !qtyInput.classList.contains('d-none')) {
                    qty = parseInt(qtyInput.value) || 1; // fallback to 1 if empty
                }

                const price = prices[value] ?? 0;
                total += price * qty;
            });

            document.getElementById('total-amount').textContent = total.toFixed(2);
        }

        // Show input and default qty = 1 on check
        document.querySelectorAll('.cert-check').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const qtyInput = document.querySelector(`input[name*="qty"][name*="${this.value}"]`);
                if (qtyInput) {
                    if (this.checked) {
                        qtyInput.classList.remove('d-none');
                        qtyInput.required = true;
                        if (!qtyInput.value) {
                            qtyInput.value = 1;
                        }
                    } else {
                        qtyInput.classList.add('d-none');
                        qtyInput.required = false;
                        qtyInput.value = '';
                    }
                }
                calculateTotal();
            });
        });

        // Recalculate when qty changes
        document.querySelectorAll('.qty-input').forEach(function(input) {
            input.addEventListener('input', calculateTotal);
        });

        // Other services total
        document.querySelectorAll('input[name="other_services[]"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Initial total on load
        window.addEventListener('load', calculateTotal);



            function resetDocumentRequestForm(form) {
                // Reset form fields
                form.reset();

                // Hide all qty fields and clear values
                document.querySelectorAll('.qty-input').forEach(function(input) {
                    input.classList.add('d-none');
                    input.required = false;
                    input.value = '';
                });

                // Reset total
                document.getElementById('total-amount').textContent = '0.00';
            }

            $(document).ready(function() {
                $("#CreateDocumentRequest").on('submit', function(e) {
                    e.preventDefault();

                    $("#btn_submit").html(
                        'Generating <span class="fas fa-spinner fa-spin align-middle ms-2"></span>');
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
                            $('#btn_submit').removeAttr("disabled");
                            $("#btn_submit").text('Generate Payment Order Slip');

                            if (response.status === 422) {
                                let errorMessages = [];

                                // Collect all error messages
                                $.each(response.error, function(prefix, val) {
                                    errorMessages.push(val[0]);
                                });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: errorMessages.join('<br>'),
                                    confirmButtonColor: '#d33'
                                });

                            } else {
                                // Reset form and hide quantity fields
                                resetDocumentRequestForm(form);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Order Slip Generated Successfully',
                                    text: response.message,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'View Payment Slip'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Redirect to the payment slip page
                                        window.location.href =
                                            `/document/request/slip/${response.ref_no}`;
                                    }
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
