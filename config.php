<?php
/**
 * @file
 * Configuration file for the gallery.
 */

$allowed_filetypes = [
  'jpg',
  'jpeg',
  'png',
];

// Here you can use any configuration for galleria.io
// For full list, see http://galleria.io/docs/options/
$galleria_config = [
  'autoplay' => 3000,
];

// Further options:
//
// $title = "Custom page title at <title>";
//
// Local custom CSS override can be done
// via local.css and local.js.
// For anything else, use:
//
// $css = "http://example.com/totall.custom.css";
// $js = "http://example.com/totall.custom.js";
//
// A little privacy:
// $user = 'guests';
// $pass = '[MD5 Hash of the desired password]';
