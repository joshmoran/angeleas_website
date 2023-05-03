<?php
    function createCookie($name, $value) {
        setcookie($name, $value,  time() + (86400 * 30));
        
    }

    function removeCookie($name, $value) {
        setcookie($name, $value,  time() - 3600);
    }
?>
