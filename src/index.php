<?php
error_reporting(E_ALL);
session_cache_limiter('none');
session_name('est');
session_start();
include_once("./inc/init.inc.php");
//phpinfo();
$app = new App();

switch( $step ) {
    /*
     * case DATES
     * case LOGIN
     * case REGISTER
     * case NEWENTRYSUCCES
     * case MAIN
     */
    
default:
    $app->genMain();
}

?>