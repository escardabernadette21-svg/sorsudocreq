<div class="header">
    <div class="header-left">
        <a href="#" class="logo">
            <img src="{{ asset('registrar/assets/img/sorsu_logo_1.png') }}" alt="Logo" width="50" height="50">

        </a>
        <a href="#" class="logo logo-small">
            <img src="{{ asset('registrar/assets/img/sorsu-logo.png') }}" alt="Logo" width="30" height="30">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav user-menu">
        @php
            $document_requests = \App\Models\DocumentRequest::whereIn('status', ['Pending', 'Receipt Uploaded'])->get();
            $document_requests_count = $document_requests->count();
        @endphp

        <li class="nav-item dropdown noti-dropdown me-2">
            <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                <img src="{{ asset('registrar/assets/img/icons/header-icon-05.svg') }}" alt="">
                @if ($document_requests_count > 0)
                    <span class="badge bg-danger" id="notification-badge">{{ $document_requests_count }}</span>
                @else
                    <span class="badge bg-danger" id="notification-badge">0</span>
                @endif
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Close </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list" id="notification-list">
                        @forelse ($document_requests as $data)
                            <li class="notification-message">
                                <a href="{{ route('request.index') }}">
                                    <div class="media d-flex">
                                        <div class="media-body flex-grow-1">
                                            <p class="noti-details">
                                                <span class="noti-title">{{ $data->studentname }}</span>
                                                @if ($data->status == 'Pending')
                                                    has submitted a document request.
                                                @elseif ($data->status == 'Receipt Uploaded')
                                                    has uploaded a receipt for their request.
                                                @endif
                                            </p>
                                            <p class="noti-time">
                                                <span
                                                    class="notification-time">{{ $data->created_at->diffForHumans() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="notification-message" id="no-requests-message"
                                @if ($document_requests_count > 0) style="display: none;" @endif>
                                <a href="#">
                                    <div class="media d-flex">
                                        <div class="media-body flex-grow-1">
                                            <p class="noti-details">No new document requests.</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforelse

                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="{{ route('request.index') }}">View all requests</a>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle"
                        src="{{ Auth::user()->profile_picture ? asset('storage/registrar/profile/' . Auth::user()->profile_picture) : asset('registrar/assets/img/blank.png') }}"
                        width="31" alt="Profile">
                    <div class="user-text">
                        <h6>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h6>
                        <p class="text-muted mb-0">Registrar</p>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/registrar/profile/' . Auth::user()->profile_picture) : asset('registrar/assets/img/blank.png') }}"
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text">
                        <a href="{{ route('registrar-profile.index') }}" class="">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
                        <p class="text-muted mb-0">Registrar</p>
                    </div>

                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </a>
                </form>
            </div>
        </li>
    </ul>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    var pusher = new Pusher('302b9145ad49f3adcf60', {
        cluster: 'ap1',
        forceTLS: true
    });

    var channel = pusher.subscribe('document-channel');

    channel.bind('new-document', function(data) {
        console.log("📢 New Document Request:", data);

        var status = data.document.status;
        var student = data.document.studentname;

        var badge = document.getElementById('notification-badge');
        var currentCount = parseInt(badge.innerText) || 0;

        if (status === 'Pending' || status === 'Receipt Uploaded') {
            // Only add to list if it's a new request or receipt uploaded
            var notificationList = document.getElementById('notification-list');
            var newNotification = document.createElement('li');
            newNotification.classList.add('notification-message');

            newNotification.innerHTML = `
                <a href="{{ route('request.index') }}">
                    <div class="media d-flex">
                        <div class="media-body flex-grow-1">
                            <p class="noti-details">
                                <span class="noti-title">${student}</span>
                                ${status === 'Pending'
                                    ? 'has submitted a document request.'
                                    : 'has uploaded a receipt for their request.'}
                            </p>
                            <p class="noti-time">
                                <span class="notification-time">
                                    ${new Date(data.document.created_at).toLocaleString()}
                                </span>
                            </p>
                        </div>
                    </div>
                </a>`;

            notificationList.prepend(newNotification);

            // increase badge count
            badge.innerText = currentCount + 1;

            // hide "no requests" message
            var noRequestsMessage = document.getElementById('no-requests-message');
            if (noRequestsMessage) noRequestsMessage.style.display = 'none';

            // Toastr
            if (status === 'Pending') {
                toastr.info(`${student} has submitted a document request`, "New Request");
            } else {
                toastr.success(`${student} uploaded a receipt`, "Payment Update");
            }

        } else {
            //Only toast + decrease badge (don’t add list item)
            badge.innerText = Math.max(currentCount - 1, 0);

            toastr.warning(`${student}'s document is now "${status}"`, "Status Update");
        }
    });
</script>

