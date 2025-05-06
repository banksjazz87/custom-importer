=== CSV Media Importer ===
Contributors: yourusername
Tags: csv, media, import, upload, external images, admin
Requires at least: 5.0
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Import media from a CSV file. Downloads all external (non-local) URLs and uploads them to the WordPress media library. Includes a CSV upload interface.

== Description ==

**CSV Media Importer** is a simple plugin that lets you:

- Upload a CSV file from the WordPress admin dashboard
- Automatically scan each row for external URLs
- Download and save each file into the Media Library
- Skip URLs that are already hosted on your site's domain

Ideal for bulk media imports where you have a list of image or file URLs from another server or system.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the admin menu: **Tools → CSV Media Importer**.
4. Use the form to upload a CSV file containing external URLs (one per line).

== CSV Format ==

- Only a single column is expected.
- Each row must contain a valid URL to an external file.
- No headers required.

**Example:**
