<?php $_GUI = false; include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/everywhere.php"; ?>
<?php

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

if (isset($_GET['q']) && isset($_COOKIE['lang']) && isset($_COOKIE['region'])) {} else {
    die("Some metadata is missing!");
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
        die("Invalid language");
    }
} else {
    die("Invalid language");
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

function eh() {
    global $lang;
    global $region;
    global $request;
    global $browser;
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: https://www.google.com" . "" . "/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "&tbs=li:1";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    die("ok=https://www.google.com" . "" . "/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "&tbs=li:1");
    return true;
}

function noeh() {}

function getElementsByClass(&$parentNode, $tagName, $className) {
    $nodes=array();

    $childNodeList = $parentNode->getElementsByTagName($tagName);
    for ($i = 0; $i < $childNodeList->length; $i++) {
        $temp = $childNodeList->item($i);
        if (stripos($temp->getAttribute('class'), $className) !== false) {
            $nodes[]=$temp;
        }
    }

    return $nodes;
}

if (normalize(trim(strtolower($request))) == "minteck projects") { 
    $path = "https://minteck-projects.alwaysdata.net";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "minteck projects care") { 
    $path = "http://care.mpcms.rf.gd";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "pinpages") { 
    $path = "https://pinpages.alwaysdata.net";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "projectpedia") { 
    $path = "https://projectpedia.alwaysdata.net";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "projectp%C3%A9dia") { 
    $path = "https://projectpedia.alwaysdata.net";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "mozilla") { 
    $path = "https://mozilla.org";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "firefox") { 
    $path = "https://firefox.com";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "mpcms") { 
    $path = "https://mpcms.rf.gd";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "red numerique") { 
    $path = "http://red-numerique.mpcms.rf.gd";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "red numérique") { 
    $path = "http://red-numerique.mpcms.rf.gd";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

if (normalize(trim(strtolower($request))) == "red num%C3%A9rique") { 
    $path = "http://red-numerique.mpcms.rf.gd";
    $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
    $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
    die("ok=" . $path);
}

set_error_handler("eh");
$cnt = file_get_contents("https://fr.wikipedia.org/wiki/" . $request);
set_error_handler("noeh");

include $_SERVER['DOCUMENT_ROOT'] . '/api/simple_html_dom.php';

$doc = file_get_html("https://fr.wikipedia.org/wiki/" . $request);
$href = $doc->find('.external.text')[0]->href;

if (isset($href) && is_string($href)) {
    if (startsWith($href, "https://fr.wikipedia.org")) {
        if ($langinfo->wikipedia_supported) {
            $path = "https://{$lang}.wikipedia.org/wiki/" . urlencode($request) . "?utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region;
            $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
            $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
            die("ok=" . $path);
        } else {
            $path = "https://www.google.com" . "" . "/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "&tbs=li:1";
            $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
            $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
            die("ok=" . $path);
        }
    } else {
        die("ok={$href}");
        $path = $href;
        $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
        $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
        die("ok=" . $path);
    }
} else {
    if ($langinfo->wikipedia_supported) {
        die("ok=https://{$lang}.wikipedia.org/wiki/" . urlencode($request) . "?utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region);
        $path = "https://{$lang}.wikipedia.org/wiki/" . urlencode($request) . "?utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region;
        $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
        $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
        die("ok=" . $path);
    } else {
        $path = "https://www.google.com" . "" . "/search?q=" . urlencode($request) . "&utm-source=minteck-projects-better-search&utm-uid=" . $lang . "-" . $region . "&tbs=li:1";
        $send = "Browser: " . $browser . "\nUser Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\nUser ID: " . $lang . "-" . $region . "\nDate: " . date("d/m/Y H:i:s.v") . "\nQuery: " . $request . "\nReturn: " . $path;
        $actual = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $actuala = explode("\n", $actual);
    if (array_search(normalize(trim(strtolower($request))), $actuala) == false) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db", $actual . "\n" . $request);
    }
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-corps.db") . "\n\n" . $send);
        die("ok=" . $path);
    }   
}