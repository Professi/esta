<?php

define("MAIN", "./tpl/main_new.tpl");
$step = get_post('step');

function get_post($variable) {
    $inhalt = "";
    if (isset($_GET[$variable]) && $_GET[$variable] != "")
        $inhalt = $_GET[$variable];
    if (isset($_POST[$variable]) && $_POST[$variable] != "")
        $inhalt = $_POST[$variable];
    return $inhalt;
}

function encode($word) {
    return htmlspecialchars($word, ENT_QUOTES, 'UTF-8');
}

function sendJSONHeader() {
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');




}


?>
 
