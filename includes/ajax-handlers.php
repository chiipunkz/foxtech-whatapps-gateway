<?php
if (! defined('ABSPATH')) exit;

function fwg_send_api($endpoint, $data)
{
    $url = "https://wanotif.foxtech.biz.id/" . $endpoint;
    $response = wp_remote_post($url, [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => wp_json_encode($data),
        'timeout' => 30
    ]);
    if (is_wp_error($response)) {
        return ['status' => false, 'msg' => $response->get_error_message()];
    }
    return json_decode(wp_remote_retrieve_body($response), true);
}