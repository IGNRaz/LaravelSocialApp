<?php
namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class CreateChat extends Component
{
    public $users;
    public $message = null; // Store the message input

    // This method checks and creates a conversation
    public function checkconversation($receiverId)
    {
        // Ensure message is provided
        if (empty($this->message)) {
            // You can either throw an error or do nothing if no message is provided
            return;
        }

        // Check if a conversation already exists between the current user and the receiver
        $checkConversation = Conversation::where('receiver_id', Auth::user()->id)
            ->where('sender_id', $receiverId)
            ->orWhere('receiver_id', $receiverId)
            ->where('sender_id', Auth::user()->id)
            ->get();

        if ($checkConversation->isEmpty()) {
            // Create a new conversation if none exists
            $createdConversation = Conversation::create([
                'receiver_id' => $receiverId,
                'sender_id' => Auth::user()->id,
                'last_time_message' => now()
            ]);

            // Create the first message for the new conversation
            $createdMessage = Message::create([
                'conversation_id' => $createdConversation->id,
                'sender_id' => Auth::user()->id,
                'receiver_id' => $receiverId,
                'body' => $this->message,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update the conversation's last message timestamp
            $createdConversation->last_time_message = $createdMessage->created_at;
            $createdConversation->save();
        } else {
            // If conversation exists, get the first one
            $existingConversation = $checkConversation->first();

            // Create a new message in the existing conversation
            $createdMessage = Message::create([
                'conversation_id' => $existingConversation->id,
                'sender_id' => Auth::user()->id,
                'receiver_id' => $receiverId,
                'body' => $this->message,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update the conversation's last message timestamp
            $existingConversation->last_time_message = $createdMessage->created_at;
            $existingConversation->save();
        }
    }

    // This method is triggered when a user is clicked
    public function handleUserClick($userId)
    {
        // Handle the logic when a user is clicked to start a chat
        $this->checkconversation($userId); // Call checkconversation to either start or continue chat
        
        // Redirect to the chat view with the user
        return redirect()->route('chat', ['userId' => $userId]);
    }

    // Render the view and pass the users list
    public function render()
    {
        // Get the list of users that the current user is following
        $this->users = User::whereHas('followers', function ($query) {
            $query->where('follower_id', Auth::user()->id);
        })->get();

        // Return the view with the users list
        return view('livewire.chat.create-chat');
    }
}
