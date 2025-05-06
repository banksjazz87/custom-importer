<?php

function cfi_admin_page()
{
?>
    <div class="wrap">
        <h1>Custom Field Importer</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="import_file" required>
            <select name="post_type">
                <?php
                $post_types = get_post_types(['public' => true], 'objects');
                foreach ($post_types as $pt) {
                    echo "<option value='{$pt->name}'>{$pt->label}</option>";
                }
                ?>
            </select>
            <input type="submit" name="cfi_import" value="Upload and Import" class="button button-primary">
        </form>
    </div>
<?php

    if (isset($_POST['cfi_import']) && !empty($_FILES['import_file'])) {
        cfi_handle_import($_FILES['import_file'], sanitize_text_field($_POST['post_type']));
    }
}
