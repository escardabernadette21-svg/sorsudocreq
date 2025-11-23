@extends('layouts.student')

@section('title', 'Order Payment Slip')

@section('content')

    <div class="d-flex justify-content-center align-items-center px-5 py-5 mt-7">
        <div class="bg-white p-4 p-md-5 w-100 mt-7" style="max-width: 900px; border: 2px solid #8F0C00; border-radius: 10px;">

            {{-- Status Alert --}}
            @if ($request->status === 'Cancelled')
                <div class="alert alert-danger text-center mb-4" role="alert" style="font-size: 14px;">
                    <strong>Note:</strong> This document request has been <span class="text-uppercase">CANCELLED</span>.
                </div>
            @elseif (in_array($request->status, [
                    'Receipt Uploaded',
                    'Under Verification',
                    'Processing',
                    'Ready for Pick-up',
                    'Completed',
                ]))
                <div class="alert alert-warning text-center mb-4" role="alert" style="font-size: 14px;">
                    <strong>Note:</strong> Your request is currently <span
                        class="text-uppercase">{{ $request->status }}</span>. Please wait for further updates.
                </div>
            @endif

            <h3 class="text-center fw-bold mb-1">ORDER PAYMENT SLIP</h3>
            <p class="text-center mb-4" style="font-size: 14px;">PRESENT TO CASHIER</p>

            <div class="mb-3 border-bottom pb-2 row">
                <div class="col-md-8">
                    <strong>TRANSACTION REFERENCE NUMBER:</strong><br>
                    <a href="#" class="text-primary">{{ $request->reference_number }}</a>
                </div>
                <div class="col-md-4 text-md-end">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($request->request_date)->format('m-d-Y') }}
                </div>
            </div>

            <h5 class="fw-bold text-center">USER INFORMATION</h5>
            <div class="row">
                <div class="col-md-3">
                    <p><strong>Name:</strong> {{ $request->studentname }}</p>
                </div>
                <div class="col-md-3">
                    <p><strong>Student Type:</strong> {{ ucwords($request->student_type) }}</p>
                </div>
                <div class="col-md-3">
                    <p>
                        <strong>
                            @if ($request->student_type === 'enrolled')
                                Year
                            @elseif($request->student_type === 'alumni')
                                Batch Year
                            @endif
                            :
                        </strong>
                        {{ $request->student_type === 'enrolled' ? $request->year : $request->batch_year }}
                    </p>
                </div>
                <div class="col-md-3">
                    <p><strong>Course:</strong> {{ $request->course }}</p>
                </div>
            </div>

            <h5 class="fw-bold mt-4 text-center">REQUESTED DOCUMENTS</h5>
            <div class="table-responsive">
                <table class="table-sm w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($request->items as $item)
                            <tr>
                                <td>{{ $item->quantity }}x {{ $item->type }}</td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>₱{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-3">
                <div class="col-md-4 fw-bold text-end">
                    TOTAL AMOUNT: ₱{{ number_format($request->total_amount, 2) }}
                </div>
            </div>

            <div class="mt-4">
                <p><strong>PURPOSE:</strong> {{ $request->items->first()->purpose ?? 'N/A' }}</p>
                <p><strong>MESSAGE:</strong> {{ $request->items->first()->message ?? ' ' }}</p>
            </div>

            <div class="text-end mt-4 d-flex flex-wrap justify-content-end align-items-center gap-2">

                {{-- Download Payment Slip --}}
                <a href="{{ route('document.request.download', ['ref_no' => $request->reference_number]) }}"
                    class="btn btn-sm"
                    style="background-color: #fff; border: 1px solid var(--bs-custom); color: var(--bs-custom);"
                    target="_blank">
                    <i class="bi bi-download me-1" style="color: var(--bs-custom)"></i> Download Payment Slip
                </a>

                {{-- Receipt Button Logic --}}
                @if (in_array($request->status, [
                        'Receipt Uploaded',
                        'Under Verification',
                        'Processing',
                        'Ready for Pick-up',
                        'Completed',
                    ]))
                    <button type="button" class="btn btn-sm text-white" style="background-color: var(--bs-custom);"
                        disabled>
                        <i class="bi bi-file-earmark-check me-1 text-white"></i> Receipt Already Submitted
                    </button>
                @elseif ($request->status === 'Cancelled')
                    <button type="button" class="btn btn-sm text-white" style="background-color: #dc3545;" disabled>
                        <i class="bi bi-x-octagon me-1 text-white"></i> Request Cancelled
                    </button>
                @else
                    {{-- Upload Receipt Button --}}
                    <button type="button" class="btn btn-sm text-white" style="background-color: var(--bs-custom);"
                        data-bs-toggle="modal" data-bs-target="#UploadReceiptModal">
                        <i class="bi bi-upload me-1 text-white"></i> Upload Receipt
                    </button>
                @endif
            </div>

        </div>
    </div>

    <div class="modal fade" id="UploadReceiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-y pt-0 pb-15">
                    <div class="mb-13">
                        <h1 class="text-center mb-5">Upload Payment Receipt</h1>
                        <form action="{{ route('document.request.payment') }}" method="POST" enctype="multipart/form-data"
                            id="UploadReceiptForm">
                            @csrf
                            <input type="hidden" name="document_request_id" value="{{ $request->id }}">

                            <!-- Reference Number -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="" class="form-label">Reference Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="ref_no"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        value="{{ $request->reference_number }}" placeholder="Reference Number" readonly />
                                    <span class="text-danger error-text ref_no_error"></span>
                                </div>
                            </div>

                            <!-- Student Name -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="studentname" class="form-label">Student Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="studentname"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        value="{{ $request->studentname }}" placeholder="Student Name" readonly />
                                    <span class="text-danger error-text studentname_error"></span>
                                </div>
                            </div>

                            <!-- Amount to pay -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="amount to pay" class="form-label"> Amount to pay <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="amount"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        value="{{ $request->total_amount }}" placeholder="Amount to pay" readonly />
                                    <span class="text-danger error-text amount_error"></span>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Payment Details</label>
                                    <div class="p-3 border rounded bg-light">
                                        <p class="mb-1"><strong>GCash Number:</strong> 0912-345-5678</p>
                                        <p class="mb-1"><strong>Bank Account Number:</strong> 1234-5678-9012</p>
                                        <p class="mb-0"><strong>Bank Name:</strong> BDO (Juan Dela Cruz)</p>
                                    </div>
                                    <small class="text-muted">Please pay using the details above before uploading your
                                        receipt.</small>
                                </div>
                            </div>

                            <!-- Upload Receipt -->
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

                            <!-- Buttons -->
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


    @push('script')
        <script>
            Dropzone.autoDiscover = false;

            $(document).ready(function() {
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

                        $('#UploadReceiptForm').on('submit', function(e) {
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

                                        if (myDropzone.getAcceptedFiles().length ===
                                            0) {
                                            $(form).find('span.receipt_error').text(
                                                'Receipt image is required.');
                                        }
                                    } else {
                                        form.reset();
                                        myDropzone.removeAllFiles();
                                        $("#btn_submit").text('Submit').prop("disabled",
                                            false);
                                        $('#UploadReceiptModal').modal('hide');

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Receipt Uploaded Successfully!',
                                            showConfirmButton: true,
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload();
                                            }
                                        });

                                    }
                                },
                                error: function() {
                                    $("#btn_submit").text('Submit').prop("disabled",
                                        false);
                                }
                            });
                        });

                        $('#UploadReceiptModal').on('hidden.bs.modal', function() {
                            myDropzone.removeAllFiles();
                            $('#UploadReceiptForm').find('span.text-danger').text('');
                            $('#UploadReceiptForm')[0].reset();
                        });
                    }
                });
            });
        </script>
    @endpush


@endsection
