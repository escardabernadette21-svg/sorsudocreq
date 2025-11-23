<?php

namespace App\Http\Controllers\Registrar;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Registrar\ProfileAccountRequest;

class ProfileAccountController extends Controller
{
    public function index()
    {
        return view('registrar.account.index');
    }

    public function update(ProfileAccountRequest $request)
    {

         DB::beginTransaction();

        try {

            $user = User::findOrFail(Auth::id());
            $request->all();
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/registrar/profile', $filename);

                // Delete old profile if exists
                if ($user->profile_picture) {
                    Storage::delete('public/registrar/profile/' . $user->profile_picture);
                }

                $user->profile_picture = $filename;
            }

            //  Update user details
            $user->firstname  = $request->firstname;
            $user->middlename = $request->middlename;
            $user->lastname   = $request->lastname;
            $user->phone_number = $request->phone_number;
            $user->email      = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();

            //  Notification message
            return redirect()
                ->route('registrar-profile.index')
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
