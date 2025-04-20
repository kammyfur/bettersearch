<?php $_GUI = false; include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/everywhere.php"; ?>
<?php

function includes($string, $substring) {
    if (strpos($string, $substring) !== false) {
        return true;
    } else {
        return false;
    };
}

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
        $lang = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json"));
        $langc = "en";
    }
} else {
    $lang = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json"));
    $langc = "en";
}

if (isset($_COOKIE['region'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json")) {
        $region = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json"));
        $regionc = $_COOKIE['region'];
    } else {
        $region = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json"));
        $regionc = $_COOKIE['region'];
    }
} else {
    $region = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/regions/ww.json"));
    $regionc = "ww";
}

$tfl = 0;
foreach (scandir($_SERVER['DOCUMENT_ROOT'] . "/telemetry") as $file) {
    if ($file != "." && $file != "..") {
        $tfl = $tfl + 1;
    }
}

$functions = [];
foreach (get_loaded_extensions() as $extension) {
    $ftmp = get_extension_funcs($extension);
    if (is_array($ftmp)) {
        foreach ($ftmp as $func) {
            array_push($functions, $func);
        }
    }
}

$build = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/build.json"));

$browser = "other";

if (includes($_SERVER['HTTP_USER_AGENT'], "MSIE/")) {
    $browser = "ie";
    $rbrowser = "Trident";
    $abrowser = "browser.microsoft.internet_explorer";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Edge/")) {
    $browser = "chrome";
    $rbrowser = "EdgeHTML";
    $abrowser = "browser.microsoft.edge";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Edg/")) {
    $browser = "chrome";
    $rbrowser = "Chromium";
    $abrowser = "browser.microsoft.chromium_edge";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Trident/")) {
    $browser = "ie";
    $rbrowser = "Trident";
    $abrowser = "browser.microsoft.internet_explorer";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Firefox/")) {
    $browser = "firefox";
    $rbrowser = "Gecko";
    $abrowser = "browser.mozilla.firefox";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Chrome/")) {
    $abrowser = "browser.google.chrome";
    $rbrowser = "Chromium";
    $browser = "chrome";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Safari/")) {
    $abrowser = "browser.apple.safari_webkit";
    $rbrowser = "WebKit";
    $browser = "chrome";
}

$apachem = apache_get_modules();
if (count($apachem) > 10) {
    $amc = count($apachem);
    $amcr = count($apachem) - 10;
    $str = str_replace("#", $amcr, $lang->support_modules_others);
    $apachems = $apachem[0] . ", " . $apachem[1] . ", " . $apachem[2] . ", " . $apachem[3] . ", " . $apachem[4] . ", " . $apachem[5] . ", " . $apachem[6] . ", " . $apachem[7] . ", " . $apachem[8] . ", " . $apachem[9] . ", " . $str;
} else {
    $apachems = implode(", ", $apachem);
}

$apachem = get_loaded_extensions();
if (count($apachem) > 10) {
    $amc = count($apachem);
    $amcr = count($apachem) - 10;
    $str = str_replace("#", $amcr, $lang->support_modules_others);
    $phpms = $apachem[0] . ", " . $apachem[1] . ", " . $apachem[2] . ", " . $apachem[3] . ", " . $apachem[4] . ", " . $apachem[5] . ", " . $apachem[6] . ", " . $apachem[7] . ", " . $apachem[8] . ", " . $apachem[9] . ", " . $str;
} else {
    $phpms = implode(", ", $apachem);
}

$apachem = $functions;
if (count($apachem) > 10) {
    $amc = count($apachem);
    $amcr = count($apachem) - 10;
    $str = str_replace("#", $amcr, $lang->support_modules_others);
    $phpfs = $apachem[0] . ", " . $apachem[1] . ", " . $apachem[2] . ", " . $apachem[3] . ", " . $apachem[4] . ", " . $apachem[5] . ", " . $apachem[6] . ", " . $apachem[7] . ", " . $apachem[8] . ", " . $apachem[9] . ", " . $str;
} else {
    $phpfs = implode(", ", $apachem);
}

?>

<!DOCTYPE html>
<html lang="<?= $langc ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $lang->support ?></title>
    <link rel="stylesheet" href="/plugins/support.css">
    <link rel="icon" type="image/png" href="/plugins/favicon.png" />
    <?php if ($colors == "dark") { echo("<link rel=\"stylesheet\" href=\"/plugins/darkmode.css\">"); } ?>
</head>
<body>
    <?php //var_dump($_SERVER); ?>
    <center>
        <table>
            <tbody>
                <tr>
                    <td st-h colspan="2"><?= $lang->support_i ?></td>
                </tr>
                <tr>
                    <td st-s colspan="2"><?= $lang->support_basic ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_basic_edition ?></td>
                    <td st-r><?php if ($_SERVER['REQUEST_SCHEME'] == "http") { echo("GenuineBetterSearch"); }; if ($_SERVER['REQUEST_SCHEME'] == "https") { echo("SecureBetterSearch"); }; if ($_SERVER['REQUEST_SCHEME'] == "ftp") { echo("FtpBetterSearch"); } ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_basic_channel ?></td>
                    <td st-r><?= $build->channel ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_basic_version ?></td>
                    <td st-r><?= $build->version ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_basic_build ?></td>
                    <td st-r><?= $build->dev_build ?></td>
                </tr>
                <tr>
                    <td st-s colspan="2"><?= $lang->support_client ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_ua ?></td>
                    <td st-r><?= $_SERVER['HTTP_USER_AGENT'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_detect ?></td>
                    <td st-r><?= $browser ?> (<?= $abrowser ?>; <?= $rbrowser ?>)</td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_acceptl ?></td>
                    <td st-r><?= $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_accept ?></td>
                    <td st-r><?= $_SERVER['HTTP_ACCEPT'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_accepte ?></td>
                    <td st-r><?= $_SERVER['HTTP_ACCEPT_ENCODING'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_lang ?></td>
                    <td st-r><?= $langc ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_region ?></td>
                    <td st-r><?= $regionc ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_client_colors ?></td>
                    <td st-r><?= $colors ?></td>
                </tr>
                <tr>
                    <td st-s colspan="2"><?= $lang->support_telemetry ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_telemetry_qty ?></td>
                    <td st-r><?= $tfl ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_telemetry_sbs ?></td>
                    <td st-r><?= filesize($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-search.db") ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_telemetry_sbc ?></td>
                    <td st-r><?= filesize($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") ?></td>
                </tr>
                <tr>
                    <td st-s colspan="2"><?= $lang->support_request ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_method ?></td>
                    <td st-r><?= $_SERVER['REQUEST_METHOD'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_cport ?></td>
                    <td st-r><?= $_SERVER['REMOTE_PORT'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_sport ?></td>
                    <td st-r><?= $_SERVER['SERVER_PORT'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_proto ?></td>
                    <td st-r><?= $_SERVER['SERVER_PROTOCOL'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_gateway ?></td>
                    <td st-r><?= $_SERVER['GATEWAY_INTERFACE'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_args ?></td>
                    <td st-r><?= $_SERVER['QUERY_STRING'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_scheme ?></td>
                    <td st-r><?= $_SERVER['REQUEST_SCHEME'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_conn ?></td>
                    <td st-r><?= $_SERVER['HTTP_CONNECTION'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_request_host ?></td>
                    <td st-r><?= $_SERVER['HTTP_HOST'] ?></td>
                </tr>
                <tr>
                    <td st-s colspan="2"><?= $lang->support_server ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_server_apache ?></td>
                    <td st-r><?= $_SERVER['SERVER_SOFTWARE'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_server_php ?></td>
                    <td st-r><?= phpversion() ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_server_ip ?></td>
                    <td st-r><?= $_SERVER['SERVER_ADDR'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_server_root ?></td>
                    <td st-r><?= $_SERVER['DOCUMENT_ROOT'] ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_server_os ?></td>
                    <td st-r><?= php_uname("s") ?> <?= php_uname("r") ?> <?= php_uname("v") ?> <?= php_uname("m") ?></td>
                </tr>
                <tr>
                    <td st-s colspan="2"><?= $lang->support_modules ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_modules_apache ?></td>
                    <td st-r><?= $apachems ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_modules_php ?></td>
                    <td st-r><?= $phpms ?></td>
                </tr>
                <tr>
                    <td st-t><?= $lang->support_modules_funcs ?></td>
                    <td st-r><?= $phpfs ?></td>
                </tr>
            </tbody>
        </table>
    </center>
</body>
</html>