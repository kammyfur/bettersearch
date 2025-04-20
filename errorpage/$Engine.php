<?php $_GUI = false; include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/everywhere.php"; ?>
<?php

if (isset($_COOKIE['lang'])) {
  if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE['lang'] . ".json")) {
      $lang = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE['lang'] . ".json"));
      $langc = $_COOKIE['lang'];
  } else {
      $lang = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json"));
      $langc = "en";
  }
} else {
  $lang = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json"));
  $langc = "en";
}

$langarray = (array)$lang;

if (!isset($_COOKIE['colors'])) {
  echo("<script>document.cookie = \"colors=light; Path=/\"</script>");
  $_COOKIE['colors'] = "light";
  $colors = "light";
} else {
  if ($_COOKIE['colors'] == "dark") {
      $colors = "dark";
  } else {
      $colors = "light";
  }
}

?>

<!DOCTYPE html>
<html lang=en>
  <meta charset=utf-8>
  <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
  <?php if ($colors == "dark") { echo("<link rel=\"stylesheet\" href=\"/plugins/darkmode.css\">"); } ?>
  <title><?= $lang->error_title ?> <?= $ecode ?> (<?= $edesc ?>)</title>
  <style>
    *{margin:0;padding:0}html,code{font:15px/22px arial,sans-serif}html{background:#fff;color:#222;padding:15px}body{margin:7% auto 0;max-width:390px;min-height:180px;padding:30px 0 15px}* > body{background:url(/plugins/error.png) 100% 5px no-repeat;background-size: 171px 213px;padding-right:205px}p{margin:11px 0 22px;overflow:hidden}ins{color:#777;text-decoration:none}a img{border:0}@media screen and (max-width:772px){body{background:none;margin-top:0;max-width:none;padding-right:0}}#logo{background:url(/plugins/fulllogo_dark.png) no-repeat;margin-left:-5px}@media only screen and (min-resolution:192dpi){#logo{background:url(/plugins/fulllogo_dark.png) no-repeat 0% 0%/100% 100%;-moz-border-image:url(/plugins/fulllogo_dark.png) 0}}@media only screen and (-webkit-min-device-pixel-ratio:2){#logo{background:url(/plugins/fulllogo_dark.png) no-repeat;-webkit-background-size:100% 100%}}#logo{display:inline-block;height:54px;width:150px}#logo{background-size: 100%;}
  </style>
  <a href=/><span id=logo aria-label=BetterSearch></span></a>
  <p><b><?= $ecode ?>.</b> <ins><?= $lang->error_desc ?>.</ins>
  <p><?= str_replace("#", $_SERVER['REQUEST_URI'], $langarray['error_' . $ecode]) ?>  <ins><?= $lang->error_awk ?>.</ins>
