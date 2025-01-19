{{-- <script>
    // Define routes object
    window.routes = {
        getAllSessions: "{{ route('conversations.whatsapp_history.getAllSessions') }}",
        getMessages: "{{ route('conversations.whatsapp_history.getMessages', ['phone' => ':phone']) }}",
        sendMessage: "{{ route('conversations.whatsapp_history.sendMessage') }}",
        editLead: "{{ route('leads.edit', ['_model' => ':id']) }}"

    };
    let isLoading = false; // Add this at the top of your script
    let lastScrollPosition = 0;
    let isFirstLoad = true;
</script>
<script>
    var chat = document.querySelector(".chat");
    var blockUI_chat = new KTBlockUI(chat, {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>',
    });

    $(document).ready(function() {
        let currentPhone = null; // Track current chat
        let isViewingSessions = true; // Track current view
        // Remove all existing ShowChatWhats click handlers to prevent duplicates
        $('.ShowChatWhats').off('click');

        // Rebind the click handler
        $(document).on('click', '.ShowChatWhats', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent immediate close

            var drawerElement = document.querySelector("#kt_drawer_chat");
            if (!drawerElement) {
                console.error('Chat drawer element not found');
                return;
            }

            var drawer = KTDrawer.getInstance(drawerElement);
            if (!drawer) {
                console.error('Chat drawer instance not found');
                return;
            }

            // Show drawer
            drawer.show();

            // Reset states
            isViewingSessions = true;
            currentPhone = null;

            // Load sessions
            loadChatSessions();
        });

        // Search functionality
        $(".searchWhatClick").on('click', function() {
            const searchQuery = $('.searchinputWhat').val();
            loadChatSessions(searchQuery);
        });

        // Clear search
        $(".searchWhatClose").on('click', function() {
            $('.searchinputWhat').val('');
            loadChatSessions();
        });

        // Handle message sending
        $('#sendMessageForm').on('submit', function(e) {
            e.preventDefault();

            const message = $('#messageInput').val().trim();
            if (!message) return;

            const phone = $('.chat-messages-container').data('current-phone');
            if (!phone) return;

            $.ajax({
                url: routes.sendMessage,
                type: 'POST',
                data: {
                    phone: phone,
                    message: message,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#messageInput').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        $('#messageInput').val('');
                        // Set isFirstLoad to true to force scroll on next message load
                        isFirstLoad = true;
                        // Reload messages to show the new message
                        loadChatMessages(phone);
                    }
                },
                error: function(xhr) {
                    console.error('Error sending message:', xhr);
                    // Show error toast or alert
                    toastr.error('Failed to send message. Please try again.');
                },
                complete: function() {
                    $('#messageInput').prop('disabled', false);
                    $('#messageInput').focus();
                }
            });
        });

        // Function to load chat sessions

        function loadChatSessions(search = '') {
            if (isLoading) return; // Prevent multiple simultaneous requests

            isLoading = true;
            blockUI_chat.block();

            $.ajax({
                url: search ? `${routes.getAllSessions}?search=${search}` : routes.getAllSessions,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderChatSessions(response.data);
                        updateUnreadCount(response.data);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading chat sessions:', xhr);
                },
                complete: function() {
                    isLoading = false;
                    blockUI_chat.release();
                }
            });
        }


        // Function to load chat messages
        function loadChatMessages(phone) {
            if (isLoading) return;

            isLoading = true;
            blockUI_chat.block();

            const url = routes.getMessages.replace(':phone', phone);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    renderChatMessages(response.messages, response.session);
                },
                error: function(xhr) {
                    console.error('Error loading messages:', xhr);
                    // Show error message and return to sessions
                    $('#backButton').click();
                },
                complete: function() {
                    isLoading = false;
                    blockUI_chat.release();
                }
            });
        }

        function formatLastMessage(message) {
            if (!message) return 'No messages';

            try {
                // If message has formatted_content, use it
                if (message.formatted_content) {
                    switch (message.type) {
                        case 'interactive_list':
                            return message.formatted_content.header?.text || 'قائمة المباني';

                        case 'interactive_pagination':
                            return 'عرض الشقق المتوفرة';

                        case 'interactive_apartment_list':
                            return `الشقق المتوفرة في ${message.formatted_content.header?.text || ''}`;

                        case 'confirmation':
                            return 'تأكيد الحجز';

                        case 'text':
                            return message.formatted_content.content;

                        default:
                            return message.formatted_content.content || 'Message';
                    }
                }

                // If it's a string, try to parse it
                if (typeof message.content === 'string') {
                    const content = JSON.parse(message.content);
                    if (content.header?.text) {
                        return content.header.text;
                    }
                    return content.body?.text || message.content;
                }

                return message.content || 'Message';
            } catch (e) {
                return message.content || 'Message';
            }
        }

        function renderChatSessions(sessions) {
            let html = '';
            sessions.forEach(session => {
                const formattedLastMessage = formatLastMessage(session.last_message);

                html += `
        <div class="d-flex flex-stack py-4 chat-session cursor-pointer" data-phone="${session.phone_number}">
            <div class="d-flex align-items-center">
                <div class="symbol symbol-45px symbol-circle">
                    <span class="symbol-label bg-light-primary text-primary fs-6 fw-bolder">
                        ${session.lead?.name?.charAt(0) || 'U'}
                    </span>
                    ${session.unread_messages > 0 ?
                        `<div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></div>`
                        : ''}
                </div>
                <div class="ms-5">
                    <div class="d-flex flex-column">
                        <a class="fs-5 fw-bolder text-gray-900 text-hover-primary">
                            ${session.lead?.name || 'Unknown'}
                            ${session.unread_messages > 0 ?
                                `<span class="badge badge-circle badge-primary">${session.unread_messages}</span>`
                                : ''}
                        </a>
                        <span class="text-gray-500 fs-7">${session.phone_number}</span>
                    </div>
                    <div class="fw-bold text-muted mt-1 text-truncate" style="max-width: 250px;">
                        ${formattedLastMessage}
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-end ms-2">
                <span class="text-muted fs-7 mb-1">${session.last_interaction || 'New'}</span>
            </div>
        </div>`;
            });

            $('.chat-sessions-list').html(html);
            $('.chat-messages-container').addClass('d-none');
            $('.chat-sessions-list').removeClass('d-none');
        }

        // Handle click on chat session
        $(document).on('click', '.chat-session', function() {
            const phone = $(this).data('phone');
            isFirstLoad = true; // Reset first load flag when opening new chat
            currentPhone = phone;
            isViewingSessions = false;
            loadChatMessages(phone);
            $('.chat-sessions-list').addClass('d-none');
            $('.chat-messages-container').removeClass('d-none');
        });


        // Handle back button click
        $(document).on('click', '#backButton', function() {
            $('.edit-lead-btn').addClass('d-none');

            isFirstLoad = true;

            $('#backButton').addClass('d-none');
            $('.sessions-view-elements').removeClass('d-none');
            $('.chat-messages-container').addClass('d-none');
            $('.chat-sessions-list').removeClass('d-none');
            loadChatSessions(); // Refresh sessions list
        });

        function renderChatMessages(messages, session) {
            // Update UI elements first
            const editLeadBtn = $('.edit-lead-btn');
            if (session.lead?.id) {
                const editUrl = window.routes.editLead.replace(':id', session.lead.id);
                editLeadBtn.removeClass('d-none').attr('href', editUrl);
            } else {
                editLeadBtn.addClass('d-none');
            }

            // Store current phone and show/hide elements
            $('.chat-messages-container').data('current-phone', session.phone_number);
            $('#backButton').removeClass('d-none');
            $('.sessions-view-elements').addClass('d-none');
            $('.chat-messages-container').removeClass('d-none');
            $('.chat-sessions-list').addClass('d-none');

            // Store scroll position
            lastScrollPosition = $('.chat-messages').scrollTop();

            let html = '';
            messages.forEach(message => {
                const isIncoming = message.direction === 'incoming';
                const content = formatMessageContent(message);
                const timestamp = moment(message.timestamp).fromNow();

                if (isIncoming) {
                    html += `
                <div class="message-incoming mb-5">
                    <div class="bg-light-info p-3 rounded w-fit-content">
                        ${content}
                    </div>
                    <div class="text-muted fs-7 mt-1">
                        ${timestamp}
                    </div>
                </div>
            `;
                } else {
                    html += `
                <div class="message-outgoing mb-5 d-flex flex-column align-items-end">
                    <div class="bg-light-primary p-3 rounded w-fit-content">
                        ${content}
                    </div>
                    <div class="text-muted fs-7 mt-1">
                        ${timestamp}
                    </div>
                </div>
            `;
                }
            });

            $('.chat-messages').html(html);

            // Handle scrolling
            if (isFirstLoad) {
                scrollToBottom();
                isFirstLoad = false;
            } else {
                const container = $('.chat-messages');
                const isScrolledToBottom = Math.abs((container[0].scrollHeight - container.scrollTop()) -
                    container.outerHeight()) < 50;

                if (isScrolledToBottom) {
                    scrollToBottom();
                } else {
                    container.scrollTop(lastScrollPosition);
                }
            }
        }

        function formatMessageContent(message) {
            if (typeof message.formatted_content === 'string') {
                return message.formatted_content;
            }

            switch (message.message_type) {
                case 'text':
                    const textContent = message.formatted_content;

                    if (textContent.type === 'confirmation_details') {
                        return `
            <div class="confirmation-message bg-light rounded p-3">
                <div class="header fw-bold mb-3">
                    ${textContent.header.text}
                </div>
                <div class="details">
                    <div class="fw-bold mb-2">${textContent.details.title}</div>
                    ${textContent.details.fields.map(field => `
                        <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">${field.label}:</span>
                            <span class="fw-semibold">${field.value}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="footer text-muted mt-3">
                    ${textContent.footer.text}
                </div>
            </div>`;
                    }

                    return textContent.content;
                case 'interactive':
                    const interactive = message.formatted_content;
                    console.log('interactive', interactive);

                    if (interactive?.type === 'list_reply') {
                        return `
            <div class="interactive-message">
                <strong>${interactive.title}</strong>
                ${interactive.description ?
                    `<div class="text-muted">${interactive.description}</div>`
                    : ''}
            </div>`;
                    } else if (interactive?.type === 'button_reply') {
                        return `
            <div class="interactive-button">
                ${interactive.title}
            </div>`;
                    }
                    break;
                case 'interactive_list':
                    const list = message.formatted_content; // Use formatted_content instead of content

                    return `
                    <div class="interactive-list">
                        ${list.header?.text ?
                            `<div class="list-header fw-bold mb-2">${list.header.text}</div>` : ''}
                        ${list.body?.text ?
                            `<div class="list-body mb-3">${list.body.text}</div>` : ''}
                        <div class="list-sections">
                            ${list.sections?.map(section => `
                                <div class="section mb-3">
                                    <div class="section-title fw-bold mb-2">${section.title}</div>
                                    ${section.rows?.map(row => `
                                        <div class="list-item p-2 border rounded mb-2">
                                            <div class="item-title fw-semibold">${row.title}</div>
                                            <div class="item-description text-muted">${row.description || ''}</div>
                                        </div>
                                    `).join('')}
                                </div>
                            `).join('')}
                        </div>
                        ${list.footer?.text ?
                            `<div class="list-footer text-muted mt-2">${list.footer.text}</div>` : ''}
                    </div>`;

                case 'interactive_pagination':
                    const pagination = message.formatted_content;
                    return `
        <div class="pagination-message">
            <div class="message-text mb-3 white-space-pre-line">${pagination.message}</div>
            <div class="buttons d-flex gap-2 mb-2">
                ${pagination.buttons?.map(button => `
                    <button class="btn btn-sm btn-light-primary" data-id="${button.reply.id}">
                        ${button.reply.title}
                    </button>
                `).join('')}
            </div>
            ${pagination.pagination ? `
                <div class="pagination-info text-muted small">
                    ${pagination.pagination.current_page} / ${pagination.pagination.total_pages}
                </div>
            ` : ''}
        </div>`;

                case 'interactive_apartment_list':
                    const apartments = message.formatted_content;
                    return `
        <div class="apartment-list bg-light p-3 rounded-3">
            ${apartments.header?.text ?
                `<div class="fw-bold fs-5 mb-2">${apartments.header.text}</div>` : ''}
            ${apartments.body?.text ?
                `<div class="mb-3">${apartments.body.text}</div>` : ''}

            ${apartments.sections?.map(section => `
                <div class="apartment-section mb-4">
                    <div class="section-title fw-bold mb-3 border-bottom pb-2">
                        ${section.title}
                    </div>
                    <div class="apartments-grid">
                        ${section.rows?.map(apartment => `
                            <div class="apartment-item p-3 border rounded-2 bg-white hover-shadow">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold fs-5">${apartment.title}</span>
                                </div>
                                <div class="text-muted small">
                                    ${apartment.description}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `).join('')}

            ${apartments.footer?.text ?
                `<div class="text-muted small mt-2 text-center">${apartments.footer.text}</div>` : ''}
        </div>`;

                case 'confirmation':
                    const confirmation = message.formatted_content;
                    return `
        <div class="confirmation-message bg-light rounded p-3">
            <div class="header mb-3 fw-bold">
                ${confirmation.header.text}
            </div>

            <div class="details">
                <div class="fw-bold mb-2">${confirmation.details.title}</div>
                ${confirmation.details.fields.map(field => `
                    <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">${field.label}:</span>
                        <span class="fw-semibold">${field.value}</span>
                    </div>
                `).join('')}
            </div>

            <div class="footer text-muted mt-3">
                ${confirmation.footer.text}
            </div>
        </div>`;
                default:
                    return message.content || 'Unsupported message type';
            }
        }

        function formatSections(sections) {
            if (!sections || !sections.length) return '';

            return sections.map(section => `
        <div class="section mb-3">
            ${section.title ? `<div class="fw-bold mb-1">${section.title}</div>` : ''}
            ${section.rows?.map(row => `
                <div class="row">
                    <div class="fw-semibold">${row.title}</div>
                    ${row.description ? `<div class="text-muted">${row.description}</div>` : ''}
                </div>
            `).join('') || ''}
        </div>
    `).join('');
        }
        // Back button handler
        $(document).on('click', '.back-to-sessions', function() {
            currentPhone = null;
            isViewingSessions = true;
            $('.chat-messages-container').addClass('d-none');
            $('.chat-sessions-list').removeClass('d-none');
            loadChatSessions();
        });

        // Add search handling
        $('.searchinputWhat').on('keyup', function() {
            const searchQuery = $(this).val();
            loadChatSessions(searchQuery);
        });

        function switchToSessions() {
            $('.back-to-sessions').addClass('d-none');
            $('.sessions-view-elements').removeClass('d-none');
            $('.chat-messages-container').addClass('d-none');
            $('.chat-sessions-list').removeClass('d-none');
        }
        // Function to update unread count badge
        function updateUnreadCount(sessions) {
            const totalUnread = sessions.reduce((sum, session) => sum + session.unread_messages, 0);
            if (totalUnread > 0) {
                $('#countWA').removeClass('d-none').text(totalUnread);
            } else {
                $('#countWA').addClass('d-none');
            }
        }

        // Function to scroll chat to bottom
        function scrollToBottom() {
            const container = $('.chat-messages');
            container.scrollTop(container[0].scrollHeight);
        }

        // Poll for new messages every 5 seconds
        // interval function to refresh appropriate view
        setInterval(function() {
            if (!isLoading) { // Only refresh if not already loading
                if ($('.chat-messages-container').hasClass('d-none')) {
                    loadChatSessions();
                } else {
                    const currentPhone = $('.chat-messages-container').data('current-phone');
                    if (currentPhone) {
                        loadChatMessages(currentPhone);
                    }
                }
            }
        }, 5000);
    });
</script> --}}
