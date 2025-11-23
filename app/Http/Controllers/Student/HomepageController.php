<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index(){
         $user = Auth::user();

        // Get the latest document request by the logged-in user
        $latestRequest = DocumentRequest::where('user_id', $user->id)
            ->latest()
            ->first();

        $ref_no = $latestRequest?->reference_number ?? null;

        return view('student.homepage.index', compact('ref_no'));
    }
}
