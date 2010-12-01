<?php

/**
 *
 * Serves as a main program class
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */


//main controller class
require_once LIB.'Controller.php';
//helper functions
require_once(APP . 'helpers/main.php');

require_once(LIB . 'Request.php');


class FrontController {

    function __construct() {
        
    }


    /**
     * initialize main program
     */
    function init() {

        $this->config = parse_ini_file(APP . 'configs/config.ini');
        $this->request = new Request();

        $controller = $this->request->controller();
        $method = $this->request->method();

        $controller = ucfirst($controller ? $controller : $this->config['default_controller']);
        $method = $method ? $method : 'show';

        try {
            if (file_exists(APP . 'controllers/' . $controller . '.php')) {
                include APP . 'controllers/' . $controller . '.php';
                $con = new $controller($this->request, $this->config);
                if (method_exists($con, $method)) {
                    $con->$method();
                } else {
                    throw new Exception('Method: ' . $method . ' in controller: ' . $controller . ' not found');
                }
            } else {
                throw new Exception('Controller not found: ' . $controller);
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }


}