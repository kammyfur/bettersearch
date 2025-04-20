<?php $_GUI = true; include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/everywhere.php"; ?>
<?php

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

if (isset($_COOKIE['lang'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE['lang'] . ".json")) {
        $lang = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE['lang'] . ".json"));
        $langc = $_COOKIE['lang'];
    } else {
        die("<script>location.href = \"/init\";</script>");
    }
} else {
    die("<script>location.href = \"/init\";</script>");
}

if (isset($_COOKIE['region'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json")) {
        $region = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json"));
        $regionc = $_COOKIE['region'];
    } else {
        die("<script>location.href = \"/init\";</script>");
    }
} else {
    die("<script>location.href = \"/init\";</script>");
}

?>

<!DOCTYPE html>
<html lang="<?= $langc ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $lang->api ?></title>
    <link rel="stylesheet" href="/plugins/styles.css">
    <?php if ($colors == "dark") { echo("<link rel=\"stylesheet\" href=\"/plugins/darkmode.css\">"); } ?>
    <link rel="icon" type="image/png" href="/plugins/favicon.png" />
    <script src="/plugins/jquery.js"></script>
</head>
<body about>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/header.php"; ?>
    <?php
    
    if ($langc == "fr") {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/docs/index-fr.html"));
    } else {
        echo(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/docs/index-en.html"));
    }
    
    ?>
</body>
</html>