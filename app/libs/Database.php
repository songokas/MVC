<?php

/**
 *
 * Provides Database layer
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */
class Database {

    public static $conn_id;
    public static $instance;
    //symbol for biding sql queries
    public $bind_marker = '?';
    private $result_id;

    function __construct() {
        $this->init();
    }

    /**
     * retrieve class instance
     * @return <type>
     */
    static function get_instance() {
        if (!self::$instance)
            self::$instance = new Database();
        return self::$instance;
    }

    /**
     * initialize database connection
     */

    function init() {
        $sett = (object) parse_ini_file(APP . 'configs/database.ini');
        $this->conn_id = @mysqli_connect($sett->hostname, $sett->user, $sett->password, $sett->database);
        if (empty($this->conn_id))
            throw new Exception('Unable to connect to database');
        @mysqli_select_db($this->conn_id, $sett->database);
    }

    /**
     * run query
     * @param <string> $query
     * @param <array> $params
     * @return Database
     */
    function query($query, $params = null) {
        $sql = $this->compile_binds($query, $params);
//        var_dump($sql);
        $this->result_id = @mysqli_query($this->conn_id, $sql);
        return $this;
    }

    /**
     * number of rows retrieved
     * @return <type>
     */

    function num_rows() {
        return @mysqli_num_rows($this->result_id);
    }

    /**
     * Insert ID
     *
     * @access	public
     * @return	integer
     */
    function insert_id() {
        return @mysqli_insert_id($this->conn_id);
    }

    /**
     * Affected Rows
     *
     * @access	public
     * @return	integer
     */
    function affected_rows() {
        return @mysqli_affected_rows($this->conn_id);
    }

    /**
     * Result - object
     *
     * Returns the result set as an object
     *
     * @access	private
     * @return	object
     */
    function fetch() {
        return mysqli_fetch_object($this->result_id);
    }

    /**
     * Escape String
     *
     * @access	public
     * @param	string
     * @param	bool	whether or not the string will be used in a LIKE condition
     * @return	string
     */
    function escape($str, $like = FALSE) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escape($val, $like);
            }

            return $str;
        }

        if (function_exists('mysqli_real_escape_string') AND is_object($this->conn_id)) {
            $str = mysqli_real_escape_string($this->conn_id, $str);
        } elseif (function_exists('mysql_escape_string')) {
            $str = mysql_escape_string($str);
        } else {
            $str = addslashes($str);
        }

        // escape LIKE condition wildcards
        if ($like === TRUE) {
            $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
        }

        return '"' . $str . '"';
    }

    /**
     * Compile Bindings
     *
     * @access	public
     * @param	string	the sql statement
     * @param	array	an array of bind data
     * @return	string
     */
    function compile_binds($sql, $binds) {
        if (strpos($sql, $this->bind_marker) === FALSE) {
            return $sql;
        }

        if (!is_array($binds)) {
            $binds = array($binds);
        }

        // Get the sql segments around the bind markers
        $segments = explode($this->bind_marker, $sql);

        // The count of bind should be 1 less then the count of segments
        // If there are more bind arguments trim it down
        if (count($binds) >= count($segments)) {
            $binds = array_slice($binds, 0, count($segments) - 1);
        }

        // Construct the binded query
        $result = $segments[0];
        $i = 0;
        foreach ($binds as $bind) {
            $result .= $this->escape($bind);
            $result .= $segments[++$i];
        }

        return $result;
    }

}