<?php

if (isset($_GET['q'])) {
    $SearchJSRedirection = true;
    include_once $_SERVER['DOCUMENT_ROOT'] . "/api/search/index.php";
} else {
    die("No query provided");
}