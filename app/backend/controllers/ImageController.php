<?php
namespace Multiple\Backend\Controllers;

use Phalcon\Mvc\Controller;

class ImageController extends Controller{

    /**
     * չʾҳ��
     */
    public function indexAction(){

        $this->view->pick('image/index');
    }

    /**
     * ���ͼƬ
     */
    public function addAction(){

        $this->view->pick('image/add');
    }
}