<?php

namespace App\Jobs;

use App\Models\PushNotification;
use App\Models\Player;
use App\Tools\OneSignalService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userIds; // Array of recipient user ids
    protected $role;    // 'parent' or 'teacher'
    protected $title;
    protected $message;
    protected $url;
    protected $data;    // Extra JSON data

    /**
     * Create a new job instance.
     */
    public function __construct(array $userIds, string $role, string $title, string $message, string $url = null, array $data = [])
    {
        $this->userIds = $userIds;
        $this->role = $role;
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $oneSignal = new OneSignalService();
        
        foreach ($this->userIds as $userId) {
            if (!$userId) {
                continue;
            }

            // 1. Save to History
            try {
                PushNotification::create([
                    'user_id' => $userId,
                    'role'    => $this->role,
                    'title'   => $this->title,
                    'message' => $this->message,
                    'url'     => $this->url,
                    'data'    => $this->data,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to save push notification history', ['error' => $e->getMessage()]);
            }

            // 2. Send via OneSignal
            $playerIds = Player::where('user_id', $userId)
                ->where('role', $this->role)
                ->pluck('player_id')
                ->toArray();

            if (!empty($playerIds)) {
                try {
                    $oneSignal->sendToPlayers(
                        $playerIds,
                        $this->title,
                        $this->message,
                        $this->url,
                        $this->data
                    );
                } catch (\Exception $e) {
                    Log::error('OneSignal sending failed in Job', ['error' => $e->getMessage(), 'player_ids' => $playerIds]);
                }
            }
        }
    }
}
