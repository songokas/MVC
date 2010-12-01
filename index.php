<?php

/**
 * bootstrap file
 */

define('DROOT', dirname(__FILE__).'/');
define('APP', DROOT.'app/');
define('LIB', APP.'libs/');

//various constants and app logic
require_once APP.'configs/app.php';

//main class
include LIB.'FrontController.php';


//initialize main controller
$fr = new FrontController();
$fr->init();