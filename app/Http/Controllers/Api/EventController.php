<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Get events for the current month
     */
    public function index(Request $request)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $events = Event::with('creator')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        $data = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'date' => $event->date->format('Y-m-d'),
                'time' => $event->time->format('H:i'),
                'description' => $event->description,
                'type' => $event->type,
                'link' => $event->link,
                'attachment' => $event->attachment ? url($event->attachment) : null,
                'createdBy' => $event->creator->name ?? 'Admin',
                'createdAt' => $event->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
