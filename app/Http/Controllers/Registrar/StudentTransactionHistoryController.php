<?php

namespace App\Http\Controllers\Registrar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class StudentTransactionHistoryController extends Controller
{
    public function index()
    {
        return view('registrar.transactions.index');
    }

    public function AllTransactionHistory()
    {

        $transaction_history = DocumentRequest::with('items', 'payment')->where('claimed_date', '!=', null)->get();

        $i = 1;
        if ($transaction_history->count() > 0) {
            $output = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="transaction-history-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Student Type</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Batch Year</th>
                                    <th>Reference Number</th>
                                    <th>Request Date</th>
                                    <th>Requested Documents</th>
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
                    'Receipt Uploaded' => 'bg-primary text-dark',
                    'Under Verification' => 'bg-light text-dark',
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

                $requestedDocuments = collect($data->items)->map(function ($item) {
                    $text = $item->type;
                    if ($item->quantity) {
                        $text .= ' (' . $item->quantity . 'x)';
                    }
                    return $text;
                })->implode('<br>');

                $output .= '<tr style="font-size: 1rem; vertical-align: middle;">
                    <td>' . $i++ . '</td>
                    <td>' . $data->studentname . '</td>
                    <td>' . $data->student_id . '</td>
                    <td>' . ucwords($data->student_type) . '</td>
                    <td>' . $data->course . '</td>
                    <td>' . ($data->year ?? 'N/A') . '</td>
                     <td>' . ($data->batch_year ?? 'N/A') . '</td>
                    <td>' . $data->reference_number . '</td>
                    <td>' . Carbon::parse($data->request_date)->format('F j, Y') . '</td>
                    <td>' . $requestedDocuments . '</td>
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
            echo '<h1 class="text-center text-secondary my-5">No transaction history found. </h1>';
        }
    }


    public function download(Request $request)
    {
        $query = DocumentRequest::with(['items', 'payment'])
            ->whereNotNull('claimed_date');

        // Student Type Filter
        if ($request->filled('student_type') && $request->student_type !== 'All') {
            $query->where('student_type', $request->student_type);
        }

        // Year Level Filter (for enrolled students)
        if ($request->filled('year') && $request->year !== 'All') {
            $query->where('year', $request->year);
        }

        // Batch Year Filter (for alumni)
        if ($request->filled('batch_year') && $request->batch_year !== 'All') {
            $query->where('batch_year', $request->batch_year);
        }

        // Course Filter
        if ($request->filled('course') && $request->course !== 'All') {
            $query->where('course', $request->course);
        }

        //Date Range Filter
        if ($request->filled('from_date')) {
        $query->whereDate('claimed_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('claimed_date', '<=', $request->to_date);
        }

        $transaction_history = $query->get();

        if ($transaction_history->isEmpty()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No transaction history found for the selected filters.'
                ]);
            }
            return back()->with('error', 'No transaction history found for the selected filters.');
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $pdf = Pdf::loadView('registrar.report.transaction-history-download', compact('transaction_history'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('transaction_history.pdf');
    }

}