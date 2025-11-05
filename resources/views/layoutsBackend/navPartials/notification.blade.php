        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
            <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
   href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
   <span class="position-relative">
       <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
       <!-- Unread notifications count badge -->
       <span class="badge rounded-pill bg-danger badge-notifications border" 
             style="position: absolute; top: 0; right: 0; font-size: 10px; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
           {{ getUnreadNotificationCount() }}
       </span>
   </span>
</a>

            <ul class="dropdown-menu dropdown-menu-end p-0">
                <li class="dropdown-menu-header border-bottom">
            <div class="dropdown-header d-flex align-items-center py-3">
                <h6 class="mb-0 me-auto">Notification</h6>
                <div class="d-flex align-items-center h6 mb-0">
                    <!-- Show unread count instead of "New" -->
                    <span class="badge bg-label-primary me-2">{{ getUnreadNotificationCount() }}</span>
                    <a href="javascript:void(0)" class="dropdown-notifications-all p-2 btn btn-icon"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read">
                    </a>
                </div>
            </div>
        </li>

        <li class="dropdown-notifications-list scrollable-container">
            <ul class="list-group list-group-flush">
                @forelse(getUserNotifications() as $notification)
                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <!-- <div class="avatar">
                                <img src="{{ asset('backend/assets/img/avatars/1.png') }}" alt="avatar"
                                    class="rounded-circle" />
                            </div> -->
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="small mb-1">{{ $notification->message }}</h6>
                            <small class="mb-1 d-block text-body">
                                <a href="{{ url($notification->url) }}">View Details</a>
                            </small>
                            <small class="text-body-secondary">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="flex-shrink-0 dropdown-notifications-actions">
                            @if($notification->status == 'unread')
                            <span class="badge badge-dot bg-primary"></span>
                            @endif
                        </div>
                    </div>
                </li>
                @empty
                <li class="list-group-item text-center">No notifications found.</li>
                @endforelse
            </ul>
        </li>

        <li class="border-top">
            <div class="d-grid p-4">
                <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                    <small class="align-middle">View all notifications</small>
                </a>
            </div>
        </li>
    </ul>
</li>
