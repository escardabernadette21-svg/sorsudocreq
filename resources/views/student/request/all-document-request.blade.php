@extends('layouts.student')

@section('title')
    All Document Requests
@endsection

@section('content')
    <div class="toolbar py-2 py-lg-15" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column">
                <h1 class="d-flex text-white fw-bolder fs-2qx my-1 me-5">
                    Manage All Document Requests
                </h1>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl  py-5 py-lg-10">
        <div class="content flex-row-fluid" style="border:2px solid var(--bs-custom); border-radius:1%">
            <div class="card">
                <div class="card-body p-lg-17">
                    <div class="table-responsive" id="all_document_request">
                        {{-- Table Appear Here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for viewing receipt --}}
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg m">
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

    {{-- View Request Document Item--}}
    {{-- <div class="modal custom-modal fade" id="view_document_item_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
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
                            <table class="table-bordered" style="border:2px solid #7E0001 !important; ">
                                <thead class="text-center">
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="requested_documents_item_table" class="text-center">
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
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal custom-modal fade" id="view_document_item_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog">
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
                            <tbody id="requested_documents_item_table" class="text-center">
                                <!-- Dynamic rows go here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">TOTAL AMOUNT:</td>
                                    <td id="total_amount" class="fw-bold text-center">₱0.00</td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="mt-3">
                            <label for="request_message" class="form-label fw-bold">Message:</label>
                            <p id="request_message" class="text-muted fst-italic">
                                <!-- Dynamic message goes here -->
                            </p>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


    {{-- Modal for uploading receipt --}}
    <div class="modal fade" id="UploadReceipt" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-y pt-0 pb-15">
                    <div class="mb-13">
                        <h1 class="text-center mb-5">Upload Payment Receipt</h1>
                        <form action="{{ route('document.request.payment') }}" method="POST" enctype="multipart/form-data"
                            id="UploadPayment">
                            @csrf
                            <input type="hidden" name="document_request_id" id="document_request_id">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="" class="form-label">Reference Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="ref_no"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        id="ref_no"  placeholder="Reference Number" readonly />
                                    <span class="text-danger error-text ref_no_error"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="studentname" class="form-label">Student Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="studentname"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        id="studentname" placeholder="Student Name" readonly />
                                    <span class="text-danger error-text studentname_error"></span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="amount to pay" class="form-label"> Amount to pay <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="amount"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        id="amount" placeholder="Amount to pay" readonly />
                                    <span class="text-danger error-text amount_error"></span>
                                </div>
                            </div>
                            <!-- Payment Details -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Payment Details</label>
                                    <div class="p-3 border rounded bg-light">
                                        <p class="mb-1"><strong>GCash Number:</strong> 09XX-XXX-XXXX</p>
                                        <p class="mb-1"><strong>Bank Account Number:</strong> 1234-5678-9012</p>
                                        <p class="mb-0"><strong>Bank Name:</strong> BDO (Juan Dela Cruz)</p>
                                    </div>
                                    <small class="text-muted">Please pay using the details above before uploading your
                                        receipt.</small>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="fv-row mb-8">
                                    <div class="dropzone dz-clickable" id="receiptDropzone">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3hx text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="ms-4">
                                                <h3 class="dfs-3 fw-bold text-gray-900 mb-1">Drop your receipt here or
                                                    click to upload.</h3>
                                                <span class="fw-semibold fs-4 text-muted">Upload Pictures Here</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger mt-1 error-text receipt_error"></span>
                                </div>
                            </div>
                            <div class="mt-4 float-end">
                                <button type="button" class="btn btn-sm" data-bs-dismiss="modal" id="close_btn"
                                    style="background-color: var(--bs-white); border: 1px solid var(--bs-custom); color: var(--bs-custom);">Close</button>
                                <button type="submit" class="btn btn-sm text-white" id="btn_submit"
                                    style="background-color: #8F0C00;">Submit</button>
                            </div>
                        </form>
                    </div>
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
    @push('script')
        <script type="text/javascript">

            // Event listener for viewing remarks
            $(document).on("click", ".view-remarks", function () {
                    const text = $(this).data("remarks");
                    $("#remarksText").text(text);
                    $("#remarksModal").modal("show");
            });

            // Event listener for thumbnail click to show receipt in modal
            $(document).on('click', '.receipt-thumbnail', function() {
                var imgSrc = $(this).data('img');
                $('#receiptModalImage').attr('src', imgSrc);
            });

            $(document).ready(function() {

                AllDocumentRecords();

                function AllDocumentRecords() {

                    $.ajax({
                        url: '{{ route('document.request.record') }}',
                        method: 'GET',
                        success: function(response) {
                            $("#all_document_request").html(response);
                            $("#all_document_request_table").DataTable({
                                "order": [
                                    [0, "asc"]
                                ],
                                "language": {
                                    "lengthMenu": "Show _MENU_",
                                    "search": "",
                                    "searchPlaceholder": "Search..."
                                },
                                "dom": "<'row mb-2'" +
                                    "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                                    "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                                    ">" +

                                    "<'table-responsive'tr>" +

                                    "<'row'" +
                                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                                    ">"
                            });
                        }
                    });
                }

                $(document).on('click', '.CancelDocumentRequest', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    let csrf = '{{ csrf_token() }}';
                    Swal.fire({
                        title: 'Are you sure you want to cancel this request?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('document.request.cancel') }}',
                                method: 'POST',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    console.log(response);
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Document Request Successfully.',
                                        showConfirmButton: true,
                                        timer: 1700,

                                    })
                                    AllDocumentRecords();
                                }
                            });
                        }
                    })
                });

                $(document).on('click', '.view_document_item', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');

                    $.ajax({
                        url: '{{ route('document.request.view-item') }}',
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
                            $('#requested_documents_item_table').html(tableBody);
                            $('#total_amount').text(`₱${grandTotal.toFixed(2)}`);
                            $('#request_message').text(response[0].message || 'No message provided.');
                        },

                        error: function(xhr) {
                            alert('Failed to load document items.');
                        }
                    });
                });

                $(document).on('click', '#close_header_btn', function() {
                    $('#view_document_item_modal').modal('hide');
                    $('#requested_documents_item_table').empty();
                    $('#total_amount').text('₱0.00');

                });

                $(document).on('click', '.UploadReceipt', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    $.ajax({
                        url: '{{ route('document.request.view-payment') }}',
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },

                        success: function(response) {

                            $("#document_request_id").val(response.id);
                            $("#ref_no").val(response.reference_number);
                            $("#studentname").val(response.studentname);
                            $("#amount").val(response.total_amount);

                        }
                    });
                });

                  const dz = new Dropzone("#receiptDropzone", {
                    url: '{{ route('document.request.payment') }}',
                    paramName: 'receipt',
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    init: function() {
                        let myDropzone = this;

                        this.on("removedfile", function(file) {
                            if (this.files.length < this.options.maxFiles) {
                                this.options.dictMaxFilesExceeded =
                                    "You can not upload any more files.";
                            }
                        });

                        $('#UploadPayment').on('submit', function(e) {
                            e.preventDefault();
                            $("#btn_submit").html(
                                'Submitting <span class="spinner-border spinner-border-sm align-middle ms-2"></span>'
                            );
                            $("#btn_submit").attr("disabled", true);
                            let form = this;
                            let formData = new FormData(form);

                            if (myDropzone.getAcceptedFiles().length > 0) {
                                formData.append('receipt', myDropzone.getAcceptedFiles()[0]);
                            }

                            $.ajax({
                                url: $(form).attr('action'),
                                method: $(form).attr('method'),
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.status == 422) {
                                        $("#btn_submit").text('Submit').prop("disabled",
                                            false);
                                        $.each(response.error, function(prefix, val) {
                                            $(form).find('span.' + prefix +
                                                '_error').text(val[0]);
                                        });

                                        if (myDropzone.getAcceptedFiles().length === 0) {
                                            $(form).find('span.receipt_error').text(
                                                'Receipt image is required.');
                                        }
                                    } else {
                                        form.reset();
                                        myDropzone.removeAllFiles();
                                        $("#btn_submit").text('Submit').prop("disabled",false);
                                        AllDocumentRecords();
                                        $('#UploadReceipt').modal('hide');

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Receipt Uploaded Successfully!',
                                            showConfirmButton: true,
                                        })

                                    }
                                },
                                error: function() {
                                    $("#btn_submit").text('Submit').prop("disabled", false);
                                }
                            });
                        });

                        $('#UploadReceipt').on('hidden.bs.modal', function() {
                            myDropzone.removeAllFiles();
                            $('#UploadPayment').find('span.text-danger').text('');
                            $('#UploadPAyment')[0].reset();
                        });
                    }
                });

            });
        </script>
    @endpush
@endsection
