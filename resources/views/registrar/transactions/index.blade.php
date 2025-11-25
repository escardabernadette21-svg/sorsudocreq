@extends('layouts.registrar')

@section('title', 'Manage Transaction History')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Transaction History</a></li>
                                <li class="breadcrumb-item active">All Transaction History</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Manage Transaction History</h3>
                                    </div>
                                    <div class="col-auto text-end">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#filterDownloadModal">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row table-responsive" id="all-transaction-history">
                                {{-- AJAX renders table here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal custom-modal fade" id="filterDownloadModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Reports</h5>
                </div>
                <div class="modal-body">
                    <form id="filterForm" method="GET">
                        <!-- Date Range Filter -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date From</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date To</label>
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>
                        </div>

                        <!-- Student Type Filter -->
                        <div class="mb-3">
                            <label for="filter_student_type" class="form-label">Student Type</label>
                            <select name="student_type" id="filter_student_type" class="form-select">
                                <option value="">All</option>
                                <option value="enrolled">Enrolled</option>
                                <option value="alumni">Alumni</option>
                            </select>
                        </div>

                        <!-- Year Level Filter -->
                        <div class="mb-3" id="filter_year_container">
                            <label for="filter_year" class="form-label">Year Level</label>
                            <select name="year" id="filter_year" class="form-select">
                                <option value="">All</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                            </select>
                        </div>

                        <!-- Batch Year  Filter -->
                        <div class="mb-3" id="filter_batch_year_container" style="display: none;">
                            <label for="filter_batch_year" class="form-label">Batch Year</label>
                            <input type="number" name="batch_year" id="filter_batch_year" class="form-control"
                                placeholder="Enter Year (e.g., 2024)" min="1900" max="{{ date('Y') }}">
                        </div>

                        <!-- Course Filter -->
                        <div class="mb-3">
                            <label for="filter_course" class="form-label">Course</label>
                            <select name="course" id="filter_course" class="form-select">
                                <option value="">All</option>
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


                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--
@section('script')
    <script type="text/javascript">
        // Toggle Year Level and Batch Year filters based on Student Type selection
        $('#filter_student_type').on('change', function() {
            var type = $(this).val();
            if (type === 'alumni') {
                $('#filter_batch_year_container').show();
                $('#filter_year_container').hide();
                $
            } else {
                $('#filter_year_container').show();
                $('#filter_batch_year_container').hide();
            }
        });

        // Disable To Date initially
        $('#to_date').prop('disabled', true);

        // Disable To Date until From Date is selected
        $('#from_date').on('change', function() {
            let fromDate = $(this).val();

            $('#to_date').val('').prop('disabled', false);
            $('#to_date').attr('min', fromDate);
        });

        // Validate To Date (must be >= From Date)
        $('#to_date').on('change', function() {
            let fromDate = $('#from_date').val();
            let toDate = $(this).val();

            if (fromDate && new Date(toDate) < new Date(fromDate)) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Range',
                    text: '"Date To" cannot be earlier than "Date From".'
                });

                $(this).val(''); // reset field
            }
        });

        // Load all transaction history on page load
        GetTransactionHistory();

        function GetTransactionHistory() {
            $.ajax({
                url: '{{ route('transactions.fetch') }}',
                method: 'GET',
                success: function(response) {
                    $('#all-transaction-history').html(response);

                    $("#transaction-history-table").DataTable({
                        order: [
                            [0, "asc"]
                        ],
                    });
                }
            });
        }

        $(document).on('submit', '#filterForm', function(e) {
            e.preventDefault();

            const student_type = $('#filter_student_type').val();
            const year = $('#filter_year').val();
            const batch_year = $('#filter_batch_year').val();
            const course = $('#filter_course').val();
            const from_date = $('#from_date').val();
            const to_date = $('#to_date').val();

            let query = [];

            if (student_type && student_type !== 'All')
                query.push(`student_type=${encodeURIComponent(student_type)}`);

            if (year && year !== 'All')
                query.push(`year=${encodeURIComponent(year)}`);

            if (batch_year && batch_year !== 'All')
                query.push(`batch_year=${encodeURIComponent(batch_year)}`);

            if (course && course !== 'All')
                query.push(`course=${encodeURIComponent(course)}`);

            if (from_date) query.push(`from_date=${encodeURIComponent(from_date)}`);
            if (to_date) query.push(`to_date=${encodeURIComponent(to_date)}`);

            let url = "{{ route('transactions.download') }}";
            if (query.length > 0) url += '?' + query.join('&');

            Swal.fire({
                title: 'Checking data...',
                text: 'Please wait.',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        $('#filterDownloadModal').modal('hide');
                        window.location.href = url;

                        $('#filterForm')[0].reset();
                        $('#to_date').prop('disabled', true); // re-disable To Date

                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Download Started',
                                text: 'Your PDF report is being downloaded.',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No results found',
                            text: response.message ||
                                'No transaction history found for the selected filters.',
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to check data. Please try again.',
                    });
                }
            });
        });
    </script>
