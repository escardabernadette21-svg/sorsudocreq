<?php

namespace App\Http\Controllers\Student;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentAnnouncementController extends Controller
{
    public function index(){

        $all_announcements = Announcement::where('status', 'active')->paginate(6);
        return view('student.announcement.index', compact('all_announcements'));
    }
}
