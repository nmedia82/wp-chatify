<?php
$primary_color = get_option('chatify_primary_color', '#007cba');
$secondary_color = get_option('chatify_secondary_color', '#f1f1f1');
$text_color = get_option('chatify_text_color', '#333333');
$widget_size = get_option('chatify_widget_size', 'medium');
?>

<style>
:root {
    --chatify-primary: <?php echo esc_attr($primary_color); ?>;
    --chatify-secondary: <?php echo esc_attr($secondary_color); ?>;
    --chatify-text: <?php echo esc_attr($text_color); ?>;
}
</style>

<div id="chatify-widget" class="chatify-widget chatify-position-<?php echo esc_attr(get_option('chatify_widget_position', 'bottom-right')); ?> chatify-size-<?php echo esc_attr($widget_size); ?>">
    <div id="chatify-toggle" class="chatify-toggle">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" fill="currentColor"/>
        </svg>
    </div>
    
    <div id="chatify-window" class="chatify-window" style="display: none;">
        <div class="chatify-header">
            <h3>Chat with us</h3>
            <button id="chatify-close" class="chatify-close">&times;</button>
        </div>
        
        <div id="chatify-messages" class="chatify-messages">
            <div class="chatify-message chatify-bot-message">
                <div class="chatify-message-content">
                    <?php echo nl2br(esc_html(get_option('chatify_welcome_message', 'Hello! How can I help you today?'))); ?>
                </div>
            </div>
        </div>
        
        <div class="chatify-input-container">
            <input type="text" id="chatify-input" placeholder="Type your message..." />
            <button id="chatify-send">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 21L23 12L2 3V10L17 12L2 14V21Z" fill="currentColor"/>
                </svg>
            </button>
        </div>
    </div>
</div>
