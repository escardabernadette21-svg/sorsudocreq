<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class="{{ Route::is('dashboard.*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}" class="{{ Route::is('dashboard.*') ? 'active' : '' }}">
                        <i class="feather-grid"></i> <span> Dashboard</span>
                    </a>
                </li>
                <li class="submenu {{ Route::is('announcement.*') ? 'active' : '' }}">
                    <a href="{{ route('announcement.index') }}" class="{{ Route::is('announcement.*') ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i> <span> Announcement</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('announcement.index') }}"
                                class="{{ Route::is('announcement.*') ? 'active' : '' }}">Manage Announcement</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu {{ Route::is('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="{{ Route::is('users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> <span> Students</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="{{ Route::is('users.*') ? 'active' : '' }}">Manage Student</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu {{ Route::is('request.*') ? 'active' : '' }}">
                    <a href="{{ route('request.index') }}" class="{{ Route::is('request.*') ? 'active' : '' }}">
                        <i class="fas fa-solid fa-folder"></i> <span> Document Request</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('request.index') }}"
                                class="{{ Route::is('request.*') ? 'active' : '' }}">Manage Request</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu  {{ Route::is('payment.*') ? 'active' : '' }}">
                    <a href="{{ route('payment.index') }}" class="{{ Route::is('payment.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i> <span> Payment</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('payment.index') }}" class="{{ Route::is('payment.*') ? 'active' : '' }}">Manage Payment</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu  {{ Route::is('transactions.*') ? 'active' : '' }}">
                    <a href="{{ route('transactions.index') }}" class="{{ Route::is('transactions.*') ? 'active' : '' }}">
                       <i class="fas fa-history"></i> <span> Transaction History</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('transactions.index') }}" class="{{ Route::is('transactions.*') ? 'active' : '' }}">Manage History</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
