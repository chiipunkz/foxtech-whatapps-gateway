<?php
if (! defined('ABSPATH')) exit;

add_action('fwg_process_scheduled_messages', 'fwg_process_scheduled_messages_fn');
if (! wp_next_scheduled('fwg_process_scheduled_messages')) {
    wp_schedule_event(time(), 'minute', 'fwg_process_scheduled_messages');
}

// Register "minute" interval
add_filter('cron_schedules', function ($schedules) {
    $schedules['minute'] = ['interval' => 60, 'display' => 'Every Minute'];
    return $schedules;
});

function fwg_process_scheduled_messages_fn()
{
    global $wpdb;
    $table = $wpdb->prefix . "fwg_schedules";
    $api_key = get_option('fwg_api_key');
    $sender  = get_option('fwg_sender');

    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table WHERE status='pending' AND schedule_time <= %s",
        current_time('mysql')
    ));
    foreach ($rows as $r) {
        $numbers = explode(',', $r->recipients);
        foreach ($numbers as $n) {
            fwg_send_api('send-message', [
                'api_key' => $api_key,
                'sender' => $sender,
                'number' => trim($n),
                'message' => $r->message,
                'footer' => 'Sent via Foxtech'
            ]);
        }
        $wpdb->update($table, ['status' => 'sent'], ['id' => $r->id]);
    }
}