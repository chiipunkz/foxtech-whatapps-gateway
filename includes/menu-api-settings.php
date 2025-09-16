<?php
if (! defined('ABSPATH')) exit;

function fwg_api_settings_page()
{
    if (isset($_POST['fwg_save_settings'])) {
        check_admin_referer('fwg_api_settings');
        update_option('fwg_api_key', sanitize_text_field($_POST['fwg_api_key']));
        update_option('fwg_sender', sanitize_text_field($_POST['fwg_sender']));
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    $api_key = get_option('fwg_api_key', '');
    $sender  = get_option('fwg_sender', '');
?>
<div class="wrap">
    <h1>Foxtech WhatsApp API Settings</h1>
    <form method="post">
        <?php wp_nonce_field('fwg_api_settings'); ?>
        <table class="form-table">
            <tr>
                <th><label for="fwg_api_key">API Key</label></th>
                <td><input type="text" name="fwg_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text"
                        required></td>
            </tr>
            <tr>
                <th><label for="fwg_sender">Sender Number</label></th>
                <td><input type="text" name="fwg_sender" value="<?php echo esc_attr($sender); ?>" class="regular-text"
                        required></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="fwg_save_settings" class="button-primary" value="Save Settings">
        </p>
    </form>
</div>
<?php
}