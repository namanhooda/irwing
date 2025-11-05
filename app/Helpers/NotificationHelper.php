<?php

use App\Models\Notification;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getUserNotifications')) {
    function getUserNotifications($limit = 10)
    {
        if (!Auth::check()) {
            return collect(); // Return empty collection if user not authenticated
        }

        // Get the profile for the authenticated user
        $profile = Profile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return collect(); // Return empty collection if profile not found
        }

        // Fetch notifications for the user's profile
        return Notification::where('user_id', $profile->id)
            ->latest()
            ->take($limit)
            ->get();
    }

    function getUnreadNotificationCount()
    {
        if (!Auth::check()) {
            return 0;
        }

        $profile = Profile::where('user_id', Auth::id())->first();
        if (!$profile) {
            return 0;
        }

        return Notification::where('user_id', $profile->id)
            ->where('status', 'unread') // assuming you have a read_at column
            ->count();
    }
}
