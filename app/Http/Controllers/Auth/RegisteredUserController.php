<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            // Upload profile picture if provided
            $filename = $this->handleProfilePicture($request);

            // Prepare year data based on student type
            $yearData = $this->getYearData($request);

            // Create the user
            $user = User::create(array_merge($yearData, [
                'profile_picture' => $filename,
                'student_id'      => $request->student_id,
                'firstname'       => $request->firstname,
                'middlename'      => $request->middlename,
                'lastname'        => $request->lastname,
                'phone_number'    => $request->phone_number,
                'course'          => $request->course,
                'role'            => 'student',
                'student_type'    => $request->student_type,
                'email'           => $request->email,
                'password'        => Hash::make($request->password),
            ]));

            DB::commit();

            // Fire registered event + login
            event(new Registered($user));
            Auth::login($user);

            return response()->json([
                'status'   => 200,
                'msg'      => 'Your account has been created successfully! Redirecting to the dashboard...',
                'redirect' => route('student.homepage.index'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Registration Error: ' . $e->getMessage());

            return response()->json([
                'status' => 400,
                'msg'    => 'Failed to create account: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle profile picture upload.
     */
    private function handleProfilePicture(RegisterRequest $request): ?string
    {
        if (!$request->hasFile('profile_picture')) {
            return null;
        }

        $file = $request->file('profile_picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/student/profile', $filename);

        return $filename;
    }

    /**
     * Get year data based on student type.
     */
    private function getYearData(RegisterRequest $request): array
    {
        if ($request->student_type === 'alumni') {
            return ['year' => null, 'batch_year' => $request->batch_year];
        }

        // For enrolled students
        return ['year' => $request->year, 'batch_year' => null];
    }
}
