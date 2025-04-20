<?php

// Php code put here will be run on ALL pages on the website. You may use the $_GUI boolean to check if the page is a GUI page or a API page

if (strpos($_SERVER['HTTP_USER_AGENT'], 'WOW64') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/1') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/1.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/2.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/3.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/4.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/5.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/6.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/7.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/8.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Edge/9.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/1') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/2') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/3') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/4') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/1.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/2.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/3.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/4.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/5.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/6.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/7.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/8.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/9.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Konqueror/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/1.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/2.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/3.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/4.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/5.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/6.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/7.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/8.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/9.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/1') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/2') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/3') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/1') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/2') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/3') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/4') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/1.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/2.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/3.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/4.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/5.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/6.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/7.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/8.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome/9.') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'HTTrack') !== false
    ) {
        $OBRedirectServer = "minteck-projects.alwaysdata.net";
        die("<script>location.href = \"http://{$OBRedirectServer}/deprecated\"</script><meta http-equiv=\"refresh\" content=\"0; url=http://{$OBRedirectServer}/deprecated\">");
    }
header("HTTP/2.0 200 OK");