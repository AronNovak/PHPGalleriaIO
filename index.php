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
$directory = new RecursiveDirectoryIterator(getcwd());
$iterator = new RecursiveIteratorIterator($directory);
$types = implode('|', $allowed_filetypes);
$filtered = new RegexIterator($iterator, '/^.+\.(' . $types . ')$/i', RecursiveRegexIterator::GET_MATCH);
$output = "";
$images = [];
foreach ($filtered as $file) {
  $image = str_replace(getcwd(), '', $file[0]);
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

?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?php print $title ?></title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/galleria/1.4.2/galleria.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $css ?>">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/galleria/1.4.2/themes/classic/galleria.classic.min.css">
  <script>var galleria_config = <?php print json_encode($galleria_config); ?></script>
  <script src="<?php echo $js ?>"></script>
</head>
<body>
  <div id="galleria"><?php echo $galleria ?></div>
</body>
</html>
