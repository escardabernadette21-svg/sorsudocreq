<?php

namespace App\Http\Controllers\Registrar;

use App\Models\DocumentRequest;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $statuses = ['Pending', 'Receipt Uploaded', 'Under Verification', 'Processing', 'Ready for Pick-up', 'Completed', 'Cancelled'];


        $counts = DocumentRequest::whereIn('status', $statuses)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // $chartData = DocumentRequest::selectRaw('request_date, status, COUNT(*) as total')
        //     ->whereIn('status', $statuses)
        //     ->groupBy('request_date', 'status')
        //     ->orderBy('request_date', 'asc')
        //     ->get();
        $chartData = DocumentRequest::selectRaw("
            DATE_FORMAT(request_date, '%Y-%m') as request_month,
            status,
            COUNT(*) as total
        ")
        ->whereIn('status', $statuses)
        ->groupBy('request_month', 'status')
        ->orderBy('request_month', 'asc')
        ->get();

        return view('registrar.dashboard.index', [
            'pending'            => $counts['Pending'] ?? 0,
            'receiptUploaded'    => $counts['Receipt Uploaded'] ?? 0,
            'under_verification' => $counts['Under Verification'] ?? 0,
            'processing'         => $counts['Processing'] ?? 0,
            'ready_for_pickup'   => $counts['Ready for Pick-up'] ?? 0,
            'completed'          => $counts['Completed'] ?? 0,
            'cancelled'          => $counts['Cancelled'] ?? 0,
            'total_requests'     => DocumentRequest::count(),
            'chartData'          => $chartData
        ]);
    }
}
