<?php

/**
 * Plugin Name: CSV Media Importer
 * Description: Imports external files from a CSV into the media library if they are not hosted on the current domain. Now includes file upload.
 * Version: 1.1
 * Author: Your Name
 */

add_action('admin_menu', 'csv_media_importer_menu');

function csv_media_importer_menu()
{
    add_menu_page('CSV Media Importer', 'CSV Media Importer', 'manage_options', 'csv-media-importer', 'csv_media_importer_page');
}

function csv_media_importer_page()
{
    if (!current_user_can('upload_files')) {
        wp_die('You do not have permission to access this page.');
    }

?>
    <div class="wrap">
        <h1>CSV Media Importer</h1>

        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('csv_media_importer_nonce', 'csv_media_importer_nonce_field'); ?>
            <p>
                <label for="csv_file">Upload CSV File:</label>
                <input type="file" name="csv_file" accept=".csv" required>
            </p>
            <p>
                <input type="submit" name="upload_csv" class="button button-primary" value="Upload and Import">
            </p>
        </form>
    </div>
<?php

    if (isset($_POST['upload_csv']) && check_admin_referer('csv_media_importer_nonce', 'csv_media_importer_nonce_field')) {
        if (!empty($_FILES['csv_file']['tmp_name'])) {
            $uploaded = $_FILES['csv_file'];

            if ($uploaded['type'] !== 'text/csv') {
                echo '<div class="notice notice-error"><p>Please upload a valid CSV file.</p></div>';
                return;
            }

            $csv_path = wp_upload_dir()['basedir'] . '/imported-' . time() . '.csv';
            if (move_uploaded_file($uploaded['tmp_name'], $csv_path)) {
                echo '<div class="notice notice-success"><p>CSV uploaded successfully. Starting import...</p></div>';
                process_csv_and_import($csv_path);
            } else {
                echo '<div class="notice notice-error"><p>Failed to upload the CSV file.</p></div>';
            }
        }
    }
}

function process_csv_and_import($csv_path)
{
    $domain = parse_url(home_url(), PHP_URL_HOST);

    if (file_exists($csv_path)) {
        $rows = array_map('str_getcsv', file($csv_path));
        foreach ($rows as $row) {
            $url = trim($row[0] ?? '');
            if (empty($url)) continue;

            $url_host = parse_url($url, PHP_URL_HOST);
            if ($url_host === $domain) {
                echo "<p>Skipped (same domain): {$url}</p>";
                continue;
            }

            $file = download_url($url);
            if (is_wp_error($file)) {
                echo "<p>Error downloading: {$url} - " . $file->get_error_message() . "</p>";
                continue;
            }

            $filename = basename(parse_url($url, PHP_URL_PATH));
            $attachment = [
                'post_mime_type' => mime_content_type($file),
                'post_title'     => sanitize_file_name($filename),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ];

            $attachment_id = wp_insert_attachment($attachment, $file);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $file);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            echo "<p>Imported: {$url}</p>";
        }
    } else {
        echo '<p>CSV file not found.</p>';
    }
}
