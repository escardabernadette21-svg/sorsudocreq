@extends('layouts.registrar')
@section('title')
    Manage Announcement
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Announcement</a></li>
                                <li class="breadcrumb-item active">All Announcement</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table comman-shadow"  >
                        <div class="card-body">
                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="page-title">Manage Announcement </h3>
                                    </div>
                                    <div class="col-auto text-start float-end ms-auto download-grp">
                                        <a type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#create_announcement_modal">Create Announcement <i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="row table-row table-responsive" id="all_announcements">
                                {{-- Table of all user's will appear  or render here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Announcement Create --}}
    <div class="modal custom-modal fade" id="create_announcement_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Announcement</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('announcement.store') }}" method="POST" id="Create_Announcement"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" name="title" placeholder="Title">
                                <span class="text-danger error-text title_error"></span>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Content <span class="login-danger">*</span></label>
                                <textarea type="text" class="form-control" name="content" placeholder="Type here . . ." cols="30"
                                    rows="10"></textarea>
                                <span class="text-danger error-text content_error"></span>
                            </div>
                        </div>

                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="close_btn">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn_submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal For View Announcement --}}
    <div class="modal custom-modal fade" id="ViewAnnouncementModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Announcement</h5>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" id="id" hidden>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    readonly>
                                <span class="text-danger error-text title_error"></span>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Content <span class="login-danger">*</span></label>
                                <textarea type="text" class="form-control" id="content" name="content" placeholder="Type here . . ."
                                    cols="30" rows="10" readonly></textarea>
                                <span class="text-danger error-text content_error"></span>
                            </div>
                        </div>


                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="view_close_btn">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal For Update Announcement --}}
    <div class="modal custom-modal fade" id="EditAnnouncementModal" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Announcement</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('announcement.update') }}" method="POST" id="Update_Announcement"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" id="edit_id" hidden>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Title <span class="login-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="edit_title" placeholder="Title">
                                <span class="text-danger error-text title_error"></span>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Content <span class="login-danger">*</span></label>
                                <textarea type="text" class="form-control" name="content" id="edit_content" placeholder="Type here . . ." cols="30"
                                    rows="10"></textarea>
                                <span class="text-danger error-text content_error"></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label class="form-label">Status <span class="login-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-select">
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>

                        <div class="mt-4 float-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="edit_close_btn">Close</button>
                            <button type="submit" class="btn btn-primary" id="edit_btn_submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script>
        $(document).ready(function () {

            GetAnnouncement();

            function GetAnnouncement() {
                $.ajax({
                    url: '{{ route('announcement.fetch') }}',
                    method: 'GET',
                    success: function(response) {
                        $("#all_announcements").html(response);
                        $("#all_announcements_table").DataTable({

                            "order": [
                                [0, "asc"]
                            ],

                        });
                    }
                });
            }

             $("#Create_Announcement").on('submit', function(e) {
                e.preventDefault();
               $("#btn_submit").html('Submitting <span class="fas fa-spinner fa-spin align-middle ms-2"></span>');
                $('#btn_submit').attr("disabled", true);
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: "json",
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(response) {

                        if (response.status == 422) {
                            $("#btn_submit").removeAttr("disabled");
                            $.each(response.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                            $("#btn_submit").text('Submit');

                        } else {

                            $(form)[0].reset();
                            $('#btn_submit').removeAttr("disabled");
                            $('#btn_submit').text('Submit');
                            GetAnnouncement();
                            $("#create_announcement_modal").modal('hide');

                            // SWEETALERT
                            Swal.fire({
                                icon: 'success',
                                title: 'Announcement Created Successfully',
                                showConfirmButton: false,
                                timer: 1700,
                                timerProgressBar: true,
                            });
                        }

                        $('#close_btn').on('click', function() {
                            $("#Create_Announcement").find('span.text-danger').text('');
                        });



                    }
                });
            });

            $(document).on('click', '.view_announcement', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('announcement.show') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {

                        $("#id").val(response.id);
                        $("#title").val(response.title);
                        $("#content").val(response.content);
                    }
                });
            });

            $(document).on('click', '.edit_announcement', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: '{{ route('announcement.show') }}',
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {

                        $("#edit_id").val(response.id);
                        $("#edit_title").val(response.title);
                        $("#edit_content").val(response.content);
                        $("#edit_status").val(response.status);
                    }
                });
            });

            $("#Update_Announcement").on('submit', function(e) {
                e.preventDefault();
                $("#edit_btn_submit").html(
                    'Updating <span class="fas fa-spinner fa-spin align-middle ms-2"></span>');
                $('#edit_btn_submit').attr("disabled", true);
                var form = this;

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: "json",
                    contentType: false,
                    beforeSend: function() {

                        $(form).find('span.error-text').text('');

                    },
                    success: function(response) {

                        if (response.status == 422) {
                            $('#edit_btn_submit').removeAttr("disabled");

                            $.each(response.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });

                            $("#edit_btn_submit").text('Update');

                        } else {

                            $(form)[0].reset();
                            $('#edit_btn_submit').removeAttr("disabled");
                            $('#edit_btn_submit').text('Update');
                            GetAnnouncement();
                            $("#EditAnnouncementModal").modal('hide'); //hide the modal

                            // SWEETALERT
                            Swal.fire({
                                icon: 'success',
                                title: 'Announcement updated successfully',
                                showConfirmButton: true,
                                timer: 1700,

                            })
                        }

                        // Event binding for close button inside modal
                        $('#edit_close_btn').on('click', function() {
                            $("#Update_Announcement").find('span.text-danger').text('');
                        });

                        $('#edit_close_header_btn').on('click', function() {
                            $("#Update_Announcement").find('span.text-danger').text('');
                        });

                    }
                });
            });




            $(document).on('click', '.delete_announcement', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('announcement.delete') }}',
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                console.log(response);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted Successfully.',
                                    showConfirmButton: false,
                                    timer: 1700,
                                    timerProgressBar: true,

                                })
                                GetAnnouncement();
                            }
                        });
                    }
                })
            });

        });
    </script>
@endsection
@endsection
