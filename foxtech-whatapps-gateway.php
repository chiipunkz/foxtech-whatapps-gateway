<?php
/*
Plugin Name: Foxtech WhatApps Gateway
Description: Integrasi API WhatsApp Gateway (wanotif.foxtech.biz.id) untuk WordPress. 
Version: 1.0
Author: Foxtech
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define('FWG_PATH', plugin_dir_path(__FILE__));
define('FWG_URL', plugin_dir_url(__FILE__));

// Load includes
require_once FWG_PATH . 'includes/index.php';

// Activation hook
register_activation_hook(__FILE__, 'fwg_activate');
function fwg_activate(){
    include FWG_PATH . 'includes/db-init.php';
    fwg_db_init();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'fwg_deactivate');
function fwg_deactivate(){
    wp_clear_scheduled_hook('fwg_process_scheduled_messages');
}

// Uninstall handled in uninstall.php
?>
