@extends('layouts.registrar')
@section('title')
    Manage Requested Document
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Document Request</a></li>
                                <li class="breadcrumb-item active">All Document Request</li>
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
                                        <h3 class="page-title">Manage Document Request</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="row table-row table-responsive" id="all_document_request">
                                {{-- Table of all document request will appear  or render here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- View Request Document --}}
    <div class="modal custom-modal fade" id="ViewRequestedDocument" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">View Requested Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close_header_btn"></button>
                </div>

                <div class="modal-body mb-3">
                    <form enctype="multipart/form-data">
                        @csrf

                        <input type="text" class="mb-3" name="id" id="id" readonly hidden>

                        <div class="row">
                            <table class="table-bordered" style="border:2px solid #7E0001 !important;">
                                <thead class="text-center">
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody id="requested_documents_table" class="text-center">
                                    <!-- Dynamic rows go here -->
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">TOTAL AMOUNT:</td>
                                        <td id="total_amount" class="fw-bold text-center">₱0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- MESSAGE BELOW THE TABLE -->
                        <div class="mt-3">
                            <label for="request_message" class="form-label fw-bold">Message:</label>
                            <p id="request_message" class="text-muted fst-italic"></p>
                        </div>
                        <!-- END MESSAGE -->

                        {{-- <div class="mt-4 float-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_btn">
                            Close
                        </button>
                    </div> --}}

                    </form>
                </div>

            </div>
        </div>
    </div>


    {{-- Update Document Status --}}
    <div class="modal custom-modal fade" id="UpdateStatusModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xxl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="update_close_header_btn"></button>
                </div>
                <div class="modal-body mb-3">
                    <form action="{{ route('request.update-status') }}" method="POST" enctype="multipart/form-data"
                        id="UpdateStatusForm">
                        @csrf
                        <input type="text" class="mb-3" name="id" id="document_status_id" readonly hidden>
                        <input type="text" class="mb-3" name="user_id" id="user_id" readonly hidden>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="view_document_status" class="form-label">Document Status <span
                                        class="login-danger">*</span></label>
                                <select class="form-select" name="status" id="view_document_status" style="padding:10px">
                                    <option value="">Select Document Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Receipt Uploaded">Receipt Uploaded</option>
                                    <option value="Under Verification">Under Verification</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Ready for Pick-up">Ready for Pick-up</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                        {{-- <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="receipt" class="form-label">Claimed Date</label>
                                <input type="date" class="form-control" name="claimed_date" id="view_claimed_date" placeholder="Claimed Date">
                                <span class="text-danger error-text claimed_date_error"></span>
                            </div>
                        </div> --}}
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea type="text" class="form-control" id="reamrks" name="remarks" placeholder="Type here . . ."
                                    cols="30" rows="10"></textarea>
                                <span class="text-danger error-text remarks_error"></span>
                            </div>
                        </div>
                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="update_close_btn">Close</button>
                            <button type="submit" class="btn btn-primary" id="update_btn_submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for viewing receipt --}}
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Receipt Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="receiptModalImage" src="" class="img-fluid rounded" alt="Receipt Preview">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for viewing remarks --}}
    <div class="modal fade" id="remarksModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background:#7E0001; color:white;">
                    <h5 class="modal-title text-white">Remarks</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="remarksText" style="white-space:pre-wrap; font-size:1rem;"></p>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script type="text/javascript">
        // Event listener for thumbnail click to show receipt in modal
        $(document).on('click', '.receipt-thumbnail', function() {
            var imgSrc = $(this).data('img');
            $('#receiptModalImage').attr('src', imgSrc);
        });

        $(document).on("click", ".view-remarks", function() {
            const text = $(this).data("remarks");
            $("#remarksText").text(text);
            $("#remarksModal").modal("show");
        });


        $(document).ready(function() {
            // Initialize DataTable for all document requests
            AllDocumentRequest();

            function AllDocumentRequest() {
                $.ajax({
                    url: '{{ route('request.fetch') }}',
                    method: 'GET',
                    success: function(response) {
                        $("#all_document_request").html(response);
                        $("#all_document_request_table").DataTable({
                            "order": [
                                [0, "asc"]
                            ]
                        });
                    }
                });
            }

            $(document).on('click', '.view_request_document', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');

                $.ajax({
                    url: '{{ route('request.view-document') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        let tableBody = '';
                        let grandTotal = 0;

                        response.forEach(function(item) {
                            let quantity = item.quantity;
                            let amount = parseFloat(item.price);
                            let total = quantity * amount;

                            grandTotal += total;

                            tableBody += `
                                <tr>
                                    <td>${quantity}x ${item.type}</td>
                                    <td>₱${amount.toFixed(2)}</td>
                                    <td>₱${total.toFixed(2)}</td>
                                </tr>
                            `;
                        });
                        $('#id').val(id);
                        $('#requested_documents_table').html(tableBody);
                        $('#total_amount').text(`₱${grandTotal.toFixed(2)}`);
                        $('#request_message').text(response[0].message ||
                            'No message provided.');
                    },

                    error: function(xhr) {
                        alert('Failed to load document items.');
                    }
                });
            });


            $(document).on('click', '.view_status', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('request.view-status') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        $('#user_id').val(response.user_id);
                        $("#document_status_id").val(response.id);
                        $("#view_document_status").val(response.status);
                        $("#view_claimed_date").val(response.claimed_date ? response
                            .claimed_date : '');
                        $("#reamrks").val(response.remarks ? response.remarks : '');
                    }
                });
            });

            $("#UpdateStatusForm").on('submit', function(e) {
                e.preventDefault();
                $("#update_btn_submit").html(
                    'Updating <span class="fas fa-spinner fa-spin align-middle ms-2"></span>');
                $('#update_btn_submit').attr("disabled", true);
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
                            $('#update_btn_submit').removeAttr("disabled");

                            $.each(response.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });

                            $("#update_btn_submit").text('Submit');

                        } else {

                            $(form)[0].reset();
                            $('#update_btn_submit').removeAttr("disabled");
                            $('#update_btn_submit').text('Update');
                            AllDocumentRequest();
                            $("#UpdateStatusModal").modal('hide'); //hide the modal

                            // SWEETALERT
                            Swal.fire({
                                icon: 'success',
                                title: 'Status updated successfully',
                                showConfirmButton: true,
                                timer: 1700,

                            })
                        }

                        // Event binding for close button inside modal
                        $('#update_close_btn').on('click', function() {
                            $("#UpdateStatusForm").find('span.text-danger').text('');
                        });

                        $('#update_close_header_btn').on('click', function() {
                            $("#UpdateStatusForm").find('span.text-danger').text('');
                        });

                    }
                });
            });




            $(document).on('click', '#close_btn', function() {
                $('#ViewRequestedDocument').modal('hide');
                $('#requested_documents_table').empty();
                $('#total_amount').text('₱0.00');
            });

            $(document).on('click', '#close_header_btn', function() {
                $('#ViewRequestedDocument').modal('hide');
                $('#requested_documents_table').empty();
                $('#total_amount').text('₱0.00');
            });

            $(document).on('click', '.DeleteRequestedDocument', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');

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
                            url: '{{ route('request.delete') }}',
                            method: 'DELETE',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your document request has been deleted.',
                                    'success'
                                );
                                AllDocumentRequest();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the document request.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
@endsection
