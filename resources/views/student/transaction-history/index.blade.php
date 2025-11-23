@extends('layouts.student')

@section('title')
    All Transaction History
@endsection

@section('content')
    {{-- <div class="toolbar py-2 py-lg-15" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column">
                <h1 class="d-flex text-white fw-bolder fs-2qx my-1 me-5">
                    Transaction History
                </h1>
            </div>
        </div>
    </div> --}}
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl  py-5 py-lg-10">
        <div class="content flex-row-fluid" style="border:2px solid var(--bs-custom); border-radius:1%">
            <div class="card">
                <div class="card-body p-lg-17">
                    <div class="table-responsive" id="all_transaction_history">
                        {{-- Table Appear Here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('script')
        <script type="text/javascript">


            $(document).ready(function() {

                AllDocumentRecords();

                function AllDocumentRecords() {

                    $.ajax({
                        url: '{{ route('transactions-history.fetch') }}',
                        method: 'GET',
                        success: function(response) {
                            $("#all_transaction_history").html(response);
                            $("#all_transaction_history_table").DataTable({
                                "order": [
                                    [0, "asc"]
                                ],
                                "language": {
                                    "lengthMenu": "Show _MENU_",
                                    "search": "",
                                    "searchPlaceholder": "Search..."
                                },
                                "dom": "<'row mb-2'" +
                                    "<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
                                    "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                                    ">" +

                                    "<'table-responsive'tr>" +

                                    "<'row'" +
                                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                                    ">"
                            });
                        }
                    });
                }


            });
        </script>
    @endpush
@endsection
