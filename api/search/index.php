<?php $_GUI = false; include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/everywhere.php"; ?>
<?php

if (isset($_GET['q']) && isset($_COOKIE['lang']) && isset($_COOKIE['region'])) {} else {
    if (isset($_GET['q']) && isset($_GET['lang']) && isset($_GET['region'])) {} else {
        if (isset($_GET['q']) && isset($_GET['lang']) && isset($_COOKIE['region'])) {} else {
            die("Some metadata is missing!");
            if (isset($_GET['q']) && isset($_COOKIE['lang']) && isset($_GET['region'])) {} else {
                die("Some metadata is missing!");
            }
        }
    }
}

if (isset($_GET['lang'])) {
    $_COOKIE['lang'] = $_GET['lang'];
    if ($_GET['lang'] == "auto") {
        $_COOKIE['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }
}

if (isset($_GET['region'])) {
    $_COOKIE['region'] = $_GET['region'];
}

$request = $_GET['q'];
$lang = $_COOKIE['lang'];
$region = $_COOKIE['region'];

if (isset($_COOKIE['region'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json")) {
        $regioninfo = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/regions/" . $_COOKIE['region'] . ".json"));
    } else {
        die("Invalid region");
    }
} else {
    die("Invalid region");
}

if (isset($_COOKIE['lang'])) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE['lang'] . ".json")) {
        $langinfo = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $_COOKIE['lang'] . ".json"));
    } else {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json")) {
            $langinfo = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json"));
            $lang = "en";
        } else {
            $langinfo = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/fr.json"));
            $lang = "fr";
        }
    }
} else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json")) {
        $langinfo = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/en.json"));
        $lang = "en";
    } else {
        $langinfo = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/lang/fr.json"));
        $lang = "fr";
    }
}

