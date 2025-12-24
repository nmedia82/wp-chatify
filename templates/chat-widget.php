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

.chatify-typing-dots {
    display: flex;
    gap: 4px;
}

.chatify-typing-dots span {
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out;
}

.chatify-typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.chatify-typing-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}
</style>

<div class="mala-agent" style="position: fixed; bottom: 0px; right: 20px; z-index: 10000;">
    <div class="mala-trigger" onclick="openChat()">
        <img src="<?php echo CHATIFY_PLUGIN_URL; ?>assets/images/zamedia-agent-mala.png" alt="Chat Agent" class="mala-avatar" style="object-fit: contain; width: 150px; cursor: pointer;">
    </div>
    
    <div id="mala-avatar" style="display: none;">
        <img src="<?php echo CHATIFY_PLUGIN_URL; ?>assets/images/MALA.png" alt="MALA" class="mala-avatar" style="object-fit: contain; width: 450px; height: 450px; z-index: 9999; position: relative; " >
    </div>
    
    <div class="mala-messages" id="mala-messages" style="display: none; position: absolute; bottom: 320px; right: 280px !important; width: auto !important; height: 400px !important; background: url('<?php echo CHATIFY_PLUGIN_URL; ?>assets/images/mala-bubble.png') center center / 450px 350px no-repeat; padding: 75px 40px 60px; flex-direction: column; justify-content: flex-start; overflow-y: auto; z-index: 9999;">
        <div style="position: absolute; top: 41px; right: 39px; cursor: pointer; z-index: 10; font-size: 31px; color: white; font-weight: bold;" onclick="closeChat()">
            ×
        </div>
        <div id="messages-container" style="flex: 1 1 0%; overflow-y: auto; max-height: 150px;">
            <div class="message mala" style="margin-bottom: 10px;">
                <div class="message-content" style="background: transparent; font-size: 12px; font-weight: normal; line-height: 1.4; color: rgb(255, 255, 255); width: 80%;">
                    Hey, I'm MALA. Part of the za:media family.<br><br>I can help you learn more about Ethno Marketing and how we connect brands with real people and cultures across Europe and the UK. Wondering how culture and creativity work together? Just ask me about our campaigns, events, or the brands we team up with.<br><br>Explore za:media's work with me.
                </div>
            </div>
        </div>
        <div style="margin-top: 50px; width: 370px;">
            <input placeholder="Ask MALA..." type="text" class="white-placeholder form-control" id="chatify-input" style="font-size: 11px; min-height: 30px; max-height: 30px; resize: none; background-color: rgb(243, 146, 36); border-top: 2px solid white; border-right: none; border-bottom: none; border-left: none; border-radius: 0px; padding: 5px 10px; width: 370px; box-sizing: border-box; color: rgb(255, 255, 255); outline: none;">
<style>
#chatify-input::placeholder {
    color: white !important;
    opacity: 1;
}
</style>
        </div>
    </div>
</div>

<div id="mala-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 99999; cursor: pointer;" onclick="hideMalaImage()">
    <img src="<?php echo CHATIFY_PLUGIN_URL; ?>assets/images/MALA.png" alt="Mala" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;" />
</div>

<script>
function openChat() {
    document.querySelector('.mala-trigger').style.display = 'none';
    document.getElementById('mala-avatar').style.display = 'block';
    setTimeout(() => {
        document.getElementById('mala-messages').style.display = 'flex';
    }, 500);
}

function closeChat() {
    document.getElementById('mala-messages').style.display = 'none';
    document.getElementById('mala-avatar').style.display = 'none';
    document.querySelector('.mala-trigger').style.display = 'block';
}

function showMalaImage() {
    document.getElementById('mala-overlay').style.display = 'block';
}

function hideMalaImage() {
    document.getElementById('mala-overlay').style.display = 'none';
}
</script>
