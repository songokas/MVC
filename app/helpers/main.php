<?php

function url( $url = '' ){
    return BASE_URL.'/'.$url;
}

function redirect( $url= '' ){
    //no redirection for cli
    if ( defined('TEST')) return;
    
    if( strpos($url, '://') === false )
            $url = url($url);
    header('Location:'.$url);
    die;
}

function last_page(){
        //no redirection for cli
    if ( defined('TEST')) return;
    redirect($_SERVER['HTTP_REFERER']);
}