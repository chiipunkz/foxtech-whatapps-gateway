<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fwg_db_init(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $contacts = $wpdb->prefix . "fwg_contacts";
    $sql1 = "CREATE TABLE IF NOT EXISTS $contacts (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(200) NOT NULL,
        phone varchar(20) NOT NULL,
        email varchar(200),
        category varchar(100) DEFAULT 'All',
        PRIMARY KEY (id)
    ) $charset_collate;";

    $schedules = $wpdb->prefix . "fwg_schedules";
    $sql2 = "CREATE TABLE IF NOT EXISTS $schedules (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        message text NOT NULL,
        type varchar(20) NOT NULL,
        recipients text NOT NULL,
        schedule_time datetime NOT NULL,
        status varchar(20) DEFAULT 'pending',
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql1);
    dbDelta($sql2);
}
?>
