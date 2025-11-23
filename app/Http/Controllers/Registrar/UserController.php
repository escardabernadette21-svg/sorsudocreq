<?php

namespace App\Http\Controllers\Registrar;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Registrar\UserStoreRequest;
use App\Http\Requests\Registrar\UserUpdateRequest;

class UserController extends Controller
{
    public function index(){
        return view('registrar.students.index');
    }

    public function store(UserStoreRequest $request){
        try {

            DB::beginTransaction();

            $request->all();
            if ($request->hasFile('profile_picture')) {

                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension(); // Get file extension
                $filename = time() . '.' . $extension; // Generate unique filename
                $file->storeAs('public/student/profile', $filename); // Store file
            } else {
                $filename = null; // Default value if no file uploaded
            }

            // Cleanest version
            $yearData = $request->student_type === 'alumni'
                ? ['year' => null, 'batch_year' => $request->batch_year]
                : ['year' => $request->year, 'batch_year' => null];

            User::create(array_merge($yearData, [
                'profile_picture' => $filename,
                'student_id' => $request->student_id,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'phone_number' => $request->phone_number,
                'course' => $request->course,
                'role' => 'student',
                'student_type' => $request->student_type,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]));


            DB::commit();

            return response()->json([
                'status' => 201,
                'msg' => 'User Created Successfully',
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'status' => 400,
                'msg' => 'Failed to create user. ' . $e->getMessage(),
            ]);
        }
    }

    public function UserRecord() {
        $datas = User::where('role', 'student')->get();

        $i = 1;
        if ($datas->count() > 0) {
            $output = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="all_users_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Profile Pictures</th>
                                    <th>Student ID </th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Course</th>
                                    <th>Student Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($datas as $data) {
                $output .= '<tr style="font-size: 1rem; vertical-align: middle;">
                                <td>'. $i++ .'</td>
                                <td>';
                                if ($data->profile_picture != null) {
                                    $output .= '<img src="storage/student/profile/' . $data->profile_picture . '" style="border-radius: 100%; border: 0.5px solid gray; padding: 1px; width: 50px; height: 50px;">';
                                } else {
                                    $output .= '<img src="registrar/assets/img/blank.png" style="border-radius: 100%; border: 0.5px solid gray; padding: 1px; width: 50px; height: 50px;">';
                                }
                                $output .= '</td>
                                <td>'. $data->student_id .'</td>
                                <td>'.$data->firstname.'</td>
                                <td>'.$data->lastname.'</td>
                                <td>'.ucwords($data->course).'</td>
                                <td>'.ucwords($data->student_type ?? 'N/A').'</td>
                                <td>
                                    <a href="#" id="' .$data->id. '" type="button" class="btn btn-secondary btn-sm text-white mx-1 view_user" data-bs-toggle="modal" data-bs-target="#ViewUser">View</a>
                                     <a href="#" id="' .$data->id. '" type="button" class="btn btn-success btn-sm text-white mx-1 edit_user" data-bs-toggle="modal" data-bs-target="#EditUser">Edit</a>
                                    <a href="#" id="' .$data->id. '" type="button" class="btn btn-danger btn-sm  text-white mx-1 DeleteUser">Delete</a>
                                </td>
                            </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        }
        else {
            echo '<h1 class="text-center text-secondary my-5">No user record present in the database!</h1>';
        }
    }

    public function view(Request $request){
        $data = User::find($request->id);
        return response()->json($data);
    }

    public function update(UserUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $update_data = User::findOrFail($request->id);

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;

                // Store file
                $file->storeAs('public/student/profile', $filename);

                // Delete old picture if exists
                if ($update_data->profile_picture) {
                    Storage::delete('public/student/profile/' . $update_data->profile_picture);
                }
            } else {
                $filename = $update_data->profile_picture; // keep existing
            }

            // Determine year/year_graduated based on student_type
             $yearData = $request->student_type === 'alumni'
                ? ['year' => null, 'batch_year' => $request->batch_year]
                : ['year' => $request->year, 'batch_year' => null];

            // Prepare data
            $data = array_merge($yearData, [
                'profile_picture' => $filename,
                'student_id' => $request->student_id,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'phone_number' => $request->phone_number,
                'course' => $request->course,
                'role' => 'student',
                'student_type' => $request->student_type,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // Update user
            $update_data->update($data);

            DB::commit();

            return response()->json([
                'status' => 201,
                'msg' => 'User updated successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'msg' => 'Failed to update user. ' . $e->getMessage(),
            ]);
        }
    }




    public function delete(Request $request){

        DB::beginTransaction();

        try {
            // Validate that the ID is present
            if (!$request->has('id')) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Missing user ID.',
                ], 400);
            }

            // Try to find the user
            $user = User::find($request->id);

            if (!$user) {
                return response()->json([
                    'status' => 404,
                    'msg' => 'User not found.',
                ], 404);
            }

            if ($user->profile_picture && Storage::exists('public/student/profile/' . $user->profile_picture)) {
                Storage::delete('public/student/profile/' . $user->profile_picture);
            }

            // Delete the user
            $user->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'msg' => 'User deleted successfully.',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'msg' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

}
