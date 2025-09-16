<?php
if (! defined('ABSPATH')) exit;

function fwg_contacts_page()
{
    global $wpdb;
    $table = $wpdb->prefix . "fwg_contacts";

    // Tambah kontak
    if (isset($_POST['fwg_add_contact'])) {
        check_admin_referer('fwg_contacts');
        $wpdb->insert($table, [
            'name'     => sanitize_text_field($_POST['name']),
            'phone'    => sanitize_text_field($_POST['phone']),
            'email'    => sanitize_email($_POST['email']),
            'category' => sanitize_text_field($_POST['category']) ?: 'All'
        ]);
        echo '<div class="updated"><p>Contact added.</p></div>';
    }

    // Hapus kontak
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['id' => intval($_GET['delete'])]);
        echo '<div class="updated"><p>Contact deleted.</p></div>';
    }

    $contacts = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
?>
<div class="wrap">
    <h1>Daftar Kontak</h1>
    <form method="post">
        <?php wp_nonce_field('fwg_contacts'); ?>
        <table class="form-table">
            <tr>
                <th>Nama</th>
                <td><input type="text" name="name" required></td>
            </tr>
            <tr>
                <th>No HP</th>
                <td><input type="text" name="phone" required></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td><input type="text" name="category" placeholder="All"></td>
            </tr>
        </table>
        <p><input type="submit" name="fwg_add_contact" class="button-primary" value="Tambah Kontak"></p>
    </form>

    <h2>List Kontak</h2>
    <table class="widefat">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $c): ?>
            <tr>
                <td><?php echo esc_html($c->name); ?></td>
                <td><?php echo esc_html($c->phone); ?></td>
                <td><?php echo esc_html($c->email); ?></td>
                <td><?php echo esc_html($c->category); ?></td>
                <td><a href="?page=fwg_contacts&delete=<?php echo $c->id; ?>"
                        onclick="return confirm('Delete this contact?')">Delete</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
}