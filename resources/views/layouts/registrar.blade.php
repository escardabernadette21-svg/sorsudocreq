<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title')</title>
    <link rel="shortcut icon" href="{{ URL::to('registrar/assets/img/logo.png') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/icons/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('registrar/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    @yield('styles')
</head>
<body>
    <div class="main-wrapper">
        {{-- Header --}}
        @include('layouts.partials.registrar.header')
        {{-- Sidebar --}}
        @include('layouts.partials.registrar.sidebar')
        {{-- Content --}}
        @yield('content')
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ URL::to('registrar/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/js/feather.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/js/circle-progress.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/js/script.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ URL::to('registrar/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (Session::has('message'))
            toastr.options.progressBar = true;
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>
    <script type="text/javascript">
        // Toggle password visibility for create form
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle Font Awesome icons
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        });


        // Toggle password visibility for edit form
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('edit_password');
            const togglePassword = document.getElementById('edit_togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle Font Awesome icons
                if (type === 'text') {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                } else {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
            });
        });


        $(document).ready(function() {
            //For The Datatable
            $('.table').DataTable({
                responsive: true,
            });


            //For The Select
            $('.select2s-hidden-accessible').select2({
                closeOnSelect: false
            });


            // For The AJAX Header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        });
    </script>
    @yield('script')
</body>
</html>
