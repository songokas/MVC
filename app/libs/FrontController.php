<?php

/**
 *
 * Serves as a main program class
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */
class FrontController {

    function __construct() {
        
    }

    /**
     * load libraries
     */
    function load_libraries() {
        include_once(LIB . 'Request.php');
        include_once(LIB . 'Session.php');
        $this->config = parse_ini_file(APP . 'configs/config.ini');
        $this->request = new Request();
        $this->session = new Session();
        $this->view = new Template(APP . 'views/', $this->config['template']);
    }

    /**
     * initialize main program
     */
    function init() {

        $this->load_libraries();

        $controller = $this->request->controller();
        $method = $this->request->method();

        $controller = ucfirst($controller ? $controller : $this->config['default_controller']);
        $method = $method ? $method : 'show';

        try {
            if (file_exists(APP . 'controllers/' . $controller . '.php')) {
                include APP . 'controllers/' . $controller . '.php';
                $con = new $controller($this->request, $this->view, $this->session, $this->config);
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