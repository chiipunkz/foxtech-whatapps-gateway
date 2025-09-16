<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Load menu files
require_once FWG_PATH . 'includes/menu-api-settings.php';
require_once FWG_PATH . 'includes/menu-contacts.php';
require_once FWG_PATH . 'includes/menu-send-message.php';
require_once FWG_PATH . 'includes/menu-broadcast.php';
require_once FWG_PATH . 'includes/menu-schedule.php';
require_once FWG_PATH . 'includes/ajax-handlers.php';
require_once FWG_PATH . 'includes/cron-handler.php';

// Admin menu
add_action('admin_menu', function(){
    add_menu_page('Foxtech WhatsApp Gateway','WA Gateway','manage_options','fwg_api_settings','fwg_api_settings_page','dashicons-email-alt',56);
    add_submenu_page('fwg_api_settings','API Settings','API Settings','manage_options','fwg_api_settings','fwg_api_settings_page');
    add_submenu_page('fwg_api_settings','Alamat Kontak','Alamat Kontak','manage_options','fwg_contacts','fwg_contacts_page');
    add_submenu_page('fwg_api_settings','Kirim Pesan','Kirim Pesan','manage_options','fwg_send_message','fwg_send_message_page');
    add_submenu_page('fwg_api_settings','Kirim Broadcast','Kirim Broadcast','manage_options','fwg_broadcast','fwg_broadcast_page');
    add_submenu_page('fwg_api_settings','Kirim Schedule','Kirim Schedule','manage_options','fwg_schedule','fwg_schedule_page');
});
?>
