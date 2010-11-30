<?php

/**
 *
 * Provides Login functionality
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */
class Main extends Controller {

    function  __construct(Request $request, Template $view, Session $session, $config) {
        parent::__construct($request, $view, $session, $config);
    }

    function show() {

        $content['error'] = null;
        if ($_POST) {
            $u = new User();
//            var_dump($u);
            $res = $u->db->query('SELECT * FROM users WHERE email=? AND pass=SHA1(CONCAT(?,salt))',
                            array($this->request->param('email'), $this->request->param('pass')));
            if ($res->num_rows() > 0) {
                $this->session->set_user($res->fetch());
                redirect('albums/show');
            } else {
                $content['error'] = 'Bad email or password!';
            }
        }
//        var_dump($this);

        $this->view->load('content', 'login', $content);
        $this->view->render();
    }

}