<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DocumentPayment;
use App\Models\DocumentRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Events\NewDocumentRequest;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentRequestItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\DocumentItemBuilderService;
use App\Http\Requests\Student\StudentDocumentRequestStore;

class DocumentRequestController extends Controller
{
    /**
     * DocumentItemBuilderService instance for building document items.
     *
     * @var DocumentItemBuilderService
     */
    protected $builder;

    public function __construct(DocumentItemBuilderService $builder){

        $this->builder = $builder;
    }
    /**
     * Display the document request index page.
     *
     * @return \Illuminate\View\View
     */
    public function index(){

        return view('student.request.index');
    }

    /**
     * Store a new document request.
     *
     * @param  \App\Http\Requests\Student\StudentDocumentRequestStore  $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function store(StudentDocumentRequestStore $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $refNumber = 'REF-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
            $prices = config('documentprices');

            // Build all document items from the request
            $certifications = $this->builder->build(
                $request->input('certifications', []),
                'certification',
                $request->cert_qty ?? [],
                $prices,
                $request
            );

            $academicForms = $this->builder->build(
                $request->input('academic_forms', []),
                'academic_form',
                $request->academic_qty ?? [],
                $prices,
                $request
            );

            $otherServices = $this->builder->build(
                $request->input('other_services', []),
                'other_service',
                $request->other_services_qty ?? [],
                $prices,
                $request
            );

            $credentials = $this->builder->build(
                $request->input('credentials', []),
                'credential',
                $request->credentials_qty ?? [],
                $prices,
                $request
            );

            // Merge all items including credentials
            $allItems = array_merge($certifications, $academicForms, $otherServices, $credentials);
            $totalAmount = array_sum(array_column($allItems, 'total_price'));

            // Determine which year field to save
            $yearToSave = $request->year_graduated ?: $request->year;

            // Create main document request
            $documentRequest = DocumentRequest::create([
                'user_id'          => $user->id,
                'studentname'      => $request->studentname,
                'student_id'       => $request->student_id,
                'student_type'     => $request->student_type,
                'year'             => $request->year ?? null,
                'batch_year'       => $request->batch_year ?? null,
                'course'           => $request->course,
                'request_date'     => now()->format('Y-m-d'),
                'reference_number' => $refNumber,
                'total_amount'     => $totalAmount,
                'status'           => 'Pending',
            ]);

            // Save all associated items
            $documentRequest->items()->createMany($allItems);

            // Fire event for new document request
            event(new NewDocumentRequest($documentRequest));

            DB::commit();

            return response()->json([
                'status' => 201,
                'msg'    => 'Document Request Created Successfully',
                'ref_no' => $refNumber,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'msg'    => 'An error occurred while processing your request.',
                'error'  => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Generate a payment slip for the document request.
     *
     * @param  string  $ref_no
     * @return \Illuminate\View\View
     */
    public function generateSlip($ref_no){

        $request = DocumentRequest::with('items')->where('reference_number', $ref_no)
            ->where('user_id', Auth::id())
            ->latest()
            ->firstOrFail();

           //dd($request);

        return view('student.request.orderpaymentslip', compact('request'));
    }
    /**
     * Download the payment slip as a PDF.
     *
     * @param  string  $ref_no
     * @return \Illuminate\Http\Response
     */
    public function downloadSlip($ref_no){

        $request = DocumentRequest::with('items')->where('reference_number', $ref_no)->firstOrFail();

        $pdf = Pdf::loadView('student.request.slip-pdf', compact('request'));
        return $pdf->download("Payment-Slip-{$ref_no}.pdf");
    }

    /**
     * Display all document requests made by the student.
     *
     * @return \Illuminate\View\View
     */
    public function AllRequestIndex(){

        return view('student.request.all-document-request');
    }

