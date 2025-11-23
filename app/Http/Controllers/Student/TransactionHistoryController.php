<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index(Request $request){
        return view('student.transaction-history.index');
    }

    public function AllTransaction(){
         $transaction_history = DocumentRequest::with('items', 'payment')
                        ->where('user_id', Auth::user()->id)
                        ->where('claimed_date', '!=', null)
                        ->get();

        $i = 1;
        if ($transaction_history->count() > 0) {
            $output ='<table class="table table-striped table-row-bordered gy-5 gs-7" id="all_transaction_history_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Reference Number</th>
                        <th>Request Date</th>
                        <th>Purpose</th>
                        <th>Request Status</th>
                        <th>Payment Status</th>
                        <th>Total Amount</th>
                        <th>Claimed Date</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($transaction_history as $data) {

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


                $output .= '<tr style="font-size: 1rem; vertical-align: middle;">
                    <td>' . $i++ . '</td>
                    <td>' . $data->studentname . '</td>
                    <td>' . $data->student_id . '</td>
                    <td>' . $data->reference_number . '</td>
                    <td>' . Carbon::parse($data->request_date)->format('F j, Y') . '</td>
                    <td>' . collect($data->items)->pluck('purpose')->unique()->implode(', ') . '</td>
                    <td>' . $requestBadge . '</td>
                    <td>' . $paymentBadge . '</td>
                    <td>' . number_format($data->total_amount, 2) . '</td>
                    <td>' . ($data->claimed_date ? Carbon::parse($data->claimed_date)->format('F j, Y') : 'N/A') . '</td>
                </tr>';
            }

            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-black my-5">No transaction history found.</h1>';
        }
    }
}
