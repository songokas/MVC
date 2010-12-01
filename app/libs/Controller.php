<?php

/**
 *
 * Provides Controller functionality
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */
//main model class
require_once LIB . 'Model.php';
//main view class
require_once LIB . 'Template.php';
require_once LIB . 'Session.php';

class Controller {

    public $request;
    public $view;
    public $config;
    public $session;

    function __construct(Request $request, array $config) {
        $this->request = $request;
        $this->config = $config;
        $this->session = new Session();
        $this->view = new Template(APP . 'views/', isset($this->config['template']) ?
                $this->config['template'] : '');
    }

}

/**
 * Used for back-end such as automatic user checks
 */
class AdminController extends Controller {

    public $user;

    function __construct( Request $request, array $config) {
        parent::__construct($request, $config);
        $this->user = $this->session->user();
//        var_dump($this->user);die;
        if (empty($this->user)) {
            redirect();
            die('Please go to the login screen.');
        }
    }

}