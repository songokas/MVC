<?php

//beginning of the url
define('BASE_URL', '/index.php');

define('EXT', '.php');

//will be able to load models automatically
function __autoload($class) {
    $class = ucfirst($class);
    $path = APP . 'models/' . $class . EXT;
    if (file_exists($path)) {
        require_once $path;
    } else {
        throw new Exception('file does not exists:' . $path);
    }
}

