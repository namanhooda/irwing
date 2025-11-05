<li class="nav-item navbar-dropdown dropdown-user dropdown">
    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="{{asset('backend/assets/img/avatars/1.png')}}" alt class="rounded-circle" />
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar avatar-online">
                            <img src="{{asset('backend/assets/img/avatars/1.png')}}" alt class="rounded-circle" />
                        </div>
                    </div>
                    @auth
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <small class="text-body-secondary">
                            @php
                                $activeRole = session('active_role') ?? auth()->user()->getRoleNames()->first();
                            @endphp
                            {{ $activeRole ? 'Active Role: ' . ucfirst($activeRole) : 'No role assigned' }}
                        </small>
                    </div>
                    @endauth
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown-divider my-1 mx-n2"></div>
        </li>
        <li>
            <a class="dropdown-item" href="pages-profile-user.html">
                <i class="icon-base ti tabler-user me-3 icon-md"></i><span class="align-middle">My
                    Profile</span>
            </a>
        </li>
        <!-- <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                            <i class="icon-base ti tabler-settings me-3 icon-md"></i><span
                                class="align-middle">Settings</span>
                        </a>
                    </li> -->
        <li>
            <div class="d-grid px-2 pt-2 pb-1">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center">
                        <small class="align-middle">Log Out</small>
                        <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                    </button>
                </form>
            </div>
        </li>
    </ul>
</li>
