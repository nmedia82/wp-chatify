jQuery(document).ready(function($) {
    // Tab switching
    $('.nav-tab').on('click', function(e) {
        e.preventDefault();
        
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        
        $('.tab-content').hide();
        $($(this).attr('href')).show();
        
        // Auto-load tuning when tuning tab is clicked
        if ($(this).attr('href') === '#tuning' && !$('#tuning-text').data('loaded')) {
            loadTuning();
        }
    });
    
    // Auto-load tuning function
    function loadTuning() {
        const status = $('#tuning-status');
        status.html('<div style="color: #666;">Loading current tuning...</div>');
        
        $.ajax({
            url: chatify_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'chatify_load_tuning',
                nonce: chatify_admin_ajax.nonce
            },
            success: function(response) {
                if (response.error) {
                    status.html('<div style="color: #666;">No existing tuning found</div>');
                } else {
                    // Unescape the text when loading
                    const unescapedText = (response.tuningText || '').replace(/\\'/g, "'").replace(/\\"/g, '"');
                    $('#tuning-text').val(unescapedText);
                    status.html('<div style="color: green;">Current tuning loaded</div>');
                }
                $('#tuning-text').data('loaded', true);
            },
            error: function() {
                status.html('<div style="color: #666;">No existing tuning found</div>');
                $('#tuning-text').data('loaded', true);
            }
        });
    }
    
    // API test button
    $('#test-api-connection').on('click', function() {
        const button = $(this);
        const result = $('#api-test-result');
        
        button.prop('disabled', true).text('Testing...');
        result.html('');
        
        $.ajax({
            url: chatify_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'chatify_test_api',
                nonce: chatify_admin_ajax.nonce
            },
            success: function(response) {
                if (response.error) {
                    result.html('<div style="color: red;">Error: ' + response.error + '</div>');
                } else {
                    result.html('<div style="color: green;">Success! API is working correctly.</div>');
                }
            },
            error: function() {
                result.html('<div style="color: red;">Connection failed</div>');
            },
            complete: function() {
                button.prop('disabled', false).text('Test API Connection');
            }
        });
    });
    
    // Save tuning
    $('#save-tuning').on('click', function() {
        const button = $(this);
        const result = $('#tuning-result');
        const tuningText = $('#tuning-text').val();
        
        if (!tuningText.trim()) {
            result.html('<div style="color: red;">Please enter tuning text</div>');
            return;
        }
        
        button.prop('disabled', true).text('Saving...');
        
        $.ajax({
            url: chatify_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'chatify_save_tuning',
                tuning_text: tuningText,
                nonce: chatify_admin_ajax.nonce
            },
            success: function(response) {
                if (response.error) {
                    result.html('<div style="color: red;">Error: ' + response.error + '</div>');
                } else {
                    result.html('<div style="color: green;">Tuning saved successfully</div>');
                }
            },
            error: function() {
                result.html('<div style="color: red;">Failed to save tuning</div>');
            },
            complete: function() {
                button.prop('disabled', false).text('Save Tuning');
            }
        });
    });
    
    // Delete tuning
    $('#delete-tuning').on('click', function() {
        if (!confirm('Are you sure you want to delete the current tuning?')) {
            return;
        }
        
        const button = $(this);
        const result = $('#tuning-result');
        
        button.prop('disabled', true).text('Deleting...');
        
        $.ajax({
            url: chatify_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'chatify_delete_tuning',
                nonce: chatify_admin_ajax.nonce
            },
            success: function(response) {
                if (response.error) {
                    result.html('<div style="color: red;">Error: ' + response.error + '</div>');
                } else {
                    $('#tuning-text').val('');
                    result.html('<div style="color: green;">Tuning deleted successfully</div>');
                }
            },
            error: function() {
                result.html('<div style="color: red;">Failed to delete tuning</div>');
            },
            complete: function() {
                button.prop('disabled', false).text('Delete Tuning');
            }
        });
    });
});
