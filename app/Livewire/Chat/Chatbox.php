<?php

namespace App\Livewire\Chat;

use App\Events\MessageRead;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chatbox extends Component
{
    public $selectedConversation;
    public $receiver;
    public $messages;
    public $paginateVar = 10;
    public $messages_count;
    public $receiverInstance;
    public $height;

    protected $listeners = [
        'loadConversation',
        'pushMessage',
        'loadmore',
        'updateHeight',
        'broadcastMessageRead',
        'resetComponent'
    ];

    public function getListeners()
    {
        $auth_id = Auth::id();

        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
        ] + $this->listeners;
    }

    public function resetComponent()
    {
        $this->receiverInstance = null;
        $this->selectedConversation = null;
        $this->messages = null;
    }

    public function broadcastedMessageRead($event)
    {
        if ($this->selectedConversation &&
            (int) $this->selectedConversation->id === (int) $event['conversation_id']
        ) {
            $this->dispatch('markMessageAsRead');
        }
    }

    public function broadcastedMessageReceived($event)
    {
        $this->dispatch('chat.chat-list', 'refresh');

        $broadcastedMessage = Message::find($event['message']);

        if ($this->selectedConversation &&
            (int) $this->selectedConversation->id === (int) $event['conversation_id']
        ) {
            $broadcastedMessage->read = 1;
            $broadcastedMessage->save();
            $this->pushMessage($broadcastedMessage->id);
            $this->dispatch('broadcastMessageRead');
        }
    }

    public function broadcastMessageRead()
    {
        if ($this->selectedConversation && $this->receiverInstance) {
            broadcast(new MessageRead($this->selectedConversation->id, $this->receiverInstance->id));
        }
    }

    public function pushMessage($messageId)
    {
        $newMessage = Message::find($messageId);

        if ($newMessage) {
            $this->messages->push($newMessage);
            $this->dispatch('rowChatToBottom');
        }
    }

    public function loadmore()
    {
        $this->paginateVar += 10;
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)
            ->get();

        $this->dispatch('updatedHeight', $this->height);
    }

    public function updateHeight($height)
    {
        $this->height = $height;
    }

    public function loadConversation($conversationId, $receiverId)
    {
        // Add debugging
        \Log::info('loadConversation parameters:', ['conversationId' => $conversationId, 'receiverId' => $receiverId]);
    
        $this->selectedConversation = Conversation::find($conversationId);
        $this->receiverInstance = User::find($receiverId);
        $this->receiver = $receiverId;
    
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
    
        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)
            ->get();
    
        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', Auth::id())
            ->update(['read' => 1]);
    
        $this->dispatch('broadcastMessageRead');
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
