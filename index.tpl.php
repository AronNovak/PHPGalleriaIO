<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?= $title ?></title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/galleria/1.4.7/galleria.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?= $css ?>">
  <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/galleria/1.4.7/themes/classic/galleria.classic.min.css">
  <script>var galleria_config = <?= $galleria_config ?></script>
  <script src="<?= $js ?>"></script>
</head>
<body>
  <div id="galleria"><?= $galleria ?></div>
</body>
</html>
