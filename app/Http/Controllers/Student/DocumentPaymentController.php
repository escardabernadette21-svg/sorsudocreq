<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocumentPayment;
use App\Models\DocumentRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Student\StudentPaymentRequestStore;
use App\Events\NewDocumentRequest;

class DocumentPaymentController extends Controller
{
    /**
     * Store a new document payment.
     *
     * @param  \App\Http\Requests\Student\StudentPaymentRequestStore  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StudentPaymentRequestStore $request)
    {
        DB::beginTransaction();

        try {
            // Store the uploaded receipt file
            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $receiptPath = $file->storeAs('student/receipts', $filename, 'public');
            }

            // Create the document payment record
            DocumentPayment::create([
                'document_request_id' => $request->document_request_id,
                'user_id' => Auth::id(),
                'ref_no' => $request->ref_no,
                'studentname' => $request->studentname,
                'amount' => $request->amount,
                'receipt' => $receiptPath,
                'status' => 'Pending Review',
                'payment_date' => Carbon::now(),
            ]);

            // Update the related document request status
            $documentRequest = DocumentRequest::where('id', $request->document_request_id)->firstOrFail();
            $documentRequest->update([
                'status' => 'Receipt Uploaded',
            ]);

            // Fire event for new document request
            event(new NewDocumentRequest($documentRequest));

            DB::commit();

            return response()->json([
                'status' => 201,
                'msg' => 'Payment Created Successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 400,
                'msg' => 'Failed to create payment. ' . $e->getMessage(),
            ]);
        }
    }
}
