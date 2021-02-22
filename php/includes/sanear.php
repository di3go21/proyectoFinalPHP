<?php
function sanear($campo){
    $tmp = (isset($_REQUEST[$campo]))
            ? trim(htmlspecialchars(preg_replace("/\s+/", " ",$_REQUEST[$campo]),ENT_QUOTES,"UTF-8"))
            : "";
    return $tmp;
}

?>