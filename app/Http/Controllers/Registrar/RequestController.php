<?php

namespace App\Http\Controllers\Registrar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocumentPayment;
use App\Models\DocumentRequest;
use App\Events\NewDocumentRequest;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentRequestItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Registrar\UpdateDocumentStatusRequest;

class RequestController extends Controller
{
    /**
     * Display the document request index page.
     *
     * @return \Illuminate\View\View
     */
    public function index(){

        return view('registrar.document-request.index');
    }

    /**
     * Fetch all document requests made by students.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AllRequest() {

        $documentrequests = DocumentRequest::with('items', 'payment')->get();

        $i = 1;
        if ($documentrequests->count() > 0) {
            $output = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="all_document_request_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Reference Number</th>
                                    <th>Student Name</th>
                                    <th>Student Type</th>
                                    <th>Course</th>
                                    <th>Year Level</th>
                                    <th>Batch Year</th>
                                    <th>Requested Date</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th>Receipt Image</th>
                                    <th>Payment Status</th>
                                    <th>Claimed Date</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($documentrequests as $data) {
                $receiptPath = ($data->payment && $data->payment->receipt) ? $data->payment->receipt : null;
                $receiptDisplay = $receiptPath
                ? '<img src="' . asset('storage/' . $receiptPath) . '" class="receipt-thumbnail" data-bs-toggle="modal" data-bs-target="#receiptModal" data-img="' . asset('storage/' . $receiptPath) . '" style="width:100px; height:100px; cursor: pointer;">'
                : '<span class="text-muted"><i class="fas fa-exclamation-circle text-danger"></i> No payment receipt Uploaded</span>';

                $statusBadgeClass = match ($data->status) {
                    'Pending' => 'bg-warning text-dark',
                    'Receipt Uploaded' => 'bg-primary text-dark',
                    'Under Verification' => 'bg-light text-dark',
                    'Processing' => 'bg-secondary',
                    'Ready for Pick-up' => 'bg-success',
                    'Completed' => 'bg-success',
                    'Cancelled' => 'bg-danger',
                    default => 'bg-light text-dark',
                };
                $requestBadge = '<span class="badge ' . $statusBadgeClass . '">' . ucwords($data->status)  . '</span>';

                $paymentStatus = $data->payment->status ?? 'Unpaid';
                $paymentBadgeClass = match ($paymentStatus) {
                    'Paid' => 'bg-success',
                    'Pending Review' => 'bg-warning text-dark',
                    'Cancelled' => 'bg-danger',
                    'Unpaid' => 'bg-secondary',
                    default => 'bg-light text-dark',
                };
                $paymentBadge = '<span class="badge ' . $paymentBadgeClass . '">' . $paymentStatus . '</span>';

                $output .= '<tr style="font-size: 1rem; vertical-align: middle;">
                                <td>' . $i++ . '</td>
                                <td>' . $data->student_id . '</td>
                                <td>' . $data->reference_number . '</td>
                                <td>' . $data->studentname . '</td>
                                <td>' . ucwords($data->student_type) . '</td>
                                <td>' . $data->course . '</td>
                                <td>' . ($data->year ?? 'N/A'). '</td>
                                <td>' .($data->batch_year ?? 'N/A') . '</td>
                                <td>' . Carbon::parse($data->request_date)->format('F j, Y') . '</td>
                                <td>' . collect($data->items)->pluck('purpose')->unique()->implode(', ') . '</td>
                                <td>' . $requestBadge . '</td>
                                <td>' . $receiptDisplay . '</td>
                                <td>' . $paymentBadge . '</td>
                                <td>' . ($data->claimed_date ? Carbon::parse($data->claimed_date)->format('F j, Y') : 'N/A') . '</td>
                                <td style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    <span class="view-remarks"
                                        style="cursor:pointer; color:black; text-decoration:none;"
                                        data-remarks="' . e($data->remarks ?? "No remarks") . '">
                                        ' . ($data->remarks ?? 'N/A') . '
                                    </span>
                                </td>



                                <td>
                                    <div class="dropdown action-dropdown">
                                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #7E0001; color: #fff;">
                                            More Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" id="' . $data->id . '" class="dropdown-item view_request_document" data-bs-toggle="modal" data-bs-target="#ViewRequestedDocument">
                                                    View Documents Requested
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" id="' . $data->id . '" class="dropdown-item view_status" data-bs-toggle="modal" data-bs-target="#UpdateStatusModal">
                                                    Update Status
                                                </a>
                                            </li>

                                            <li>
                                                <a href="#" id="' . $data->id . '" class="dropdown-item DeleteRequestedDocument">
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>';
            }

            $output .= '</tbody></table>';
            echo $output;

        } else {
            echo '<h1 class="text-center text-secondary my-5">No document request present in the database!</h1>';
        }
    }

    /**
     * View the status of a document request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ViewStatus(Request $request)
    {
        $data = DocumentRequest::find($request->id);

        if (!$data) {
            return response()->json(['message' => 'Document Request not found.'], 404);
        }

        return response()->json($data);
    }

    public function UpdateStatus(UpdateDocumentStatusRequest $request){
        try {
            DB::beginTransaction();
            $request->all();
            $data = DocumentRequest::findOrFail($request->id);

            $data->update([
                'status' => $request->status,
                'claimed_date' =>( $request->status == 'Completed') ? Carbon::now() : null,
                'remarks' => $request->remarks,
            ]);

           if ($request->status === 'Cancelled') {
                // Check if there's already a payment record
                $existingPayment = DocumentPayment::where('document_request_id', $request->id)->first();

                if ($existingPayment) {
                    // Just update status and keep existing data (like receipt)
                    $existingPayment->update([
                        'status'       => 'Cancelled',
                    ]);
                } else {
                    // No payment yet — create a cancelled record
                   $data =  DocumentPayment::create([
                        'document_request_id' => $request->id,
                        'user_id'       => $request->user_id,
                        'amount'        => 0,
                        'receipt'       => null,
                        'payment_date'  => Carbon::now(),
                        'status'        => 'Cancelled',
                    ]);
                }
            }

            event(new NewDocumentRequest($data));





            DB::commit();

            return response()->json([
                'status' => 201,
                'msg' => 'Document status updated successfully',
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => 400,
                'msg' => 'Failed to update document status. ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * View requested document items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ViewRequestedDocument(Request $request)
    {
        $documentRequestItems = DocumentRequestItem::where('document_request_id', $request->id)->get();

        if ($documentRequestItems->isEmpty()) {
            return response()->json(['message' => 'No document items found.'], 404);
        }

        return response()->json($documentRequestItems);
    }

    /**
     * Delete a document request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request){

        DB::beginTransaction();

        try {

            if (empty($request->id)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid request ID.',
                ], 400);
            }

            $documentRequest = DocumentRequest::find($request->id);

            if (!$documentRequest) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'Document Request not found.',
                ], 404);
            }

            $documentRequest->delete();
            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'Document Request Deleted Successfully.',
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();
            return response()->json([
                'status' => 500,
                'msg' => 'Something went wrong. ' . $e->getMessage(),
            ], 500);
        }
    }



}
