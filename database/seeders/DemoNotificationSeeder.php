<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Support\Str;

class DemoNotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            // Create a test notification
            $user->notifications()->create([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\TestNotification',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $user->id,
                'data' => [
                    'message' => 'Welcome to the platform! This is a test notification.',
                    'action_url' => '/dashboard',
                    'action_text' => 'View Dashboard'
                ],
                'read_at' => null
            ]);
        }
    }
} 