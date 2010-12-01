<?php

require_once 'bootstrap.php';

require_once APP . 'controllers/Albums.php';
require_once LIB . 'Session.php';
require_once LIB . 'Request.php';


/**
 * testing album controller
 */
class ControllerTest extends PHPUnit_Framework_TestCase {


    function setUp(){
                $al = new Album();
        $al->db->query('TRUNCATE albums;');
    }

    function test_albums_save() {
        $s = new Session();
        //login as the first user
        $s->set_user(new User(1));
        $_SERVER['REQUEST_URI'] = 'albums/save';
//        var_dump($s->user());

        $con = new Albums(new Request(), array());

        //autoincrement starts from 1
        foreach (range(1, 100) as $val) {
            $al = new Album($val);
            $al->delete();

            $_POST['title'] = 'author';
            $_POST['author'] = 'author';
            $con->save();
            $al->get($val);
            $this->assertTrue($al->exists());
        }
    }

    function test_albums_delete() {
        $s = new Session();
        $s->set_user(new User(1));

        foreach (range(1, 100) as $i) {
            $al = new Album($i);
            if (!$al->exists()) {
                $al->title = 'title';
                $al->save();
            }
            $_SERVER['REQUEST_URI'] = 'albums/delete/' . $i;
            $con = new Albums(new Request(), array());
            $con->delete();
            $this->assertTrue($al->exists());
        }
    }

}