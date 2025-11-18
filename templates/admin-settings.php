<div class="wrap">
    <h1>WP-Chatify Settings</h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('chatify_settings'); ?>
        <?php do_settings_sections('chatify_settings'); ?>
        
        <h2 class="nav-tab-wrapper">
            <a href="#general" class="nav-tab nav-tab-active">General</a>
            <a href="#tuning" class="nav-tab">Agent Tuning</a>
            <a href="#appearance" class="nav-tab">Appearance</a>
            <a href="#advanced" class="nav-tab">Advanced</a>
        </h2>
        
        <div id="general" class="tab-content">
            <h3>General Settings</h3>
            <table class="form-table">
                <tr>
                    <th scope="row">Enable Chat Widget</th>
                    <td>
                        <input type="checkbox" name="chatify_enabled" value="1" <?php checked(1, get_option('chatify_enabled', 0)); ?> />
                        <label>Enable the chat widget on your website</label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Admin Only Mode</th>
                    <td>
                        <input type="checkbox" name="chatify_admin_only" value="1" <?php checked(1, get_option('chatify_admin_only', 0)); ?> />
                        <label>Show chat widget only to administrators (for testing)</label>
                        <p class="description">When enabled, only logged-in administrators can see the chat widget</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Domain Token</th>
                    <td>
                        <input type="text" name="chatify_domain_token" value="<?php echo esc_attr(get_option('chatify_domain_token')); ?>" class="regular-text" />
                        <p class="description">Enter your domain-specific token from the WP-Chatify system</p>
                        <button type="button" id="test-api-connection" class="button">Test API Connection</button>
                        <div id="api-test-result" style="margin-top: 10px;"></div>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Welcome Message</th>
                    <td>
                        <textarea name="chatify_welcome_message" rows="3" cols="50"><?php echo esc_textarea(get_option('chatify_welcome_message', 'Hello! How can I help you today?')); ?></textarea>
                        <p class="description">First message shown to users when they open the chat</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="tuning" class="tab-content" style="display: none;">
            <h3>Agent Tuning</h3>
            <p>Customize your AI agent's behavior and knowledge base.</p>
            
            <table class="form-table">
                <tr>
                    <th scope="row">Tuning Text</th>
                    <td>
                        <textarea id="tuning-text" rows="10" cols="80" placeholder="Enter your agent tuning instructions here..."></textarea>
                        <p class="description">Provide instructions to customize how your AI agent responds to users.</p>
                        <div id="tuning-status" style="margin-top: 10px;"></div>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Actions</th>
                    <td>
                        <button type="button" id="save-tuning" class="button button-primary">Save Tuning</button>
                        <button type="button" id="delete-tuning" class="button button-secondary">Delete Tuning</button>
                        <div id="tuning-result" style="margin-top: 10px;"></div>
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="appearance" class="tab-content" style="display: none;">
            <h3>Appearance Settings</h3>
            <table class="form-table">
                <tr>
                    <th scope="row">Widget Position</th>
                    <td>
                        <select name="chatify_widget_position">
                            <option value="bottom-right" <?php selected('bottom-right', get_option('chatify_widget_position', 'bottom-right')); ?>>Bottom Right</option>
                            <option value="bottom-left" <?php selected('bottom-left', get_option('chatify_widget_position')); ?>>Bottom Left</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Primary Color</th>
                    <td>
                        <input type="color" name="chatify_primary_color" value="<?php echo esc_attr(get_option('chatify_primary_color', '#007cba')); ?>" />
                        <p class="description">Main color for chat widget and buttons</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Secondary Color</th>
                    <td>
                        <input type="color" name="chatify_secondary_color" value="<?php echo esc_attr(get_option('chatify_secondary_color', '#f1f1f1')); ?>" />
                        <p class="description">Background color for bot messages</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Text Color</th>
                    <td>
                        <input type="color" name="chatify_text_color" value="<?php echo esc_attr(get_option('chatify_text_color', '#333333')); ?>" />
                        <p class="description">Text color for bot messages</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Widget Size</th>
                    <td>
                        <select name="chatify_widget_size">
                            <option value="small" <?php selected('small', get_option('chatify_widget_size', 'medium')); ?>>Small (300x400)</option>
                            <option value="medium" <?php selected('medium', get_option('chatify_widget_size', 'medium')); ?>>Medium (350x500)</option>
                            <option value="large" <?php selected('large', get_option('chatify_widget_size', 'medium')); ?>>Large (400x600)</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="advanced" class="tab-content" style="display: none;">
            <h3>Advanced Settings</h3>
            <table class="form-table">
                <tr>
                    <th scope="row">Show on Pages</th>
                    <td>
                        <label><input type="checkbox" name="chatify_show_homepage" value="1" <?php checked(1, get_option('chatify_show_homepage', 1)); ?> /> Homepage</label><br>
                        <label><input type="checkbox" name="chatify_show_posts" value="1" <?php checked(1, get_option('chatify_show_posts', 1)); ?> /> Blog Posts</label><br>
                        <label><input type="checkbox" name="chatify_show_pages" value="1" <?php checked(1, get_option('chatify_show_pages', 1)); ?> /> Pages</label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Auto Open</th>
                    <td>
                        <input type="checkbox" name="chatify_auto_open" value="1" <?php checked(1, get_option('chatify_auto_open', 0)); ?> />
                        <label>Automatically open chat widget after page load</label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Auto Open Delay</th>
                    <td>
                        <input type="number" name="chatify_auto_open_delay" value="<?php echo esc_attr(get_option('chatify_auto_open_delay', 3)); ?>" min="1" max="60" />
                        <label>seconds</label>
                        <p class="description">Delay before auto-opening (only if auto open is enabled)</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <?php submit_button(); ?>
    </form>
</div>
