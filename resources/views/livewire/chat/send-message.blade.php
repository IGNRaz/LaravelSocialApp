<div>
    {{-- The whole world belongs to you. --}}

    @if ($selectedConversation)
        
        <form wire:submit.prevent='sendMessage' action="">
            <div class="chatbox_footer">
                <div class="custom_form_group">
                    <input wire:model='body' type="text" id="sendMessage" class="control" placeholder="Write message">
                    <button type="submit" class="submit">Send</button>
                </div>
            </div>  
        </form>

    @endif

    <script>
        document.addEventListener('livewire:load', function () {
            @this.on('alertNoFollow', () => {
                alert('You cannot send a message because you do not follow this user.');
            });

            @this.on('messageSent', () => {
                document.getElementById('sendMessage').value = '';
            });
        });
    </script>
</div>