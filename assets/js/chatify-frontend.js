/** @format */

jQuery(document).ready(function ($) {
  let sessionId = null;

  console.log("Chatify loaded", chatify_ajax);

  $(".mala-trigger").on("click", function () {
    openChat();
  });

  // Send button functionality (since there's no separate send button, handle on Enter key only)

  $("#chatify-input").on("keypress", function (e) {
    if (e.which === 13) {
      sendMessage();
    }
  });

  function sendMessage() {
    const question = $("#chatify-input").val().trim();
    if (!question) return;

    console.log("Sending message:", question);
    console.log("REST URL:", chatify_ajax.rest_url);

    addMessage(question, "user");
    $("#chatify-input").val("");

    showTypingIndicator();

    $.ajax({
      url: chatify_ajax.rest_url,
      type: "POST",
      data: {
        question: question,
        session_id: sessionId,
      },
      beforeSend: function (xhr) {
        xhr.setRequestHeader("X-WP-Nonce", chatify_ajax.nonce);
      },
      success: function (response) {
        hideTypingIndicator();

        if (response.answer) {
          addMessage(response.answer, "bot");
          if (response.sessionId) {
            sessionId = response.sessionId;
          }
        } else {
          addMessage("Sorry, I encountered an error. Please try again.", "bot");
        }
      },
      error: function () {
        hideTypingIndicator();
        addMessage("Sorry, I encountered an error. Please try again.", "bot");
      },
    });
  }

  function addMessage(message, type) {
    // Convert newlines to <br> tags
    const formattedMessage = message.replace(/\n/g, "<br>");

    const alignment =
      type === "user" ? "text-align: right;" : "text-align: left;";
    const userStyle =
      type === "user" ? " padding: 8px 12px;  display: inline-block;" : "";

    $("#messages-container").append(`
            <div class="message mala" style="margin-bottom: 10px; ${alignment}">
                <div class="message-content" style="background: transparent; font-size: 12px; font-weight: normal; line-height: 1.4; color: rgb(255, 255, 255); width: 100%;">
                    <span style="${userStyle}">${formattedMessage}</span>
                </div>
            </div>
        `);
    scrollToBottom();
  }

  function showTypingIndicator() {
    $("#messages-container").append(`
            <div id="chatify-typing" class="message mala" style="margin-bottom: 10px; text-align: left;">
                <div class="message-content" style="background: transparent; font-size: 12px; font-weight: normal; line-height: 1.4; color: rgb(255, 255, 255); width: 100%;">
                    <div class="chatify-typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        `);
    scrollToBottom();
  }

  function hideTypingIndicator() {
    $("#chatify-typing").remove();
  }

  function scrollToBottom() {
    const messagesContainer = $("#messages-container");
    if (messagesContainer.length > 0 && messagesContainer[0]) {
      const element = messagesContainer[0];
      if (element.scrollHeight !== undefined) {
        element.scrollTop = element.scrollHeight;
      }
    }
  }
});
