<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoMessageSeeder extends Seeder
{
    public function run()
    {
        $messages = [
            [
                'sender_email' => 'alex@example.com',
                'receiver_email' => 'emma@example.com',
                'content' => 'Hi Emma, I saw your profile and your UI/UX skills. Would you be interested in collaborating on a new project?',
            ],
            [
                'sender_email' => 'emma@example.com',
                'receiver_email' => 'alex@example.com',
                'content' => 'Hi Alex! Thanks for reaching out. I\'d love to hear more about your project. What are you working on?',
            ],
            [
                'sender_email' => 'sarah@example.com',
                'receiver_email' => 'michael@example.com',
                'content' => 'Hello Michael, I\'m interested in mentoring some startups. Would you be open to connecting?',
            ],
            [
                'sender_email' => 'michael@example.com',
                'receiver_email' => 'sarah@example.com',
                'content' => 'Hi Sarah, absolutely! I have several startups in my network looking for mentorship in finance.',
            ],
            [
                'sender_email' => 'david@example.com',
                'receiver_email' => 'alex@example.com',
                'content' => 'Hey Alex, I saw your eco-friendly marketplace project. Very interesting! Let\'s discuss potential investment opportunities.',
            ],
        ];

        foreach ($messages as $message) {
            $sender = User::where('email', $message['sender_email'])->first();
            $receiver = User::where('email', $message['receiver_email'])->first();
            
            if ($sender && $receiver) {
                Message::create([
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'content' => $message['content'],
                    'read_at' => null,
                ]);
            }
        }
    }
} 