<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Communication;
use App\Models\CommunicationRead;
use Illuminate\Http\Request;

class CommunicationController extends Controller
{
    /**
     * Get all published communications
     */
    public function index(Request $request)
    {
        $communications = Communication::published()
            ->with('attachments')
            ->when($request->category, function ($query, $category) {
                $query->byCategory($category);
            })
            ->orderBy('published_at', 'DESC')
            ->get()
            ->map(function ($communication) use ($request) {
                $data = $communication->toArray();
                
                // Check if current user has read this communication
                if ($request->user()) {
                    $data['is_read'] = $request->user()->hasReadCommunication($communication->id);
                }
                
                return $data;
            });

        return response()->json([
            'success' => true,
            'data' => $communications
        ]);
    }

    /**
     * Get a single communication
     */
    public function show(Request $request, $id)
    {
        $communication = Communication::published()
            ->with('attachments')
            ->findOrFail($id);

        $data = $communication->toArray();
        
        // Check if current user has read this communication
        if ($request->user()) {
            $data['is_read'] = $request->user()->hasReadCommunication($communication->id);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Mark a communication as read
     */
    public function markAsRead(Request $request, $id)
    {
        $communication = Communication::published()->findOrFail($id);
        
        $parentUser = $request->user();

        // Check if already marked as read
        $existingRead = CommunicationRead::where('communication_id', $communication->id)
            ->where('parent_user_id', $parentUser->id)
            ->first();

        if (!$existingRead) {
            CommunicationRead::create([
                'communication_id' => $communication->id,
                'parent_user_id' => $parentUser->id,
                'read_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Comunicado marcado como leído'
        ]);
    }

    /**
     * Get read statistics for a communication (admin only)
     */
    public function readStats($id)
    {
        $communication = Communication::with('reads.parentUser.padre')->findOrFail($id);

        $stats = [
            'total_reads' => $communication->reads->count(),
            'reads' => $communication->reads->map(function ($read) {
                return [
                    'parent_name' => $read->parentUser->padre->nombres ?? 'N/A',
                    'read_at' => $read->read_at->format('Y-m-d H:i:s'),
                ];
            })
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
