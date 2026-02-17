<?php

namespace App\Http\Controllers\Api;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
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