@endsection --}}
@section('script')
    <script type="text/javascript">
        // Toggle Year Level and Batch Year filters based on Student Type selection
        $('#filter_student_type').on('change', function() {
            var type = $(this).val();

            if (type === 'alumni') {
                $('#filter_batch_year_container').show();
                $('#filter_year_container').hide();

                // FIX: Clear Year Level value when switching to Alumni
                $('#filter_year').val('');
            } else {
                $('#filter_year_container').show();
                $('#filter_batch_year_container').hide();

                // FIX: Clear Batch Year value when switching to Enrolled
                $('#filter_batch_year').val('');
            }
        });

        // Disable To Date initially
        $('#to_date').prop('disabled', true);

        // Disable To Date until From Date is selected
        $('#from_date').on('change', function() {
            let fromDate = $(this).val();

            $('#to_date').val('').prop('disabled', false);
            $('#to_date').attr('min', fromDate);
        });

        // Validate To Date (must be >= From Date)
        $('#to_date').on('change', function() {
            let fromDate = $('#from_date').val();
            let toDate = $(this).val();

            if (fromDate && new Date(toDate) < new Date(fromDate)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Range',
                    text: '"Date To" cannot be earlier than "Date From".'
                });

                $(this).val('');
            }
        });

        // Load all transaction history on page load
        GetTransactionHistory();

        function GetTransactionHistory() {
            $.ajax({
                url: '{{ route('transactions.fetch') }}',
                method: 'GET',
                success: function(response) {
                    $('#all-transaction-history').html(response);

                    $("#transaction-history-table").DataTable({
                        order: [
                            [0, "asc"]
                        ],
                    });
                }
            });
        }

        // Submit filter form
        $(document).on('submit', '#filterForm', function(e) {
            e.preventDefault();

            const student_type = $('#filter_student_type').val();
            const year = $('#filter_year').val();
            const batch_year = $('#filter_batch_year').val();
            const course = $('#filter_course').val();
            const from_date = $('#from_date').val();
            const to_date = $('#to_date').val();

            let query = [];

            // Student type
            if (student_type !== "") {
                query.push(`student_type=${encodeURIComponent(student_type)}`);
            }

            // FIX: Only apply Year Level if NOT alumni
            if (student_type !== "alumni" && year !== "") {
                query.push(`year=${encodeURIComponent(year)}`);
            }

            // FIX: Only apply Batch Year if alumni AND user typed a value
            if (student_type === "alumni" && batch_year !== "") {
                query.push(`batch_year=${encodeURIComponent(batch_year)}`);
            }

            // Course
            if (course !== "") {
                query.push(`course=${encodeURIComponent(course)}`);
            }

            // Dates
            if (from_date) query.push(`from_date=${encodeURIComponent(from_date)}`);
            if (to_date) query.push(`to_date=${encodeURIComponent(to_date)}`);

            let url = "{{ route('transactions.download') }}";
            if (query.length > 0) url += '?' + query.join('&');

            Swal.fire({
                title: 'Checking data...',
                text: 'Please wait.',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    Swal.close();
                    if (response.success) {
                        $('#filterDownloadModal').modal('hide');
                        window.location.href = url;

                        // Reset form and reset filter year and batch year visibility
                        $('#filterForm')[0].reset();
                        $('#to_date').prop('disabled', true);
                        $('#filter_year_container').show();
                        $('#filter_batch_year_container').hide();

                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Download Started',
                                text: 'Your PDF report is being downloaded.',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No results found',
                            text: response.message ||
                                'No transaction history found for the selected filters.',
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to check data. Please try again.',
                    });
                }
            });
        });
    </script>
@endsection