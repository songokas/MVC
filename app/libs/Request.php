<?php

/**
*
* Provides Request wrapper
*
* @package    MVC
* @author     Tomas Jakstas <bizabrazija@gmail.com>
* @license    GNU AFFERO GENERAL PUBLIC LICENSE
*/

class Request {

    //url domain.com/controller/method/other
    //holds url segments 0 => controller, 1 => method, 2 => other, etc
    public $segments;
    function  __construct() {

        $this->parse_globals();
        
    }

    /**
     * get server uri
     */
    function parse_globals(){
        //get
        $uri = preg_replace("|/(.*)|", "\\1", str_replace("\\", "/", $_SERVER['REQUEST_URI']));

        $this->segments = array_filter(explode('/', $uri));
                //remove index php
        if( reset($this->segments) == 'index.php')
            array_shift ($this->segments);
    }

    /**
     * retrieve controller from the url
     * @return <type>
     */
    function controller(){
        return $this->segment(0);
    }


    /**
     * retrieve method from the url
     * @return <type>
     */
    function method(){
        return $this->segment(1);
    }

    /**
     * retrieve request variable
     * @param <type> $str
     * @return <type>
     */
    function param( $str ){
        return isset($_REQUEST[$str]) ? $_REQUEST[$str] : false;
    }

    /**
     * retrieve url segment
     * @param <int> $no segment number
     * @return <mixed>
     */
    function segment( $no ){
        return isset($this->segments[$no]) ? $this->segments[$no] : false;
    }
}