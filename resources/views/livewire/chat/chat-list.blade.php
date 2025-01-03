<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="chatlist_header">
        <div class="title">
            Chat
        </div>

        <div class="img_container">
            <img src="{{ Auth::check() && Auth::user()->profile_picture ? Storage::url(Auth::user()->profile_picture) : 'https://via.placeholder.com/120' }}" alt="">
        </div>
    </div>

    <div class="chatlist_body">
        @if (count($conversations) > 0)
            @foreach ($conversations as $conversation)
                <div class="chatlist_item" wire:key='{{$conversation->id}}' wire:click="chatUserSelected({{$conversation->id}}, {{$this->getChatUserInstance($conversation, 'id')}})">
                    <div class="chatlist_img_container">
                        <img src="{{ $this->getChatUserInstance($conversation, 'profile_picture') ? Storage::url($this->getChatUserInstance($conversation, 'profile_picture')) : 'https://via.placeholder.com/120' }}" 
                            alt="">
                    </div>

                    <div class="chatlist_info">
                        <div class="top_row">
                            <div class="list_username">{{ $this->getChatUserInstance($conversation, 'name') }}</div>
                            <span class="date">
                                {{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}
                            </span>
                        </div>

                        <div class="bottom_row">
                            @if ($conversation->messages->isNotEmpty())
                                <div class="message_body text-truncate">
                                    {{ $conversation->messages->last()->body }}
                                </div>
                            @else
                                <div class="message_body text-truncate">
                                    No messages yet.
                                </div>
                            @endif

                            @php
                                $unreadCount = $conversation->messages->where('read', 0)->where('receiver_id', Auth::user()->id)->count();
                                if ($unreadCount > 0) {
                                    echo ' <div class="unread_count badge rounded-pill text-light bg-danger">  ' . $unreadCount . '</div> ';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            you have no conversations
        @endif
    </div>
</div>
