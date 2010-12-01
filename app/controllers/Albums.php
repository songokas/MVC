<?php

/**
 *
 * Provides Albums functionality
 *
 * @package    MVC
 * @author     Tomas Jakstas <bizabrazija@gmail.com>
 * @license    GNU AFFERO GENERAL PUBLIC LICENSE
 */
class Albums extends AdminController {

    function __construct(Request $request, $config) {
        parent::__construct($request, $config);
    }

    function show() {

        $al = new Album();
        $content['albums'] = $al->get_where();
        $this->view->load('content', 'albums/list', $content);
        $this->view->render();
    }

    function edit() {
        $id = $this->request->segment(2);
        $al = new Album($id);
        $content['album'] = $al;
        $this->view->load('content', 'albums/edit', $content);
        $this->view->render();
    }

    function save() {
        $al = new Album();
        $_POST['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES);
        $_POST['author'] = htmlspecialchars($_POST['author'], ENT_QUOTES);
        $al->save($_POST);
        redirect('albums/show');
//        redirect('albums/edit/'.$al->id);
    }

    function delete() {
        $id = $this->request->segment(2);
        $al = new Album($id);
        $al->delete();
        last_page();
    }

}