<?php

require_once 'bootstrap.php';

/**
 * testing album model
 */
class ModelTest extends PHPUnit_Framework_TestCase {

    function setUp() {
        $al = new Album();
        $al->db->query('TRUNCATE albums;');
    }

    function testing_album_exist() {
        $al = new Album();

        $this->assertFalse($al->exists());
        $al->id = 323;
        $this->assertFalse($al->exists());
        $al->title = 'empty';
        $al->save();
        $this->assertTrue($al->exists());
        $album = new Album($al->id);

        $this->assertTrue($album->exists());
    }

    function testing_album_retrieve() {
        $al = new Album();
        $al->title = 'test title';
        $al->save();
        $alb = new Album();
        $alb->title = 'no title';
        $alb->save();

        $arr = $al->get_where();

        $this->assertTrue( is_array($arr));

        $first = reset($arr);
        $this->assertObjectHasAttribute('title', $first);
        $this->assertEquals('test title', $first->title);
    }

}