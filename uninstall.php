<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}fwg_contacts");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}fwg_schedules");
delete_option('fwg_api_key');
delete_option('fwg_sender');
?>
