<?php

/**
 * bootstrap file
 */

define('DROOT', dirname(dirname(dirname(__FILE__))).'/');
define('APP', DROOT.'app/');
define('LIB', APP.'libs/');

define('TEST', 1);

//various constants and app logic
require_once APP.'configs/app.php';

//main class
include LIB.'FrontController.php';





