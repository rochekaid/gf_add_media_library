<?php
/*
Plugin Name: Gravity Forms Custom Media Library Field
Description: Adds a custom field to Gravity Forms for selecting images from the WordPress Media Library.
Version: 1.0
Author: Rochelle Victor
*/

// Ensure Gravity Forms is loaded before initializing the plugin.
add_action('init', 'initialize_custom_media_library_field');

function initialize_custom_media_library_field() {
    if (class_exists('GF_Field')) {
        require_once('class-gf-field-media-library.php');
        GF_Fields::register(new GF_Field_Media_Library());
    }
}
