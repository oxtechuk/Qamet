<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('employee')->user();
        
        if ($request->has('only_count')) {
            return response()->json([
                'unread_count' => $user->unreadNotifications()->count()
            ]);
        }

        $notifications = $user->unreadNotifications()->latest()->limit(10)->get();
        
        $data = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? '',
                'message' => $notification->data['message'] ?? '',
                'url' => $notification->data['url'] ?? '#',
                'icon' => $notification->data['icon'] ?? 'bi-bell',
                'created_at' => $notification->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifications' => $data,
            'unread_count' => $user->unreadNotifications()->count()
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::guard('employee')->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::guard('employee')->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
