<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SendMessage extends Component
{   
    public $user;
    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $createdMessage;
    protected $listeners = ['updateSendMessage', 'dispatchMessageSent', 'resetComponent'];

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
        $this->body = null; // Clear the message input box
    }

    public function updateSendMessage($conversationId, $receiverId)
    {
        $this->selectedConversation = Conversation::find($conversationId);
        $this->receiverInstance = User::find($receiverId);
    }

    public function sendMessage()
{
    // Check if the user follows the receiver and the receiver follows the user
    if (Auth::user()->follows($this->receiverInstance)) {
        if ($this->body == null) {
            return null;
        }

        $this->createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiverInstance->id,
            'body' => $this->body,
        ]);

        $this->selectedConversation->last_time_message = $this->createdMessage->created_at;
        $this->selectedConversation->save();
        $this->dispatch('pushMessage', $this->createdMessage->id);
        $this->dispatch('messageSent'); // Example of using emit
        $this->body = ''; // Clear the message input box
    } else {
        $this->dispatch('alertNoFollow'); // Notify the user they cannot send a message
        return 'null';    
    }
}


    public function dispatchMessageSent()
    {
        $user = Auth::user();
        if ($user instanceof User) {
            broadcast(new MessageSent($user, $this->createdMessage, $this->selectedConversation, $this->receiverInstance));
        }
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
