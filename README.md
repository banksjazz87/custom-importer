=== Custom Field Importer ===
Contributors: yourname  
Tags: import, custom post types, csv, json, media, remote file, upload  
Requires at least: 5.0  
Tested up to: 6.5  
Requires PHP: 7.4  
Stable tag: 1.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

Import content into custom post types from CSV or JSON files. Automatically download and attach remote files (like images or PDFs) during import.

== Description ==

Custom Field Importer is a simple but powerful tool that lets you import content into any custom post type (CPT) using a CSV or JSON file. Each row or object can define fields to be stored as post meta. Additionally, remote media files (like images or PDFs) can be downloaded and attached automatically.

**Features:**
- Upload CSV or JSON files directly from the WordPress admin.
- Map fields to post meta dynamically.
- Choose any registered custom post type.
- Automatically download and attach remote media files (e.g., images).
- Store attachment IDs in custom fields for use in themes or plugins.

**Example CSV Format:**

```csv
title,description,remote_image
Post 1,Some content,https://example.com/images/photo1.jpg