    /**
     * Fetch all document request records for the student.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function AllRequestRecord() {
        $datarecords = DocumentRequest::with('items', 'payment')
                        ->where('user_id', Auth::user()->id)
                        ->get();

        $i = 1;
        if ($datarecords->count() > 0) {
            $output ='<table class="table table-striped table-row-bordered gy-5 gs-7" id="all_document_request_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Reference Number</th>
                        <th>Request Date</th>
                        <th>Purpose</th>
                        <th>Request Status</th>
                        <th>Payment Receipt</th>
                        <th>Payment Status</th>
                        <th>Total Amount</th>
                        <th>Claimed Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($datarecords as $data) {

                // Request Status Badge
                $statusBadgeClass = match ($data->status) {
                    'Pending' => 'bg-warning text-dark',
                    'Receipt Uploaded' => 'bg-primary',
                    'Under Verification' => 'bg-info text-dark',
                    'Processing' => 'bg-secondary',
                    'Ready for Pick-up' => 'bg-success',
                    'Completed' => 'bg-success',
                    'Cancelled' => 'bg-danger',
                    default => 'bg-light text-dark',
                };
                $requestBadge = '<span class="badge ' . $statusBadgeClass . '">' . $data->status . '</span>';

                // Payment Status Badge
                $paymentStatus = $data->payment->status ?? 'Unpaid';
                $paymentBadgeClass = match ($paymentStatus) {
                    'Paid' => 'bg-success',
                    'Pending Review' => 'bg-warning text-dark',
                    'Cancelled' => 'bg-danger',
                    'Unpaid' => 'bg-secondary',
                    default => 'bg-light text-dark',
                };
                $paymentBadge = '<span class="badge ' . $paymentBadgeClass . '">' . $paymentStatus . '</span>';

                $receiptPath = ($data->payment->receipt) ? $data->payment->receipt : null;
                $receiptDisplay = $receiptPath
                ? '<img src="' . asset('storage/' . $receiptPath) . '" class="receipt-thumbnail" data-bs-toggle="modal" data-bs-target="#receiptModal" data-img="' . asset('storage/' . $receiptPath) . '" style="width:100px; height:100px; cursor: pointer;">'
                : '<span class="text-muted"><i class="bi bi-exclamation-circle-fill text-danger"></i> No payment receipt Uploaded</span>';

                $output .= '<tr style="font-size: 1rem; vertical-align: middle;">
                    <td>' . $i++ . '</td>
                    <td>' . $data->studentname . '</td>
                    <td>' . $data->student_id . '</td>
                    <td>' . $data->reference_number . '</td>
                    <td>' . Carbon::parse($data->request_date)->format('F j, Y') . '</td>
                    <td>' . collect($data->items)->pluck('purpose')->unique()->implode(', ') . '</td>
                    <td>' . $requestBadge . '</td>
                    <td>' . $receiptDisplay . '</td>
                    <td>' . $paymentBadge . '</td>
                    <td>' . number_format($data->total_amount, 2) . '</td>
                    <td>' . ($data->claimed_date ? Carbon::parse($data->claimed_date)->format('F j, Y') : 'N/A') . '</td>
                    <td style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <span class="view-remarks"
                            style="cursor:pointer; color:black; text-decoration:none;"
                            data-remarks="' . e($data->remarks ?? "No remarks") . '">
                            ' . ($data->remarks ?? 'N/A') . '
                        </span>
                    </td>


                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #7E0001; color: #fff;">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item view_document_item" href="#" id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#view_document_item_modal">View Requested Documents</a></li>';
                               if (in_array(!$data->payment->status, ['Paid', 'Pending Review', 'Cancelled'])) {
                                    $output .= ' <li><a class="dropdown-item text-primary UploadReceipt" href="#" id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#UploadReceipt">Upload Receipt</a></li>
                                                 <li><a class="dropdown-item text-danger CancelDocumentRequest" href="#" id="' . $data->id . '">Cancel Request</a></li>';
                                }

                        $output .='</ul>
                        </div>
                    </td>
                </tr>';
            }

            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-black my-5">No document request present in the database!</h1>';
        }
    }



    public function ViewPayment(Request $request){

        $data = DocumentRequest::find($request->id);
        return response()->json($data);
    }

    public function ViewRequestItem(Request $request){
        $documentRequestItems = DocumentRequestItem::where('document_request_id', $request->id)->get();

        if ($documentRequestItems->isEmpty()) {
            return response()->json(['message' => 'No document items found.'], 404);
        }

        return response()->json($documentRequestItems);
    }

    public function DocumentRequestCancel(Request $request){

        DB::beginTransaction();

        try {
            DocumentRequest::where('id', $request->id)->update([
                'status' => 'Cancelled',
            ]);

            DocumentPayment::create([
                'document_request_id' => $request->id,
                'user_id' => Auth::id(),
                'amount' => 0,
                'receipt' => null,
                'payment_date' => now(),
                'status' => 'Cancelled',
            ]);


            DB::commit();

            return response()->json([
                'status' => 200,
                'msg'    => 'Document Request Cancelled Successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'msg'    => 'Failed to cancel the document request. ' . $e->getMessage(),
            ]);
        }
    }



}
