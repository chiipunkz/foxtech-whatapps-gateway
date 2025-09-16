<?php
if (! defined('ABSPATH')) exit;

function fwg_broadcast_page()
{
    global $wpdb;
    $table = $wpdb->prefix . "fwg_contacts";
    $api_key = get_option('fwg_api_key');
    $sender  = get_option('fwg_sender');

    if (isset($_POST['fwg_broadcast'])) {
        $category = sanitize_text_field($_POST['category']);
        $message  = sanitize_textarea_field($_POST['message']);

        $contacts = ($category === 'All')
            ? $wpdb->get_results("SELECT phone FROM $table")
            : $wpdb->get_results($wpdb->prepare("SELECT phone FROM $table WHERE category=%s", $category));

        foreach ($contacts as $c) {
            fwg_send_api('send-message', [
                'api_key' => $api_key,
                'sender' => $sender,
                'number' => $c->phone,
                'message' => $message,
                'footer' => 'Sent via Foxtech'
            ]);
        }
        echo '<div class="updated"><p>Broadcast sent to ' . count($contacts) . ' contacts.</p></div>';
    }

    $cats = $wpdb->get_col("SELECT DISTINCT category FROM $table");
?>
<div class="wrap">
    <h1>Kirim Broadcast</h1>
    <form method="post">
        <select name="category">
            <option value="All">All</option>
            <?php foreach ($cats as $c) {
                    echo '<option value="' . esc_attr($c) . '">' . esc_html($c) . '</option>';
                } ?>
        </select>
        <textarea name="message" placeholder="Message" required></textarea>
        <p><input type="submit" name="fwg_broadcast" class="button-primary" value="Kirim Broadcast"></p>
    </form>
</div>
<?php
}