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

function includes($string, $substring) {
    if (strpos($string, $substring) !== false) {
        return true;
    } else {
        return false;
    };
}

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

?>

<!DOCTYPE html>
<html lang="<?= $langc ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $lang->ctitle ?></title>
    <link rel="stylesheet" href="/plugins/styles.css">
    <?php if ($colors == "dark") { echo("<link rel=\"stylesheet\" href=\"/plugins/darkmode.css\">"); } ?>
    <link rel="icon" type="image/png" href="/plugins/favicon.png" />
    <script src="/plugins/jquery.js"></script>
    <script src="/plugins/submit.js"></script>
    <script src="/plugins/menus.js"></script>
    <link rel="stylesheet" href="/plugins/auto-complete.css">
    <script src="/plugins/auto-complete.js"></script>
    <script>
        lang0 = "<?= $lang->commerr ?>";
        lang1 = "<?= $lang->error ?>";
    </script>
</head>
<body>
    <div vcenter>
        <center>
            <p><img src="/plugins/fulllogo_dark.png" alt="<?= $lang->imgalt ?>" logo><br><small etitle><?= $lang->corp ?></small></p>
            <p><?= $lang->ctrigger ?></p>
            <?php
            
            if ($browser == "other") {
                echo("<p><div compatibility>{$lang->compatibility}</div></p>");
            }

            ?>
            <p><input type="text" class="disabling" placeholder="<?= $lang->csph ?> <?= $lang->name ?>" searchbar></p>
            <p><input onclick="submitCorp();" class="disabling" type="button" value="<?= $lang->search ?>" searchbutton button> &nbsp; &nbsp; &nbsp; <input onclick="location.href = '/init'" class="disabling" type="button" value="<?= $lang->settings ?>" settingsbutton button></p>
            <p mobilenav>
                <small>
                <?= $region->name ?> — <a href="/about"><?= $lang->navabout ?></a> • <a href="/docs"><?= $lang->navapi ?></a> • <a href="/terms"><?= $lang->navterms ?></a>
                </small>
            </p>
        </center>
    </div>
    <div navigation>
        <span region><?= $region->name ?></span>
        <span links><a href="/about"><?= $lang->navabout ?></a> &nbsp; <a href="/docs"><?= $lang->navapi ?></a> &nbsp; <a href="/terms"><?= $lang->navterms ?></a></span>
    </div>
    <div menu>
        <span menu-choices>
        <?= $lang->datasave ?>
            <label class="switch">
                <input type="checkbox" datasave_switch onchange='document.cookie = "datasave=" + document.querySelector(`[datasave_switch=""]`).checked.toString() + "; Path=/";location.reload()' <?php if (isset($_COOKIE['datasave'])) { if ($_COOKIE['datasave'] == "true") { echo("checked"); } }; ?>>
                <span class="slider round"></span>
            </label><span cbsep_desktop> — </span><span cbsep_mobile><br></span>
            <a href="/" title="<?= $lang->fph ?>"><small><?= $lang->find ?></small></a> &nbsp; <a href="/corps" title="<?= $lang->cph ?>"><small><?= $lang->corp ?></small></a>
            <a title="<?= $lang->aph ?>"><img onclick="switchAppPanel();" src="/plugins/apps.svg" apps></a>
        </span>
    </div>
    <div class="hide" apppanel>
        <iframe apppanel-frame src="<?= $_SERVER['REQUEST_SCHEME'] ?>://minteck-projects.alwaysdata.net/prod/optimized/"><?= $lang->iframeerr ?></iframe>
        <a title="<?= $lang->amph ?>" target="_blank" apppanel-button href="https://minteck-projects.alwaysdata.net/prod/intro">
            <div apppanel-btn-container vcenter><?= $lang->viewall ?></div>
        </a>
    </div>
</body>
<?php

if (isset($_COOKIE['datasave'])) {
    if ($_COOKIE['datasave'] == "true") {
        die("</html>");
    }
}

?>
<script>
    SuggestionsAPI = horsey(document.querySelector("[searchbar='']"), {
        source (data, done) {
            $.ajax({
                type: "GET",
                dataType: 'html',
                url: "/api/suggestions/?q=" + document.querySelector('[searchbar=""]').value + "&mode=corps&limit=5",
                success: function (data) {
                    raw = JSON.parse(data);
                    done(null, [{
                        list: raw.suggestions
                    }])     
                },
                cache: false,
                contentType: false,
                processData: false
            });
        },
        limit: 3
    });
</script>
</html>