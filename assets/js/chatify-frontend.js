jQuery(document).ready(function($) {
    let sessionId = null;
    
    console.log('Chatify loaded', chatify_ajax);
    
    $('#chatify-toggle').on('click', function() {
        $('#chatify-window').toggle();
        if ($('#chatify-window').is(':visible')) {
            $('#chatify-input').focus();
        }
    });
    
    $('#chatify-close').on('click', function() {
        $('#chatify-window').hide();
    });
    
    $('#chatify-send').on('click', function() {
        sendMessage();
    });
    
    $('#chatify-input').on('keypress', function(e) {
        if (e.which === 13) {
            sendMessage();
        }
    });
    
    function sendMessage() {
        const question = $('#chatify-input').val().trim();
        if (!question) return;
        
        console.log('Sending message:', question);
        console.log('AJAX URL:', chatify_ajax.ajax_url);
        
        addMessage(question, 'user');
        $('#chatify-input').val('');
        
        showTypingIndicator();
        
        $.ajax({
            url: chatify_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'chatify_send_message',
                question: question,
                session_id: sessionId,
                nonce: chatify_ajax.nonce
            },
            success: function(response) {
                hideTypingIndicator();
                
                if (response.success) {
                    addMessage(response.data.answer, 'bot');
                    sessionId = response.data.sessionId;
                } else {
                    addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                }
            },
            error: function() {
                hideTypingIndicator();
                addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            }
        });
    }
    
    function addMessage(message, type) {
        // Convert newlines to <br> tags
        const formattedMessage = message.replace(/\n/g, '<br>');
        
        const messageHtml = `
            <div class="chatify-message chatify-${type}-message">
                <div class="chatify-message-content">${formattedMessage}</div>
            </div>
        `;
        $('#chatify-messages').append(messageHtml);
        scrollToBottom();
    }
    
    function showTypingIndicator() {
        const typingHtml = `
            <div id="chatify-typing" class="chatify-message chatify-bot-message">
                <div class="chatify-message-content">
                    <div class="chatify-typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        `;
        $('#chatify-messages').append(typingHtml);
        scrollToBottom();
    }
    
    function hideTypingIndicator() {
        $('#chatify-typing').remove();
    }
    
    function scrollToBottom() {
        const messages = $('#chatify-messages');
        messages.scrollTop(messages[0].scrollHeight);
    }
});
