<?php

/**
*
* Provides Controller functionality
*
* @package    MVC
* @author     Tomas Jakstas <bizabrazija@gmail.com>
* @license    GNU AFFERO GENERAL PUBLIC LICENSE
*/

class Controller {
    
    public $request;
    public $view;
    public $config;
    public $session;

    function __construct( Request $request, Template $view, Session $session, $config ){
        $this->request = $request;
        $this->view = $view;
        $this->config = $config;
        $this->session = $session;
    }
}

/**
 * Used for back-end such as automatic user checks
 */

class AdminController extends Controller {

    public $user;

    function  __construct(Request $request, Template $view, Session $session, $config) {
        parent::__construct($request, $view, $session, $config);
        $this->user = $this->session->user();
//        var_dump($this->user);die;
        if( empty($this->user)){
                redirect();
                die('Please go to the login screen.');
        }

    }
}