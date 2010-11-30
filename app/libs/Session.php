<?php

/**
 *
 * Provides Session wrapper
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */
class Session {

    function __construct() {
        if( !session_id())
            session_start();
    }

    /**
     * save user to session
     * @param <type> $obj
     */
    function set_user($obj) {
        $_SESSION['user_id'] = $obj->id;
        $_SESSION['user'] = $obj;
    }

    /**
     * retrieve user with user sesion id
     * @return <mixed>
     */

    function user() {

        $u = new User($this->param('user_id'));
//                  var_dump($this->param('user_id'), $_SESSION,$u->exists());die;
        return $u->exists() ? $u : false;
    }

    /**
     * retrieve value from session
     * @param <string> $str
     * @return <mixed>
     */
    function param($str) {
        return isset($_SESSION[$str]) ? $_SESSION[$str] : false;
    }

}