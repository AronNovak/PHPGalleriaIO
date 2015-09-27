<?php
/**
 * @file
 * Dead-simple fullpage, flat PHP photo gallery based on gallery.io
 */

require_once 'config.php';
$local_override = 'local.config.php';
if (is_file($local_override) && is_readable($local_override)) {
  require_once $local_override;
}

header('Content-Type: text/html; charset=utf-8');

if (isset($user) && isset($pass)) {
  $validated = FALSE;

  if (isset($_SERVER['PHP_AUTH_PW'])) {
    $validated = ($user == $_SERVER['PHP_AUTH_USER']) && ($pass == md5($_SERVER['PHP_AUTH_PW']));
  }
  if (!$validated) {
    header('WWW-Authenticate: Basic realm=""');
    header('HTTP/1.0 401 Unauthorized');
    die ("Not authorized");
  }
}

if (!isset($gallery_path)) {
  $gallery_path = getcwd();
}
$gallery_path = realpath($gallery_path);

$directory = new RecursiveDirectoryIterator($gallery_path);
$iterator = new RecursiveIteratorIterator($directory);
$types = implode('|', $allowed_filetypes);
$filtered = new RegexIterator($iterator, '/^.+\.(' . $types . ')$/i', RecursiveRegexIterator::GET_MATCH);
$output = "";
$images = [];

// Either downloading all the images in a ZIP file.
if (isset($_GET['download'])) {
  $zip = new ZipArchive();
  $temp_file = tempnam(sys_get_temp_dir(), 'phpgalleriaio');
  $zip->open($temp_file, ZipArchive::CREATE);
  foreach ($filtered as $file) {
    $zip->addFile($file[0]);
  }
  $zip->close();
  header('Content-Type: application/zip');
  header('Content-disposition: attachment; filename=gallery.zip');
  header('Content-Length: ' . filesize($temp_file));
  readfile($temp_file);
  unlink($temp_file);
  exit(0);
}

// Or serving them as a web-based gallery.
foreach ($filtered as $file) {
  $image = trim(str_replace($gallery_path, '', $file[0]), '/');
  $basename = pathinfo($image, PATHINFO_FILENAME);;
  $images[$basename . $image] = '<img data-layer="<h2>' . $basename . '</h2>" src="' . $image . '">';
}
ksort($images);
$galleria = implode('', $images);

if (!isset($css)) {
  $css = is_file('local.css') ? 'local.css' : 'index.css';
}
if (!isset($js)) {
  $js = is_file('local.js') ? 'local.js' : 'index.js';
}

if (!isset($title)) {
  $title = basename(getcwd()) . ' (' . count($images) . ')';
}

$galleria_config = json_encode($galleria_config);

require_once 'index.tpl.php';
