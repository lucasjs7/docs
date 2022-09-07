<?php

require('config.php');
require('vendor/autoload.php');

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

new App\Controller\App;