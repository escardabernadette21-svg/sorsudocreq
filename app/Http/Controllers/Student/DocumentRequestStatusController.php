<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DocumentRequestStatusController extends Controller
{
    /**
     * Display the document request status index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $timelineSteps = ['Pending', 'Receipt Uploaded', 'Under Verification', 'Processing', 'Ready for Pick-up'];

        $statusMap = [
            'Pending' => 0,
            'Receipt Uploaded' => 1,
            'Under Verification' => 2,
            'Processing' => 3,
            'Ready for Pick-up' => 4,
            'Completed' => 5,
        ];

        $documentrequests = DocumentRequest::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        foreach ($documentrequests as $request) {
            $status = $request->status;
            if ($status === 'Cancelled') {
                $request->currentStep = -1; // special flag
                $request->isCancelled = true;
            } else {
                $request->currentStep = $statusMap[$status] ?? 0;
                $request->isCancelled = false;
            }
        }

        return view('student.request-status.index', [
            'documentrequests' => $documentrequests,
            'timelineSteps' => $timelineSteps,
        ]);
    }
}
