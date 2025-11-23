@extends('layouts.registrar')
@section('title')
     Manage Document Payment
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Document Payment</a></li>
                                <li class="breadcrumb-item active">All Document Payment </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow"  >
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Manage Document Payment</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="row table-row table-responsive" id="all_document_payment">
                                {{-- Table of all document request will appear  or render here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for receipt preview -->
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

    {{-- Update Document Status --}}
     <div class="modal custom-modal fade" id="PaymentStatusModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xxl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="update_close_header_btn"></button>
                </div>
                <div class="modal-body mb-3">
                    <form action="{{ route('payment.update-status') }}" method="POST" enctype="multipart/form-data" id="UpdatePaymentStatusForm">
                        @csrf
                        <input type="text" class="mb-3" name="id" id="id" readonly hidden>
                        <input type="text" class="mb-3" name="user_id" id="user_id"  readonly hidden>
                        <div class="row g-3">
                             <div class="col-md-12">
                                <label for="" class="form-label">Payment Status <span class="login-danger">*</span></label>
                                <select class="form-select" name="status" id="view_payment_status"  style="padding:10px">
                                    <option value="">Select Payment Status</option>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Pending Review">Pending Review</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
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




@section('script')

    <script type="text/javascript">
         $(document).on('click', '.receipt-thumbnail', function() {
            var imgSrc = $(this).data('img');
            $('#receiptModalImage').attr('src', imgSrc);
        });

        GetPaymentRecord();
        function GetPaymentRecord() {
            $.ajax({
                url: '{{ route('payment.fetch') }}',
                method: 'GET',
                success: function(response) {
                    $("#all_document_payment").html(response);
                    $("#all_document_payment_table").DataTable({
                        "order": [
                            [0, "asc"]
                        ]
                    });
                }
            });
        }


        $(document).on('click', '.payment_status', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('payment.status') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },

                success: function(response) {
                    $('#user_id').val(response.user_id);
                    $("#id").val(response.id);
                    $("#view_payment_status").val(response.status);
                }
            });
        });

        $("#UpdatePaymentStatusForm").on('submit', function(e) {
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
                            GetPaymentRecord();
                            $("#PaymentStatusModal").modal('hide'); //hide the modal

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
                            $("#UpdatePaymentStatusForm").find('span.text-danger').text('');
                        });

                        $('#update_close_header_btn').on('click', function() {
                            $("#UpdatePaymentStatusForm").find('span.text-danger').text('');
                        });

                    }
                });
            })
    </script>
@endsection
@endsection
