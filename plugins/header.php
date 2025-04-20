<div header>
    <img header_logo onclick="location.href='/'" src="/plugins/fulllogo_dark.png">
    <input class="disabling" header_search placeholder="<?= $lang->ph ?> <?= $lang->name ?>">
    <a href="/about"><?= $lang->navabout ?></a> &nbsp; <a href="/docs"><?= $lang->navapi ?></a> &nbsp; <a href="/terms"><?= $lang->navterms ?></a>
    <a title="<?= $lang->aph ?>"><img header_apps onclick="switchAppPanel();" src="/plugins/apps.svg" apps></a>
</div>
<div class="hide" apppanel>
    <iframe apppanel-frame src="http://minteck-projects.alwaysdata.net/prod/optimized/"><?= $lang->iframeerr ?></iframe>
    <a title="<?= $lang->amph ?>" target="_blank" apppanel-button href="https://minteck-projects.alwaysdata.net/prod/intro">
        <div apppanel-btn-container vcenter><?= $lang->viewall ?></div>
    </a>
</div>
<div header_separator></div>
<script src="/plugins/submit.js"></script>
<script src="/plugins/menus.js"></script>

<script>

window.onload = function () {
    document.querySelector('[header_search=""]').addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            submitHeader();
        }
    });
}

</script>