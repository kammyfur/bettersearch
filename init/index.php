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

?>

<!DOCTYPE html>
<html lang="neutral">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BetterSearch</title>
    <link rel="stylesheet" href="/plugins/styles.css">
    <?php if ($colors == "dark") { echo("<link rel=\"stylesheet\" href=\"/plugins/darkmode.css\">"); } ?>
    <link rel="icon" type="image/png" href="/plugins/favicon.png" />
    <script src="/plugins/jquery.js"></script>
</head>
<body init>
    <center><p><img src="/plugins/fulllogo_dark.png" alt="BetterSearch" logo></p></center>
    <p><center>
        <!-- <input onchange="document.cookie='colors=dark; Path=/';location.reload()" type="radio" name="colors" value="dark" <?php if ($colors == "dark") { echo("selected"); } ?>><img src="/plugins/colors-dark.svg" translation-indicator> -->
        <label class="radio"><input onchange="document.cookie='colors=dark; Path=/';location.reload()" type="radio" name="colors" value="dark" <?php if ($colors == "dark") { echo("selected"); } ?>><img alt="Dark Theme" src="/plugins/colors-dark.svg" translation-indicator><span></span></label>
        <!-- <input onchange="document.cookie='colors=light; Path=/';location.reload()" type="radio" name="colors" value="light" <?php if ($colors == "light") { echo("selected"); } ?>><img src="/plugins/colors-light.svg" translation-indicator> -->
        <label class="radio"><input onchange="document.cookie='colors=light; Path=/';location.reload()" type="radio" name="colors" value="light" <?php if ($colors == "light") { echo("selected"); } ?>><img alt="Light Theme" src="/plugins/colors-light.svg" translation-indicator><span></span></label>
        <?php
        
        if ($colors == "dark") {
            echo("<script>document.querySelector('[name=\"colors\"][value=\"dark\"]').checked = true;</script>");
        } else {
            echo("<script>document.querySelector('[name=\"colors\"][value=\"light\"]').checked = true;</script>");
        }
        
        ?>
    </center></p>
    <br>
    <center><p>
        <?php
        foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/lang") as $lang) {
            if ($lang == "." || $lang == "..") {} else {
                $checked = false;
                $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $lang));
                $langid = str_replace(".json", "", $lang);
                echo('<input onchange="document.cookie=\'lang=' . $langid . '; path=/\'" type="radio" name="language" value="' . $langid . '"');
                if (isset($_COOKIE['lang'])) {
                    if ($_COOKIE['lang'] == $langid) {
                        echo(" checked");
                        $checked = true;
                    }
                }
                echo('> ' . $json->name);
                if ($json->google_translate) {
                    echo("<a title=\"" . $json->contributors . "\"><img src=\"/plugins/translate-software.svg\" translation-indicator></a>");
                } else {
                    echo("<a title=\"" . $json->contributors . "\"><img src=\"/plugins/translate-human.svg\" translation-indicator></a>");
                }
                if (!$json->wikipedia_supported) {
                    echo("<a title=\"" . $json->wpwarn . "\"><img src=\"/plugins/warn.svg\" translation-indicator></a>");
                }
                echo("<span></span><br>");
                if ($checked == true) {
                    echo("<script>document.querySelector('[name=\"language\"][value=\"" . $langid . "\"]').checked = true;</script>");
                } else {
                    echo("<script>document.querySelector('[name=\"language\"][value=\"" . $langid . "\"]').checked = false;</script>");
                }
            }
        }
        
        ?>
    </p>
    <br>
    <p>
        <?php
        
        foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/regions") as $lang) {
            if ($lang == "." || $lang == "..") {} else {
                $checked = false;
                $json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $lang));
                $langid = str_replace(".json", "", $lang);
                echo('<label class="radio"><input onchange="document.cookie=\'region=' . $langid . '; path=/\'" type="radio" name="region" value="' . $langid . '"');
                if (isset($_COOKIE['lang'])) {
                    if ($_COOKIE['lang'] == $langid) {
                        echo(" checked");
                        $checked = true;
                    }
                }
                echo("><span></span></label>" . "<img src=\"/plugins/flag_" . $langid . ".svg\" country-flag> &nbsp;" . $json->name . "<br>");
                if ($checked == true) {
                    echo("<script>document.querySelector('[name=\"region\"][value=\"" . $langid . "\"]').checked = true;</script>");
                } else {
                    echo("<script>document.querySelector('[name=\"region\"][value=\"" . $langid . "\"]').checked = false;</script>");
                }
            }
        }
        
        ?>
    </p><p><input type="button" value="OK" onclick="location.href='/'"></p></center>
</body>
</html>