function startsWith ($string, $startString) {
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

function endsWith($string, $endString) {
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function includes($string, $substring) {
    if (strpos($string, $substring) !== false) {
        return true;
    } else {
        return false;
    };
}

function normalize ($string) {
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj', 'd'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'C'=>'C', 'c'=>'c', 'C'=>'C', 'c'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'R'=>'R', 'r'=>'r',
    );
    return strtr($string, $table);
}

function send($path) {
    global $SearchJSRedirection;
    global $browser;
    global $region;
    global $lang;
    global $request;
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-search.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-search.db") . "\n\n" . $send);
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-search.db");
    $actuala = explode("\n", $actual);
    if (array_search(strtolower(normalize($request)), $actuala) === false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-search.db", $actual . "\n" . $request);
    }
    if (isset($SearchJSRedirection)) {
        if ($SearchJSRedirection) {
            die("<script>location.href=\"" . str_replace("\"", "\\\"", $path) . "\"</script>");
        } else {
            die("ok=" . $path);
        }
    } else {
        die("ok=" . $path);
    }
}

$slug = strtolower($request);
$slug2 = strtolower($request);
$slug = normalize($slug);

// ********************************************

$browser = "other";

if (includes($_SERVER['HTTP_USER_AGENT'], "MSIE/")) {
    $browser = "ie";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Edge/")) {
    $browser = "chrome";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Trident/")) {
    $browser = "ie";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Firefox/")) {
    $browser = "firefox";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Chrome/")) {
    $browser = "chrome";
}

if (includes($_SERVER['HTTP_USER_AGENT'], "Safari/")) {
    $browser = "chrome";
}

if (startsWith($slug2, "@duckduckgo ")) {
    $rad = trim(str_replace("@duckduckgo", "", $request));
    send("https://www.duckduckgo.com" . "" . "/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@ddg ")) {
    $rad = trim(str_replace("@ddg", "", $request));
    send("https://www.duckduckgo.com" . "" . "/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@google ")) {
    $rad = trim(str_replace("@google", "", $request));
    send("https://www.google.com" . "" . "/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@bing ")) {
    $rad = trim(str_replace("@bing", "", $request));
    send("https://www.bing.com" . "" . "/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@qwant ")) {
    $rad = trim(str_replace("@qwant", "", $request));
    send("https://www.qwant.com" . "" . "/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@minteckprojects ")) {
    $rad = trim(str_replace("@minteckprojects", "", $request));
    send("https://minteck-projects.alwaysdata.net" . "" . "/find/search/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@minteck-projects ")) {
    $rad = trim(str_replace("@minteck-projects", "", $request));
    send("https://minteck-projects.alwaysdata.net" . "" . "/find/search/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@mp ")) {
    $rad = trim(str_replace("@mp", "", $request));
    send("https://minteck-projects.alwaysdata.net" . "" . "/find/search/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@mprj ")) {
    $rad = trim(str_replace("@mprj", "", $request));
    send("https://minteck-projects.alwaysdata.net" . "" . "/find/search/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@mtk ")) {
    $rad = trim(str_replace("@mtk", "", $request));
    send("https://minteck-projects.alwaysdata.net" . "" . "/find/search/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@mtkprj ")) {
    $rad = trim(str_replace("@mtkprj", "", $request));
    send("https://minteck-projects.alwaysdata.net" . "" . "/find/search/?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (startsWith($slug2, "@amazon ")) {
    $rad = trim(str_replace("@amazon", "", $request));
    send("https://www.amazon." . $regioninfo->amazon_suffix . "/s?k=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

if (startsWith($slug2, "@wikipedia ")) {
    $rad = trim(str_replace("@wikipedia", "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://en.wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    }
}

if (startsWith($slug2, "@wp ")) {
    $rad = trim(str_replace("@wp", "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://en.wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    }
}

if ($browser == "ie") {
    send("https://www.google.com/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (includes($slug, "google")) {
    send("https://www.google.com/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (includes($slug, "minteck")) {
    send("https://www.google.com/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (includes($slug, "youtube")) {
    send("https://www.google.com/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if (includes($slug, "projectpedia")) {
    send("https://minteck-projects.alwaysdata.net/find/search/?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

if (includes($slug, "projectpédia")) {
    send("https://minteck-projects.alwaysdata.net/find/search/?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

if (includes($slug, "pinpages")) {
    send("https://minteck-projects.alwaysdata.net/find/search/?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

if (includes($slug, $langinfo->whatmeans0)) {
    $rad = trim(str_replace($langinfo->whatmeans0, "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://google.com/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    }
}

if (includes($slug, $langinfo->whatmeans1)) {
    $rad = trim(str_replace($langinfo->whatmeans1, "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://google.com/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    }
}

if (includes($slug, $langinfo->whatmeans2)) {
    $rad = trim(str_replace($langinfo->whatmeans2, "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://google.com/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    }
}

if (includes($slug, $langinfo->whatmeans3)) {
    $rad = trim(str_replace($langinfo->whatmeans3, "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://google.com/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    }
}

if (includes($slug, $langinfo->whatmeans4)) {
    $rad = trim(str_replace($langinfo->whatmeans4, "", $request));
    if ($langinfo->wikipedia_supported) {
        send("https://" . $lang . ".wikipedia.org/w/index.php?search=" . urlencode($rad) . "&title=Special%3ASearch&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
    } else {
        send("https://google.com/search?q=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    }
}

if (includes($slug, $langinfo->price0)) {
    $rad = trim(str_replace($langinfo->price0, "", $request));
    send("https://www.amazon." . $regioninfo->amazon_suffix . "/s?k=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

if (includes($slug, $langinfo->price1)) {
    $rad = trim(str_replace($langinfo->price1, "", $request));
    send("https://www.amazon." . $regioninfo->amazon_suffix . "/s?k=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

if (includes($slug, $langinfo->price2)) {
    $rad = trim(str_replace($langinfo->price2, "", $request));
    send("https://www.amazon." . $regioninfo->amazon_suffix . "/s?k=" . urlencode($rad) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
}

$words = str_word_count($slug);

if ($words < 2) {
    if ($lang == "fr" && $browser != "chrome") {
        send("https://www.qwant.com" . "" . "/?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    } else {
        send("https://www.duckduckgo.com" . "" . "/?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
    }
}

if ($words >= 2 && $words <= 5) {
    send("https://www.bing.com" . "" . "/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}

if ($words > 5) {
    send("https://www.google.com" . "" . "/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "");
}