<?php
/*
Plugin Name: Custom Field Importer
Description: Import data from a file and map it to custom post types with support for remote file downloads.
Version: 1.0
Author: Your Name
*/

defined('ABSPATH') or die('No script kiddies please!');

define('CFI_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once CFI_PLUGIN_DIR . 'includes/admin-ui.php';
require_once CFI_PLUGIN_DIR . 'includes/importer.php';
require_once CFI_PLUGIN_DIR . 'includes/file-handler.php';

add_action('admin_menu', 'cfi_register_menu');

function cfi_register_menu()
{
    add_menu_page('Custom Importer', 'Custom Importer', 'manage_options', 'custom-importer', 'cfi_admin_page');
}
