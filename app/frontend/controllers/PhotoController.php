<?php
namespace Multiple\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class PhotoController extends Controller{

    /**
     * ��Ƭǽ
     */
    public function listAction(){

        $this->view->pick('photo/index');
    }
}