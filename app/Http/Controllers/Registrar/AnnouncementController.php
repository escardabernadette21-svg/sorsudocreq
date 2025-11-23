<?php

namespace App\Http\Controllers\Registrar;

use Carbon\Carbon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Registrar\StoreAnnouncementRequest;
use App\Http\Requests\Registrar\UpdateAnnouncementRequest;

class AnnouncementController extends Controller
{
    public function index(){

        return view('registrar.announcement.index');
    }

    public function store(StoreAnnouncementRequest $request){

        $request->all();

        Announcement::create([
            'title'  => $request->title,
            'content'  => $request->content,
        ]);

        return response()->json([
                'status' => 201,
                'msg' => 'Announcement Created Successfully',
            ]);
    }

    public function AllAnnouncement() {
        $announcements = Announcement::all();

        $i = 1;
        if ($announcements->count() > 0) {
            $output = '<table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped" id="all_announcements_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach ($announcements as $data) {
                $body = ucfirst($data->content);
                $body = strlen($body) > 50 ? substr($body, 0, 47) . '...' : $body;


                $statusBadgeClass = $data->status === 'Active' ? 'bg-success' : 'bg-danger';
                $statusBadge = '<span class="badge ' . $statusBadgeClass . '">' . ucfirst($data->status) . '</span>';

                $output .= '<tr style="font-size: 1rem; vertical-align: middle;">
                                <td>'. $i++ .'</td>
                                <td>'. $data->title .'</td>
                                <td>'. $body .'</td>
                                <td>'. $statusBadge .'</td>
                                <td>'. Carbon::parse($data->created_at)->format('F d, Y') .'</td>
                                <td>
                                    <a href="#" id="' . $data->id. '" type="button" class="btn btn-secondary btn-sm text-white mx-1 view_announcement" data-bs-toggle="modal" data-bs-target="#ViewAnnouncementModal">View</a>
                                    <a href="#" id="' . $data->id. '" type="button" class="btn btn-success btn-sm text-white mx-1 edit_announcement" data-bs-toggle="modal" data-bs-target="#EditAnnouncementModal">Edit</a>
                                    <a href="#" id="' . $data->id. '" type="button" class="btn btn-danger btn-sm text-white mx-1 delete_announcement">Delete</a>
                                </td>
                            </tr>';
            }

            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No announcement record present in the database!</h1>';
        }
    }

    public function ViewAnnouncement(Request $request){

        $data = Announcement::findOrFail($request->id);
        return response()->json($data);
    }


    public function update(UpdateAnnouncementRequest $request){


        $data = Announcement::findOrFail($request->id);
        $request->all();

        $data->update([
            'title'  => $request->title,
            'content'  => $request->content,
            'status'  => $request->status,
        ]);

        return response()->json([
            'status' => 200,
            'msg' => 'Announcement Updated Successfully',
        ]);
    }


    public function delete(Request $request){

        $data = Announcement::findOrFail($request->id);
        $data->delete();

        return response()->json([
            'status' => 200,
            'msg' => 'Announcement Deleted Successfully',
        ]);
    }


}
