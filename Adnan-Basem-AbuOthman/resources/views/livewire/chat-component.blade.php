

    <div style="height: 100%;">
        <div class="chat-component-wrapper">
            <div class="chat-header p-3 bg-white border-bottom shadow-sm flex-shrink-0 d-flex align-items-center">
                <a href="{{ route('messages.index') }}" class="btn btn-sm btn-light d-md-none me-2">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h6 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-person-circle me-2"></i>
                    {{ $conversation->receiver_id == auth()->id() ? $conversation->sender->name : $conversation->receiver->name }}
                </h6>
            </div>

            <div id="chatMessages">
                @foreach ($messages as $msg)
                    <div
                        class="message-wrapper {{ $msg->user_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                        <div class="message {{ $msg->user_id == auth()->id() ? 'sent' : 'received' }}">
                            <div class="message-content">{{ $msg->body }}</div>
                            <div class="message-meta text-end" style="font-size: 0.7rem; opacity: 0.7;">
                                {{ $msg->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="chat-input-area">
                <div class="input-group shadow-sm"
                    style="border-radius: 30px; overflow: hidden; border: 1px solid #ddd;">
                    <input type="text" wire:model="newMessage" wire:keydown.enter="sendMessage"
                        class="form-control border-0 py-2 px-3" placeholder="Type a message...">
                    <button wire:click="sendMessage" class="btn btn-primary border-0 px-4">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>


