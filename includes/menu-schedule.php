<?php
if (! defined('ABSPATH')) exit;

function fwg_schedule_page()
{
    global $wpdb;
    $table = $wpdb->prefix . "fwg_schedules";

    if (isset($_POST['fwg_add_schedule'])) {
        check_admin_referer('fwg_schedule');
        $wpdb->insert($table, [
            'message' => sanitize_textarea_field($_POST['message']),
            'type'    => 'text',
            'recipients' => sanitize_text_field($_POST['recipients']),
            'schedule_time' => sanitize_text_field($_POST['schedule_time']),
            'status'  => 'pending'
        ]);
        echo '<div class="updated"><p>Schedule saved.</p></div>';
    }

    $rows = $wpdb->get_results("SELECT * FROM $table ORDER BY schedule_time DESC");
?>
<div class="wrap">
    <h1>Schedule Messages</h1>
    <form method="post">
        <?php wp_nonce_field('fwg_schedule'); ?>
        <input type="text" name="recipients" placeholder="628xxxx,628xxxx" required>
        <textarea name="message" placeholder="Message" required></textarea>
        <input type="datetime-local" name="schedule_time" required>
        <p><input type="submit" name="fwg_add_schedule" class="button-primary" value="Save Schedule"></p>
    </form>

    <h2>Daftar Schedule</h2>
    <table class="widefat">
        <thead>
            <tr>
                <th>ID</th>
                <th>Recipients</th>
                <th>Message</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?php echo $r->id; ?></td>
                <td><?php echo esc_html($r->recipients); ?></td>
                <td><?php echo esc_html($r->message); ?></td>
                <td><?php echo esc_html($r->schedule_time); ?></td>
                <td><?php echo esc_html($r->status); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
}