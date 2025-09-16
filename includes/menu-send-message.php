<?php
if (! defined('ABSPATH')) exit;

function fwg_send_message_page()
{
    $api_key = get_option('fwg_api_key');
    $sender  = get_option('fwg_sender');

    // proses kirim
    if ($_POST) {
        if ($_POST['message_type'] === 'text' && isset($_POST['fwg_send'])) {
            $resp = fwg_send_api('send-message', [
                'api_key' => $api_key,
                'sender' => $sender,
                'number' => sanitize_text_field($_POST['number']),
                'message' => sanitize_textarea_field($_POST['message']),
                'footer' => sanitize_text_field($_POST['footer']),
            ]);
            echo '<div class="updated"><p>' . esc_html($resp['msg']) . '</p></div>';
        }
        if ($_POST['message_type'] === 'media' && isset($_POST['fwg_send'])) {
            $resp = fwg_send_api('send-media', [
                'api_key' => $api_key,
                'sender' => $sender,
                'number' => sanitize_text_field($_POST['number']),
                'media_type' => sanitize_text_field($_POST['media_type']),
                'caption' => sanitize_textarea_field($_POST['caption']),
                'footer' => sanitize_text_field($_POST['footer']),
                'url' => esc_url_raw($_POST['url'])
            ]);
            echo '<div class="updated"><p>' . esc_html($resp['msg']) . '</p></div>';
        }
    }
?>
<div class="wrap">
    <h1>Kirim Pesan</h1>

    <label><input type="radio" name="message_mode" value="text" checked onclick="fwgToggleForm('text')"> Text</label>
    <label><input type="radio" name="message_mode" value="media" onclick="fwgToggleForm('media')"> Media</label>

    <!-- Form Text -->
    <form method="post" id="fwg-form-text" style="margin-top:20px;">
        <input type="hidden" name="message_type" value="text">
        <table class="form-table">
            <tr>
                <th>Pengirim</th>
                <td><input type="text" name="sender" value="<?php echo esc_attr($sender); ?>" readonly></td>
            </tr>
            <tr>
                <th>Nomor Penerima *</th>
                <td><textarea name="number" placeholder="628xxx|628xxx" required></textarea></td>
            </tr>
            <tr>
                <th>Pesan Teks</th>
                <td><textarea name="message" placeholder="Contoh: {Hai|Halo} nomor Anda adalah {number}"
                        required></textarea></td>
            </tr>
            <tr>
                <th>Pesan footer</th>
                <td><input type="text" name="footer" placeholder="Opsional"></td>
            </tr>
        </table>
        <p><input type="submit" name="fwg_send" class="button-primary" value="Kirim Pesan"></p>
    </form>

    <!-- Form Media -->
    <form method="post" id="fwg-form-media" style="display:none; margin-top:20px;">
        <input type="hidden" name="message_type" value="media">
        <table class="form-table">
            <tr>
                <th>Pengirim</th>
                <td><input type="text" name="sender" value="<?php echo esc_attr($sender); ?>" readonly></td>
            </tr>
            <tr>
                <th>Nomor Penerima *</th>
                <td><textarea name="number" placeholder="628xxx|628xxx" required></textarea></td>
            </tr>
            <tr>
                <th>Url Media</th>
                <td><input type="url" name="url" placeholder="https://example.com/file.jpg" required></td>
            </tr>
            <tr>
                <th>Jenis Media</th>
                <td>
                    <label><input type="radio" name="media_type" value="image" checked> Gambar</label>
                    <label><input type="radio" name="media_type" value="document"> Dokumen</label>
                    <label><input type="radio" name="media_type" value="video"> Video</label>
                    <label><input type="radio" name="media_type" value="audio"> Catatan Suara</label>
                </td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td><textarea name="caption"></textarea></td>
            </tr>
            <tr>
                <th>Pesan footer</th>
                <td><input type="text" name="footer" placeholder="Opsional"></td>
            </tr>
        </table>
        <p><input type="submit" name="fwg_send" class="button-primary" value="Kirim Pesan"></p>
    </form>
</div>

<script>
function fwgToggleForm(type) {
    document.getElementById('fwg-form-text').style.display = (type === 'text' ? 'block' : 'none');
    document.getElementById('fwg-form-media').style.display = (type === 'media' ? 'block' : 'none');
}
</script>
<?php
}