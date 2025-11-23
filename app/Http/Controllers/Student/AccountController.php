<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Student\UpdateAccountRequest;

class AccountController extends Controller
{
    public function index()
    {
        return view('student.account.index');
    }

    public function update(UpdateAccountRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail(Auth::id());

            // Handle profile picture
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/student/profile', $filename);

                // Delete old profile if exists
                if ($user->profile_picture) {
                    Storage::delete('public/student/profile/' . $user->profile_picture);
                }

                $user->profile_picture = $filename;
            }

            // Update user details
            $user->firstname    = $request->firstname;
            $user->middlename   = $request->middlename;
            $user->lastname     = $request->lastname;
            $user->course       = $request->course;
            $user->phone_number = $request->phone_number;
            $user->student_type = $request->student_type;
            $user->email        = $request->email;

            // Update year / batch_year based on student type
            if ($request->student_type === 'enrolled') {
                $user->year = $request->year;
                $user->batch_year = null; // clear batch_year for enrolled
            } elseif ($request->student_type === 'alumni') {
                $user->batch_year = $request->batch_year;
                $user->year = null; // clear year for alumni
            }

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();

            return redirect()
                ->route('student-account.index')
                ->with([
                    'message' => 'Account updated successfully.',
                    'alert-type' => 'success',
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to update account. ' . $e->getMessage(),
            ]);
        }
    }
}
