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

$directory = new RecursiveDirectoryIterator(getcwd());
$iterator = new RecursiveIteratorIterator($directory);
$types = implode('|', $allowed_filetypes);
$filtered = new RegexIterator($iterator, '/^.+\.(' . $types . ')$/i', RecursiveRegexIterator::GET_MATCH);
$output = "";
$images = [];
foreach ($filtered as $file) {
  $image = trim(str_replace(getcwd(), '', $file[0]), '/');
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
