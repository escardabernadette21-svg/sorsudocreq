<?php

namespace App\Http\Controllers\Registrar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocumentPayment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Registrar\UpdatePaymentRequest;

class PaymentController extends Controller
{
    public function index(){
        return view('registrar.payment.index');
    }
     public function AllPayment() {

        $documentpayments = DocumentPayment::with('documentRequest')->get();

        $i = 1;
        if ($documentpayments->count() > 0) {
            $output = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="all_document_payment_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>Reference Number</th>
                                    <th>Student Name</th>
                                    <th>Requested Date</th>
                                    <th>Receipt Image</th>
                                    <th>Amount to Pay</th>
                                    <th>Payment Status </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($documentpayments as $data) {
                $receiptPath = ($data->receipt) ? $data->receipt : null;
                $receiptDisplay = $receiptPath
                ? '<img src="' . asset('storage/' . $receiptPath) . '" class="receipt-thumbnail" data-bs-toggle="modal" data-bs-target="#receiptModal" data-img="' . asset('storage/' . $receiptPath) . '" style="width:100px; height:100px; cursor: pointer;">'
                : '<span class="text-muted"><i class="bi bi-exclamation-circle-fill text-danger"></i> No     Uploaded</span>';


                $paymentStatus = $data->status ?? 'Unpaid';
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
                                <td>' . $data->documentRequest->student_id . '</td>
                                <td>' . $data->documentRequest->reference_number . '</td>
                                <td>' . $data->documentRequest->studentname . '</td>
                                <td>' . Carbon::parse($data->documentRequest->request_date)->format('F j, Y') . '</td>
                                <td>' . $receiptDisplay . '</td>
                                <td>₱ ' . number_format($data->amount, 2) . '</td>
                                <td>'. $paymentBadge . '</td>';
                                if($data->status == 'Paid' || $data->status == 'Cancelled'){
                                    $output .= '<td>
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        Update Payment
                                                    </button>
                                                </td>';
                                } else {
                                    $output .= '
                                <td>
                                    <div class="dropdown action-dropdown">
                                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #7E0001; color: #fff;">
                                            More Actions
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" id="' . $data->id . '" class="dropdown-item payment_status" data-bs-toggle="modal" data-bs-target="#PaymentStatusModal">
                                                    Update Payment
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>';
                            }
                            $output .='</tr>';
            }

            $output .= '</tbody></table>';
            echo $output;

        } else {
            echo '<h1 class="text-center text-secondary my-5">No document request present in the database!</h1>';
        }
    }

    public function ViewPaymentStatus(Request $request){

        $data = DocumentPayment::find($request->id);

        if(!$data){
            return response()->json(['message' => 'Document Request not found.'], 404);
        }
        return response()->json($data);

    }


    public function UpdatePaymentStatus(UpdatePaymentRequest $request){

         try {
            DB::beginTransaction();
            $request->all();
            $data = DocumentPayment::findOrFail($request->id);
            $data->update([
                'status' => $request->status,
            ]);
            DB::commit();

            return response()->json([
                'status' => 201,
                'msg' => 'Payment status updated successfully',
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => 400,
                'msg' => 'Failed to update payment status. ' . $e->getMessage(),
            ]);
        }

    }
}
