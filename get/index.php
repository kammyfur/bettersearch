<?php $_GUI = false; include_once $_SERVER['DOCUMENT_ROOT'] . "/plugins/everywhere.php"; ?>
<?php

if (isset($_GET['platform'])) {
    if ($_GET['platform'] == "firefox") {
        die("<title>...</title><script>location.href = \"https://addons.mozilla.org/firefox/addon/minteck-projects-bettersearch/\"</script>");
    }
    header("HTTP/* 501 Not Implemented");

    $ecode = 501;
    $edesc = "Not Implemented";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/errorpage/\$Engine.php";
} else {
    header("HTTP/* 501 Not Implemented");

    $ecode = 501;
    $edesc = "Not Implemented";

    include_once $_SERVER['DOCUMENT_ROOT'] . "/errorpage/\$Engine.php";
}