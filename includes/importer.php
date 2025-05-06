<?php

function cfi_handle_import($file, $post_type)
{
    $tmp_name = $file['tmp_name'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

    if (!in_array($ext, ['csv', 'json'])) {
        echo "<p style='color:red;'>Invalid file type. Only CSV or JSON allowed.</p>";
        return;
    }

    $rows = [];

    if ($ext === 'csv') {
        $rows = array_map('str_getcsv', file($tmp_name));
        $headers = array_shift($rows);
    } else {
        $data = json_decode(file_get_contents($tmp_name), true);
        $headers = array_keys($data[0]);
        $rows = $data;
    }

    foreach ($rows as $row) {
        $data = is_array($row) ? array_combine($headers, $row) : $row;
        $post_id = wp_insert_post([
            'post_type' => $post_type,
            'post_title' => $data['title'] ?? 'Imported Post',
            'post_status' => 'publish'
        ]);

        if (is_wp_error($post_id)) continue;

        foreach ($data as $key => $value) {
            if (filter_var($value, FILTER_VALIDATE_URL) && preg_match('/\.(jpg|png|pdf|jpeg)/', $value)) {
                $attachment_id = cfi_download_remote_file($value, $post_id);
                if ($attachment_id) {
                    update_post_meta($post_id, $key, $attachment_id);
                }
            } else {
                update_post_meta($post_id, $key, $value);
            }
        }
    }

    echo "<p style='color:green;'>Import completed.</p>";
}
