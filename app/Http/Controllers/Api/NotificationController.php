<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Models\Player;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notification history for the current user.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $request->role ?? ($user->padre ? 'parent' : 'teacher');

        $notifications = PushNotification::where('user_id', $user->id)
            ->where('role', $role)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read (optional logic, but good for UX).
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = PushNotification::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for the current user and role.
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        $role = $request->role ?? ($user->padre ? 'parent' : 'teacher');

        PushNotification::where('user_id', $user->id)
            ->where('role', $role)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Subscribe to push notifications (save player_id).
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'player_id' => 'required|string',
            'role' => 'required|in:parent,teacher',
            'user_id' => 'required|integer',
        ]);

        $player = Player::updateOrCreate(
            [
                'player_id' => $request->player_id,
                'role' => $request->role,
                'user_id' => $request->user()->id,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Suscripción guardada correctamente',
            'data' => $player
        ]);
    }
}
