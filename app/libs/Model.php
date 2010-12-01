<?php

/**
 *
 * Provides Model functionality
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */

require_once LIB . 'Database.php';

class Model {

    //child class name
    public $model;
    //database table name
    public $table;
    //contains table fields
    public $fields;
    public $db;

    function __construct($id = null) {

        $this->db = new Database();

        $this->model = get_class($this);
        $this->table = strtolower($this->model) . 's';

        $this->init_fields($id);
    }

    /**
     * initialize object with table fields and data if id is provided
     * and record exists
     * @param <type> $id
     */
    function init_fields($id = null) {


        $this->fields = $this->fields();

        if (!empty($id)) {
            $this->get($id);
        } else {
            foreach ($this->fields as $field) {
                $this->{$field} = null;
            }
        }
    }

    /**
     * fetch table fields
     * @return <type>
     */
    function fields() {

        $res = $this->db->query('SHOW COLUMNS FROM ' . $this->table);
        $fields = array();
        while ($row = $res->fetch()) {
//            var_dump($row);
            $fields[] = $row->Field;
        }
        return $fields;
    }

    /**
     * get row by id and initialize object properties
     * @param <type> $id
     * @return Model
     */
    function get($id) {
        $res = $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=?', array($id));
        $row = $res->fetch();
        if ($row) {
            foreach ($row as $key => $val) {
                $this->{$key} = $val;
            }
        }

        return $this;
    }

    /**
     * chech if record exists in a database
     * @return <type>
     */
    function exists() {
        if (!empty($this->id)) {
            $res = $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=?', array($this->id));
            return $res->num_rows() ? true : false;
        }
        return false;
    }

    /**
     * get all records
     * @return <type>
     */
    function get_where() {
        $res = $this->db->query('SELECT * FROM ' . $this->table);
        $arr = array();
        while ($row = $res->fetch()) {
            $arr[] = $row;
        }
        return $arr;
    }

    /**
     * save object to db
     * if object has an id it will be updated else inserted
     * @param <type> $arr
     * @return <type>
     */
    function save($arr = null) {

        //append values from assoc array
        if ($arr) {
            foreach ($this->fields as $key) {
                if (array_key_exists($key, $arr)) {
                    $this->{$key} = $arr[$key];
                }
            }
        }

        $update_arr = array();
        $update_str = array();
        foreach ($this->fields as $key) {
            if (!empty($this->{$key})) {
                $update_str[] = "$key = ?";
                $update_arr[] = $this->{$key};
            }
        }

        $sql = ' SET ' . implode(',', $update_str);

        if ($this->exists()) {
            $sql = "UPDATE " . $this->table . $sql . " WHERE id=?";
            $update_arr[] = $this->id;
        } else {
            $sql = "INSERT INTO " . $this->table . $sql;
        }

        $res = $this->db->query($sql, $update_arr);
        if (empty($this->id)) {
            $this->id = $res->insert_id();
        }

        return $res->affected_rows();
    }

    /**
     * delete object from the table
     * @return <type>
     */
    function delete() {

        if( isset($this->id) ) {
        $res = $this->db->query('DELETE FROM ' . $this->table . ' WHERE id=?', $this->id);
        return $res->affected_rows();
        }
        return false;
    }

}