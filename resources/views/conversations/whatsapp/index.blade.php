@extends('metronic.index')

@section('title', 'Whatsapp History')
@section('subpageTitle', 'Whatsapp History')

@push('styles')
    <style>
        .chat-message {
            max-width: 75%;
            margin-bottom: 1rem;
        }

        .chat-message.incoming {
            margin-right: auto;
        }

        .chat-message.outgoing {
            margin-left: auto;
        }

        .message-time {
            font-size: 0.8rem;
            color: #B5B5C3;
        }
    </style>


    <style>
        .chat-message {
            max-width: 75%;
            margin-bottom: 1rem;
        }

        .chat-message.incoming {
            margin-right: auto;
        }

        .chat-message.outgoing {
            margin-left: auto;
        }

        .message-time {
            font-size: 0.8rem;
            color: #B5B5C3;
        }

        .message-content {
            word-break: break-word;
        }

        .interactive-message .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            margin-bottom: 0.5rem;
        }

        .interactive-message .title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .interactive-message .description {
            font-size: 0.9rem;
            color: #7E8299;
        }
    </style>
    <style>
        .chat-message {
            max-width: 75%;
            margin-bottom: 1rem;
        }

        .chat-message.incoming {
            margin-right: auto;
        }

        .chat-message.outgoing {
            margin-left: auto;
        }

        .message-content {
            word-break: break-word;
            max-width: 600px;
        }

        .message-time {
            font-size: 0.8rem;
            color: #B5B5C3;
        }

        .badge {
            font-size: 0.75rem;
        }

        .text-wrap {
            white-space: pre-wrap;
        }

        .bg-light-primary {
            background-color: #f1faff !important;
        }

        .bg-light-info {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush



@section('content')
    <div class="d-flex flex-column flex-lg-row">
        <!-- Chat Sessions List -->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
            <div class="card card-flush">
                <!-- Search and Header -->
                <div class="card-header pt-7">
                    <div class="d-flex align-items-center">
                        <h3 class="fw-bolder text-gray-900">WhatsApp Chats</h3>
                    </div>
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <input type="text" class="form-control form-control-solid ps-13" id="kt_chat_search"
                            placeholder="Search by phone number...">
                    </div>
                </div>

                <!-- Chat Sessions List -->
                <div class="card-body" id="kt_chat_sessions">
                    @foreach ($chatSessions as $session)
                        <div class="d-flex flex-stack py-4 chat-session" data-phone="{{ $session->phone_number }}">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px symbol-circle">
                                    <span class="symbol-label bg-light-primary text-primary fs-6 fw-bolder">
                                        {{ substr($session->phone_number, -2) }}
                                    </span>
                                </div>
                                <div class="ms-5">
                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                        {{ $session->user_data['name'] ?? $session->phone_number }}
                                    </a>
                                    <div class="fw-semibold text-muted">
                                        {{ $session->current_state }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end">
                                <span class="text-muted fs-7 mb-1">
                                    {{ $session->last_interaction_at?->diffForHumans() }}
                                </span>
                                @if ($session->unread_count)
                                    <span class="badge badge-sm badge-circle badge-primary">
                                        {{ $session->unread_count }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
            <div class="card" id="kt_chat_messenger">
                <!-- Chat Header -->
                <div class="card-header" id="kt_chat_messenger_header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-45px symbol-circle">
                                <span class="symbol-label bg-light-primary text-primary fs-6 fw-bolder"
                                    id="chat_user_symbol"></span>
                            </div>
                            <div class="ms-3">
                                <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1"
                                    id="chat_user_name"></a>
                                <div class="fs-7 fw-semibold text-muted" id="chat_user_state"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="card-body" id="kt_chat_messenger_body">
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer"
                        data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">
                        <!-- Messages will be loaded here -->
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                    <div class="d-flex flex-stack">
                        <textarea class="form-control form-control-flush mb-3" rows="1" id="kt_chat_messenger_input"
                            placeholder="Type a message"></textarea>
                        <button class="btn btn-primary" type="button" id="kt_chat_messenger_send">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var currentPhone = null;

        // Initialize chat functionality
        var initChat = function() {
            // Handle chat session click
            document.querySelectorAll('.chat-session').forEach(function(element) {
                element.addEventListener('click', function() {
                    const phone = this.getAttribute('data-phone');
                    loadChat(phone);

                    // Update active session
                    document.querySelectorAll('.chat-session.active').forEach(el => el.classList.remove(
                        'active'));
                    this.classList.add('active');
                });
            });

            // Handle search
            const searchInput = document.querySelector('#kt_chat_search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('.chat-session').forEach(function(session) {
                        const phone = session.getAttribute('data-phone').toLowerCase();
                        const name = session.querySelector('.fs-5').textContent.toLowerCase();

                        if (phone.includes(searchTerm) || name.includes(searchTerm)) {
                            session.style.display = '';
                        } else {
                            session.style.display = 'none';
                        }
                    });
                });
            }

            // Handle send message
            const sendButton = document.querySelector('#kt_chat_messenger_send');
            const messageInput = document.querySelector('#kt_chat_messenger_input');

            if (sendButton && messageInput) {
                const sendMessage = () => {
                    const content = messageInput.value.trim();
                    if (!content || !currentPhone) return;

                    fetch("{{ route('conversations.whatsapp_history.sendMessage') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                phone: currentPhone,
                                message: content
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                messageInput.value = '';
                                loadChat(currentPhone);
                            }
                        });
                };

                sendButton.addEventListener('click', sendMessage);
                messageInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });
            }
        };
        var renderMessage = function(message) {
            console.log('Rendering message:', message);

            let content = '';

            try {
                // Parse raw_payload if it's a string
                if (message.raw_payload && typeof message.raw_payload === 'string') {
                    message.raw_payload = JSON.parse(message.raw_payload);
                }

                if (message.message_type === 'interactive' && message.raw_payload && message.raw_payload.interactive) {
                    const interactive = message.raw_payload.interactive;
                    console.log('Interactive message:', interactive);

                    if (interactive.type === 'list_reply') {
                        content = `
                    <div class="d-flex flex-column border rounded p-3 bg-light-primary">
                        <div class="mb-2">
                            <span class="badge badge-primary">Selection Made</span>
                        </div>
                        <div class="fw-bold mb-1">
                            ${interactive.list_reply.title}
                        </div>
                        <div class="text-muted">
                            ${interactive.list_reply.description || ''}
                        </div>
                    </div>
                `;
                    } else if (interactive.type === 'button_reply') {
                        content = `
                    <div class="d-flex flex-column border rounded p-3 bg-light-primary">
                        <div class="mb-2">
                            <span class="badge badge-primary">Button Selected</span>
                        </div>
                        <span class="fw-bold">${interactive.button_reply.title}</span>
                    </div>
                `;
                    }
                } else {
                    // Regular text message
                    content = `<div class="text-wrap">${message.content || 'No content'}</div>`;
                }

                return `
            <div class="chat-message ${message.direction}">
                <div class="d-flex flex-column align-items-${message.direction === 'outgoing' ? 'end' : 'start'} mb-5">
                    <div class="d-flex flex-row gap-2">
                        ${message.direction === 'outgoing' ? '' : `
                                            <div class="symbol symbol-35px symbol-circle">
                                                <span class="symbol-label bg-light-primary text-primary">B</span>
                                            </div>
                                        `}
                        <div class="message-content p-3 rounded bg-light-${message.direction === 'outgoing' ? 'primary' : 'info'}">
                            ${content}
                        </div>
                    </div>
                    <div class="message-time d-flex align-items-center ms-2 mt-1">
                        <small class="text-muted">
                            ${message.timestamp ? new Date(message.timestamp).toLocaleString() : 'No timestamp'}
                        </small>
                        ${message.direction === 'outgoing' ? `
                                            <span class="ms-2">
                                                ${getStatusIcon(message.status)}
                                            </span>
                                        ` : ''}
                    </div>
                </div>
            </div>
        `;
            } catch (error) {
                console.error('Error rendering message:', error, message);
                return `
            <div class="chat-message ${message.direction || 'incoming'}">
                <div class="message-content p-3 rounded bg-light-danger">
                    <span class="text-danger">Error displaying message</span>
                </div>
            </div>
        `;
            }
        };

        // Update loadChat function to include error handling
        var loadChat = function(phone) {
            currentPhone = phone;
            const route = `{{ route('conversations.whatsapp_history.getMessages', ['phone' => ':phone']) }}`
                .replace(':phone', phone);

            console.log('Loading chat for phone:', phone, 'Route:', route); // Debug log

            fetch(route)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data); // Debug log

                    // Update header
                    document.querySelector('#chat_user_symbol').textContent = phone.substr(-2);
                    document.querySelector('#chat_user_name').textContent = data.session.user_data?.name || phone;
                    document.querySelector('#chat_user_state').textContent = data.session.current_state;

                    // Update messages
                    const messagesContainer = document.querySelector('[data-kt-element="messages"]');
                    messagesContainer.innerHTML = '';

                    if (Array.isArray(data.messages)) {
                        data.messages.forEach(message => {
                            try {
                                const messageHtml = renderMessage(message);
                                messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                            } catch (error) {
                                console.error('Error processing message:', error, message);
                            }
                        });
                    } else {
                        console.error('Messages is not an array:', data.messages);
                    }

                    // Scroll to bottom
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(error => {
                    console.error('Error loading chat:', error);
                    // Show error to user
                    const messagesContainer = document.querySelector('[data-kt-element="messages"]');
                    messagesContainer.innerHTML = `
                <div class="alert alert-danger">
                    Error loading messages. Please try again.
                </div>
            `;
                });
        };

        // Get status icon for message
        var getStatusIcon = function(status) {
            switch (status) {
                case 'sent':
                    return '<i class="bi bi-check text-muted"></i>';
                case 'delivered':
                    return '<i class="bi bi-check-all text-muted"></i>';
                case 'read':
                    return '<i class="bi bi-check-all text-primary"></i>';
                default:
                    return '<i class="bi bi-clock text-muted"></i>';
            }
        };

        // Initialize on page load
        KTUtil.onDOMContentLoaded(function() {
            initChat();
        });
    </script>
@endpush
