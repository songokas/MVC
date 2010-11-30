<?php
/*
 * Template loader class
 *
 * @author		Tomas Jakstas
 * @license		GNU AFFERO GENERAL PUBLIC LICENSE
 * @date		2010-10-01
 */

class Template {


    //template directory
    public $template_dir ;
    public $template_ext = '.php';
    //main template
    public $template_main = 'template';

    protected $tpl_arr = array();

    
    function  __construct( $dir, $main) {
	$this->template_dir = $dir;
	$this->template_main = $main;
    }




    /**
     * load template using array keys as variables
     * @param <type> $name
     * @param <type> $var_array
     * @param <type> $return
     * @return <type> 
     */

    function load( $type, $name, $var_array, $return = false ) {

//	global $config, $lang;
	
	$fullpath = $this->template_dir.$name.$this->template_ext;
	if ( file_exists($fullpath)) {

	    	if ( !is_array($var_array))
		    $var_array = (array)$var_array;
	        ob_start();
		extract($var_array);
		include $fullpath;
		$msg=ob_get_clean();
		if ( $return )
		    return $msg;
		//if template exists append
		if ( isset($this->tpl_arr[$type]) )
			$this->tpl_arr[$type] .= $msg;
		else
		    $this->tpl_arr[$type] = $msg;
	}
	else {
	    throw new Exception('file not found '.$fullpath);
	}
    }


    /**
     * render final output
     * @param <type> $return
     * @param <type> $name
     * @return <type>
     */
    function render( $return = false, $name = null ) {
	$name = $name ? $name : $this->template_main;
	$arr = $this->tpl_arr;
	$this->tpl_arr = array();
	if ( $return )
	    return $this->load($name, $this->template_main, $arr, true);
	echo $this->load($name, $this->template_main, $arr, true);
    }
}