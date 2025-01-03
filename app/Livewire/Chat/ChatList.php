<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;

    // Listeners for emitting and handling events in the component
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh', 'resetComponent'];

    // Reset component to clear selected conversation and receiver instance
    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
    }

    // Handle chat user selection
    public function chatUserSelected($conversationId, $receiverId)
    {
        // Set the selected conversation and receiver instance
        $this->selectedConversation = Conversation::find($conversationId);
        $this->receiverInstance = User::find($receiverId);

        // Emit data to other components (chatbox and send-message components)
        $this->dispatch('loadConversation', $this->selectedConversation->id, $this->receiverInstance->id);
        $this->dispatch('updateSendMessage', $this->selectedConversation->id, $this->receiverInstance->id);
    }

    // Get receiver instance based on the conversation details
    public function getChatUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = Auth::id();
        
        // Determine the receiver based on the conversation
        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::find($conversation->receiver_id);
        } else {
            $this->receiverInstance = User::find($conversation->sender_id);
        }

        // Return the requested field from receiverInstance if available
        if (isset($request)) {
            return $this->receiverInstance ? $this->receiverInstance->$request : null;
        }

        return null;  // Return null if $request is not provided
    }

    // Mount the component (initial load)
    public function mount()
    {
        $this->auth_id = Auth::id();
        $this->conversations = Conversation::where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)
            ->orderBy('last_time_message', 'DESC')
            ->get();
    }

    // Render the Livewire view
    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
