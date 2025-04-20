<?php

header("Content-Type: application/json");

function includes($string, $substring) {
    if (strpos($string, $substring) !== false) {
        return true;
    } else {
        return false;
    };
}

if (isset($_GET['q'])) {
    $query = $_GET['q'];
} else {
    die("{\"error\": \"E_MISSING_ARGUMENT\"}");
}

if (isset($_GET['limit'])) {
    if (is_int((int)$_GET['limit'])) {
        $limit = (int)$_GET['limit'];
    } else {
        die("{\"error\": \"E_INVALID_LIMIT_FORMAT\"}");
    }
} else {
    $limit = 5;
}

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
} else {
    die("{\"error\": \"E_MISSING_ARGUMENT\"}");
}

if ($mode == "search" || $mode == "corps") {} else {
    die("{\"error\": \"E_UNSUPPORTED_MODE\"}");
}

$return = [];

if ($mode == "search") {
    $suggestions = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-search.db");
    $return["mode"] = "search";
}

if ($mode == "corps") {
    $suggestions = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/telemetry/tm-autocomplete-corps.db");
    $return["mode"] = "corps";
}

$s = explode("\n", $suggestions);
$return["length"] = count($s);

$return["suggestions"] = [];

foreach ($s as $term) {
    if (count($return["suggestions"]) < $limit) {
        if (includes($term, $query)) {
            array_push($return["suggestions"], $term);
        }
    }
}

die(json_encode($return));